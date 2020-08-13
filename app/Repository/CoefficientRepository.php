<?php

namespace App\Repository;

use App\Model\Coefficient as Model;

/**
 * Class CoefficientRepository
 * @package App\Repository
 */
class CoefficientRepository extends CoreRepository
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getForEdit($id)
    {
        return $this->_GetForEdit($id);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->_GetAll();
    }

    /**
     * @return mixed
     */
    public function getForSelect()
    {
        return $this->_GetForSelect("value", "name", "value", "ASC");
    }

}
