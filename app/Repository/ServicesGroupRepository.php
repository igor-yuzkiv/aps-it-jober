<?php

namespace App\Repository;

use App\Model\Services\ServicesGroup as Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ServicesGroupRepository
 * @package App\Repository
 */
class ServicesGroupRepository extends CoreRepository
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
    public function getAll()
    {
        $columns = [
            "services_group.id",
            "services_group.name",
            "services_group.is_deleted",
            "clients.name as client_name",
            "services_group.created_at",
            "services_group.updated_at",
        ];

        $result = $this->startCondition()
            ->select($columns)
            ->orderBy("created_at", "DESC")
            ->toBase()
            ->leftJoin("clients", "clients.id", "client_id")
            ->get();

        return $result;
    }

    /**
     * @return mixed
     */
    public function getForSelect()
    {
        $result = $this->startCondition()
            ->select(["services_group.id", DB::raw("CONCAT_WS('',`clients`.`short_name`, ' - ' ,`services_group`.`name`) as name")])
            ->orderBy("services_group.name", "ASC")
            ->leftJoin("clients", "clients.id", "client_id")
            ->get()
            ->pluck("name", "id")
            ->toArray();

        return $result;
    }

    /**
     * @param $client_id
     * @param array $columns
     * @return mixed
     */
    public function getByClientId($client_id, $columns = ["*"])
    {
        $check = $this->startCondition()->where("client_id", $client_id)->get();

        $result = $this->startCondition()
            ->select($columns)
            ->leftJoin("clients", "clients.id", "services_group.client_id")
            ->orderBy("id", "ASC");

        if ($check->isEmpty()) {
            $result = $result
                ->whereNull('client_id')
                ->get();
        } else {
            $result = $result
                ->where("client_id", $client_id)
                ->get();
        }
        return $result;
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
