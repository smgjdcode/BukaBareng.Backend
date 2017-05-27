<?php

/**
 * Created by PhpStorm.
 * User: satriabagus
 * Date: 5/25/17
 * Time: 9:39 PM
 */
namespace App\Http\Repository;

interface MassdropRepository
{
    public function all();

    public function getById($id);

    public function getByProductId($id);

    public function updateQuantity($id, $quantity);

    public function create(array $attributes);

//    public function update($id, array $attributes);

//    public function delete($id);
}