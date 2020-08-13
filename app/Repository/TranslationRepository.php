<?php

namespace App\Repository;

use Waavi\Translation\Models\Translation as Model;

/**
 * Class TranslationRepository
 * @package App\Repository
 */
class TranslationRepository extends CoreRepository
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
    public function getForDataTable()
    {
        return $this->_GetAll(["*"], "group", "ASC");
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
