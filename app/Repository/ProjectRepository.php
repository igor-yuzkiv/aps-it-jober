<?php

namespace App\Repository;

use App\Model\Projects as Model;

/**
 * Class ProjectRepository
 * @package App\Repository
 */
class ProjectRepository extends CoreRepository
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
        $result = $this->startCondition()
            ->orderBy("created_at", "DESC")
            ->where("is_close", false)
            ->get()
            ->pluck("name", "id")
            ->toArray();
        return $result;
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
