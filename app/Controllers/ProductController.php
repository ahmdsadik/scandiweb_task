<?php

namespace App\Controllers;

use App\Lib\Session;
use App\Lib\Validator;
use App\Models\Product;
use App\Models\ProductType;

class ProductController
{
    public function index()
    {
        $products = Product::getAll();
        view('product.index', compact('products'));
    }

    public function create()
    {
        $types = ProductType::getAll();
        view('product.create', compact('types'));
    }

    public function store()
    {
        $roles = [
            'sku' => 'req|alphanum|unique:products,sku',
            'name' => 'req',
            'price' => 'req|num',
            'type' => 'req|exists:types,name',
        ];


        try {
            $data = $_POST;

            $validator = Validator::validate($roles, $data);
            if ($validator->failed()) {
                flash('errors', $validator->errors());
                redirect('/');
            }

            Product::make($data);
        } catch (\Throwable) {
            redirect(back());
        }

        redirect('/');
    }

    public function destroy()
    {
        try {
            Product::deleteIn('sku', $_POST['deleted'] ?? []);
            redirect('/');
        } catch (\Throwable) {
            redirect(back());
        }
    }
}