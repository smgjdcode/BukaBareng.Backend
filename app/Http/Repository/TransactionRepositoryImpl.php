<?php
/**
 * Created by PhpStorm.
 * User: satriabagus
 * Date: 5/25/17
 * Time: 9:48 PM
 */

namespace App\Http\Repository;
use App\Transaction;

class TransactionRepositoryImpl implements TransactionRepository
{
    private $transactionModel;

    public function __construct(Transaction $model)
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
    }


}