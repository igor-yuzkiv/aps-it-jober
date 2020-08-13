<?php

namespace App\Repository;

use App\Model\Units as Model;

/**
 * Class UnitsRepository
 * @package App\Repository
 */
class UnitsRepository extends CoreRepository
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

    public function getForEdit($id) {
        return $this->_GetForEdit($id);
    }

}
