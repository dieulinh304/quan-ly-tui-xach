<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ISanphamRepository
{
    public function allProduct();
    public function featuredProducts();
    public function randomProduct();
    public function searchProduct(Request $request);
    public function getAllByDanhMuc(Request $request);
    public function getProductsByCategory($categoryId);
}