<?php

namespace App\Repository;

use App\User as Model;

/**
 * Class UsersRepository
 * @package App\Repository
 */
class UsersRepository extends CoreRepository
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return mixed
     */
    public function getForSelect()
    {
        return $this->_GetForSelect();
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->_GetAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getForEdit($id)
    {
        return $this->_GetForEdit($id);
    }
}
