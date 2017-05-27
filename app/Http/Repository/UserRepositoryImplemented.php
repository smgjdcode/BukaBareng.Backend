<?php
/**
 * Created by PhpStorm.
 * User: satriabagus
 * Date: 5/25/17
 * Time: 9:44 PM
 */

namespace App\Http\Repository;
use App\User;

class UserRepositoryImplemented implements UserRepository
{
    private $userModel;

    public function __construct(User $model)
    {
        $this->userModel = $model;
    }


    public function getById($id){
        return $this->userModel->find($id);
    }

    public function create(array $attributes)
    {
        $this->userModel->create($attributes);
    }


    public function update($id, array $attributes){
        $result = $this->userModel->where('id', $id)->update($attributes);
        return $result;
    }
}