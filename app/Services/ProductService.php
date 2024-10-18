<?php
namespace App\Services;

use App\Models\Attribute;
use App\Models\Product;
use App\Repositories\Contracts\ICateRepository;
use App\Repositories\Contracts\IImageRepository;
use App\Repositories\Contracts\IProductRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Echo_;

class ProductService{

    protected $productRepo;
    protected $imageRepo;
    protected $cateRepo;
    public function __construct(IProductRepository $productRepo, IImageRepository $imageRepo, ICateRepository $cateRepo)
    {
        $this->imageRepo = $imageRepo;
        $this->productRepo = $productRepo;
        $this->cateRepo = $cateRepo;
    }

    public function getAll(){
        return $this->productRepo->all(['images']);
    }

    public function getById($id){
        $product = Product::with([
            'images',
            'category',
            'variants.attributes.attribute',
            'variants.attributes.value'
        ])->findOrFail($id);
        $product->makeHidden(['created_at', 'updated_at']);
        $product->category->makeHidden(['created_at', 'updated_at']);
        
        $product->images->makeHidden(['created_at', 'updated_at']);
        $product->variants->each(function ($variant) {
            $variant->makeHidden(['created_at', 'updated_at']);
            $variant->attributes->each(function ($attribute) {
                $attribute->makeHidden(['created_at', 'updated_at']);
            });
        });
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
                    if ( isset($variantAttribute['attribute']['name']) && isset($variantAttribute['value']['value'])) 
                    {
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

    public function getProductByIdCate($id){
        $cates = $this->cateRepo->getCategoryChildren($id);

        $cateids = $cates->pluck('id')->toArray();
        $cateids[] = $id;
        $product = $this->productRepo->whereIn(['images'],'category_id',$cateids);

        return $product;
    }

    public function create(array $data){
        try{
            $product = [
                'name' => $data['name'], 
                'description' =>$data['description'], 
                'price' => $data['price'], 
                'category_id' => $data['category_id'], 
                'public'=>$data['public']
            ];
            return $this->productRepo->create($data);

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,array $data){
        try{
            return $this->productRepo->update($id,$data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    
    public function delete($id){
        try{
            return $this->productRepo->delete($id);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }



}