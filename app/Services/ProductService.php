<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\Product;
use App\Repositories\Contracts\ICateRepository;
use App\Repositories\Contracts\IImageRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\IProductVariantRepository;
use App\Repositories\Contracts\IVariantAttributeRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{

    protected $productRepo;
    protected $imageRepo;
    protected $cateRepo;
    protected $prodVariantRepo;
    protected $variAttributeRepo;

    public function __construct(
        IProductRepository $productRepo,
        IImageRepository $imageRepo,
        ICateRepository $cateRepo,
        IProductVariantRepository $prodVariantRepo,
        IVariantAttributeRepository $variAttributeRepo
    ) {
        $this->variAttributeRepo = $variAttributeRepo;
        $this->prodVariantRepo = $prodVariantRepo;
        $this->imageRepo = $imageRepo;
        $this->productRepo = $productRepo;
        $this->cateRepo = $cateRepo;
    }

    public function getAll()
    {
        return $this->productRepo->all(['images']);
    }

    public function getById($id)
    {
        $product = Product::with([
            'images:id,file_name,url,is_primary,product_variant_id,product_id',
            'category:id,name,parent_id',
            'variants.attributes.attribute',
            'variants.attributes.value'
        ])->findOrFail($id, ['id', 'name', 'description', 'price', 'category_id']);
        $productArray = $product->toArray();

        $attributesList = [];
        $allAttributes = Attribute::with('values')->get();
        foreach ($allAttributes as $attribute) {
            $attributesList[$attribute->name] = $attribute->values->pluck('value')->toArray();
        }
        $productArray['attributes'] = $attributesList;
        foreach ($productArray['variants'] as &$variant) {
            $variantAttributes = [];
            if (isset($variant['attributes']) && is_array($variant['attributes'])) {
                foreach ($variant['attributes'] as $variantAttribute) {
                    if (isset($variantAttribute['attribute']['name']) && isset($variantAttribute['value']['value'])) {
                        $attributeName = $variantAttribute['attribute']['name'];
                        $attributeValue = $variantAttribute['value']['value'];
                        $variantAttributes[$attributeName] = $attributeValue;
                    } else {
                        Log::warning("Incomplete variant attribute data for variant ID: {$variant['id']}");
                    }
                }
            } else {
                Log::warning("No attributes found for variant ID: {$variant['id']}");
            }
            $variant['attributes'] = $variantAttributes;
        }

        return $productArray;
    }

    public function getProductByIdCate($id)
    {
        $cates = $this->cateRepo->getCategoryChildren($id);

        $cateids = $cates->pluck('id')->toArray();
        $cateids[] = $id;
        $product = $this->productRepo->whereIn(['images'], 'category_id', $cateids);

        return $product;
    }

    public function paginate(int $page)
    {
        return $this->productRepo->paginate($page,['images']);
    }

    public function search( string $keyword) 
    {
        return $this->productRepo->search(['name','description'], $keyword, ['images']);
    }

    public function create(array $data)
    {

        DB::beginTransaction();
        try {

            $prod = [
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'category_id' => $data['category_id'],
                'public' => $data['public'],
            ];
            $product =  $this->productRepo->create($prod);
            if (!$product) {
                throw new Exception('không thêm được của sản phẩm ',);
            }
            foreach ($data['variant'] as $variantData) {
                $variant = [
                    'product_id' => $product->id,
                    'quantity' => $variantData['quantity'],
                    'sku' => $variantData['sku']
                ];
                $prodVariant = $this->prodVariantRepo->create($variant);
                if (!$prodVariant) {
                    throw new Exception('không thêm được biến thể của sản phẩm ',);
                }

                $attriValue = [
                    'product_variant_id' => $prodVariant->id,
                ];
                foreach ($variantData['atributes'] as $attribute) {
                    $attriValue['attribute_id'] = $attribute['style'];
                    $attriValue['attribute_value_id'] = $attribute['value'];
                    $this->variAttributeRepo->create($attriValue);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            return $this->productRepo->update($id, $data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            return $this->productRepo->delete($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
