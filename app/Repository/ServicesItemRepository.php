<?php

namespace App\Repository;

use App\Model\Services\ServicesItem as Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class ServicesItemRepository
 * @package App\Repository
 */
class ServicesItemRepository extends CoreRepository
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
    public function getForTable($filter = null)
    {
        $columns = [
            "services_item.id",
            "services_item.name",
            "services_item.price",
            "clients.name as client_name",
            "services_item.is_deleted",
            "units.name as unit",
            "services_group.name as service_group",
            "services_item.created_at",
            "services_item.updated_at",
        ];
        $result = $this->startCondition();

        $result = $result->select($columns)
            ->orderBy("services_item.created_at", "DESC")
            ->join("services_group", "services_group.id", "service_group_id")
            ->join("units", "units.id", "unit_id")
            ->leftJoin("clients", "clients.id", "services_item.client_id");

        $result = $result->filter();

        return $result->get();
    }

    /**
     * @return mixed
     */
    public function getForSelect()
    {
        $result = $this->startCondition()
            ->select([
                "services_item.id", DB::raw("CONCAT_WS('',`clients`.`short_name`, ' - ' ,`services_item`.`name`) as name")
            ])
            ->leftJoin("clients", "clients.id", "services_item.client_id")
            ->get()
            ->pluck("name", "id")
            ->toArray();
        return $result;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getForCreateJob($id)
    {
        $columns = [
            "services_item.name",
            "services_item.price",
            "units.name as unit",
        ];

        $result = $this->startCondition()
            ->select($columns)
            ->join("units", "services_item.unit_id", "units.id")
            ->firstWhere("services_item.id", $id);

        return $result;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function getForEdit($id, $columns = ["*"])
    {
        return $this->_GetForEdit($id, $columns);
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
}
