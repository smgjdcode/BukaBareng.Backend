<?php
/**
 * Created by PhpStorm.
 * User: satriabagus
 * Date: 5/25/17
 * Time: 9:43 PM
 */

namespace App\Http\Repository;


interface TransactionRepository
{
    public function all();

    public function getById($id);

    public function getByUserId($user_id);

    public function create(array $attributes);
//
    public function updateStatus($id, $status);
//
//    public function delete($id);
//}
}