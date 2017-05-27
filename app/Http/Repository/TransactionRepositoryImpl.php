<?php
/**
 * Created by PhpStorm.
 * User: satriabagus
 * Date: 5/25/17
 * Time: 9:48 PM
 */

namespace App\Http\Repository;
use App\Buy;

class TransactionRepositoryImpl implements TransactionRepository
{
    private $transactionModel;

    public function __construct(Buy $model)
    {
        $this->transactionModel = $model;
    }

    public function all()
    {
        return $this->transactionModel->paginate(10);
    }

    public function getById($id)
    {
        return $this->transactionModel->find($id);
    }

    public function create(array $attributes)
    {
        $this->transactionModel->create($attributes);
//        $this->transactionModel->save();
    }

    public function getByUserId($user_id){
        $this->transactionModel->where('user_id', $user_id)->get();
    }

    public function updateStatus($id, $status){
        $result = $this->transactionModel->where('id', $id)->update(['status' => $status]);
        return $result;
    }


}