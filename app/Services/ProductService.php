<?php
namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\IProductRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Echo_;

class ProductService{

    protected $productRepo;
    public function __construct(IProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll(){
        return $this->productRepo->all(['images']);
    }

    public function getById($id){
        $product = Product::with([
            'category',
            'variants.attributes.attribute',
            'variants.attributes.value'
        ])->findOrFail($id);

        $productArray = $product->toArray();

        $attributesList = [];
        $allAttributes = \App\Models\Attribute::with('values')->get();
        foreach ($allAttributes as $attribute) {
            $attributesList[$attribute->name] = $attribute->values->pluck('value')->toArray();
        }
        $productArray['attributes'] = $attributesList;
        foreach ($productArray['variants'] as &$variant) {
            $variantAttributes = [];
            if (isset($variant['attributes']) && is_array($variant['attributes'])) {
                foreach ($variant['attributes'] as $variantAttribute) {
                    if (
                        isset($variantAttribute['attribute']['name']) &&
                        isset($variantAttribute['value']['value'])
                    ) {
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

    public function create(array $data){
        try{
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