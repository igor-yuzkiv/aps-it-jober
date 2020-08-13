<?php

namespace App\Repository;

use App\Model\Clients as Model;

/**
 * Class ClientRepository
 * @package App\Repository
 */
class ClientRepository extends CoreRepository
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
        return $this->_GetAll();
    }

    /**
     * @param $id
     * @return mixed|array
     */
    public function getForEdit($id)
    {
        return $this->_GetForEdit($id);
    }

    /**
     * @return mixed
     */
    public function getForSelect()
    {
        return $this->_GetForSelect("id", "name", "position", "ASC");
    }

    /**
     * @param $id
     * @return array|null
     */
    public function getMonthlyServices($id) {
        $client = $this->startCondition()
            ->whereId($id)
            ->first();

        return ($client)
            ? $client->getAttribute("monthly_services")
            : NULL;
    }


}
