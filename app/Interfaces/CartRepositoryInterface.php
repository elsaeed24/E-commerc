<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    public function getAll();

    public function add($product_id , $quantity = 1);

    public function update($product_id,$quantity);

    public function delete($product_id);

    public function empty();

    public function total();
}
