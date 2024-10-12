<?php
namespace App\Services;

use App\Repositories\Contracts\IProductRepository;

class ProductService{

    protected $productRepo;
    public function __construct(IProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll(){
        return $this->productRepo->all();

    }


}