<?php

namespace App\Models;

class Book extends Product
{
    public function __construct($data = [])
    {
        parent::__construct($data['sku'], $data['name'], $data['price']);
        $this->setAttrName('weight');
        $this->setAttrValue($data['weight']);
    }
}