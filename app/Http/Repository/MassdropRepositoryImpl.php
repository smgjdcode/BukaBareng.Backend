<?php
/**
 * Created by PhpStorm.
 * User: satriabagus
 * Date: 5/25/17
 * Time: 9:48 PM
 */

namespace App\Http\Repository;

use App\Massdrop;

class MassdropRepositoryImpl implements MassdropRepository
{
    private $massdropmodel;


    public function __construct(Massdrop $model)
    {
        $this->massdropmodel = $model;
    }


    public function all()
    {
        return $this->massdropmodel->paginate(10);
    }

    public function getById($id){
        return $this->massdropmodel->find($id);
    }

    public function getByProductId($id)
    {
        return $this->massdropmodel->where('product_id', $id)->get();
    }

    public function create(array $attributes)
    {
        $this->massdropmodel->create($attributes);
    }


}