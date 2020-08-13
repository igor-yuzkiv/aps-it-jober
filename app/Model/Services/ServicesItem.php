<?php

namespace App\Model\Services;

use App\Filters\ServicesItemFilters;
use App\Helpers\ModelHelper;
use App\Model\Clients;
use App\Model\Units;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Validator;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;


/**
 * Class ServicesItem
 * @package App\Model\Services
 */
class ServicesItem extends Model
{
    use ModelHelper, ServicesItemFilters, Filterable;
    /**
     * @var string
     */
    protected $table = "services_item";

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'service_group_id',
        "unit_id",
        "alias",
        "is_deleted",
        "client_id",
    ];

    /**
     * @var array
     */
    private static $whiteListFilter = [
        "services_item_client_id", /* Filters\ServicesItemFilters */
        "service_group_id",
    ];

    /**
     * @return HasOne
     */
    public function services_group()
    {
        return $this->hasOne(ServicesGroup::class);
    }

    /**
     * @return HasOne
     */
    public function client()
    {
        return $this->hasOne(Clients::class);
    }

    /**
     * @return HasOne
     */
    public function units()
    {
        return $this->hasOne(Units::class, "id", "unit_id");
    }

    /**
     * @param $data
     * @param null $id
     * @return bool`
     */
    public function store($data, $id = null)
    {
        $data["price"] = $this->preparePrice($data["price"]);

        $model = clone $this;
        if ($id != null) {
            $model = $this->where("id", $id)->first();
        }
        $model->fill($data);
        return $model->save();
    }

    /**
     * @param $price
     * @return mixed
     */
    private function preparePrice($price)
    {
        return str_replace(",", ".", $price);
    }


    /**
     * @param array $array
     */
    public function import(array $array)
    {
        foreach ($array as $item) {
            $validator = Validator::make($item, [0 => "", 1 => "required", 2 => "required", 3 => "required", 4 => "required", 5 => "",]);
            if ($validator->fails()) continue;

            $servicesGroup = ServicesGroup::firstOrCreate(['name' => $item[4], "client_id" => $item[5] ?? null]);
            $unit = Units::firstOrCreate(['name' => $item[2]]);

            $fill = [
                "name" => ($item[0] !== null) ? $item[0] . " - " . $item[1] : $item[1],
                "unit_id" => $unit->id,
                "price" => $item[3],
                "service_group_id" => $servicesGroup->id,
                "client_id" => $item[5] ?? null
            ];
            ServicesItem::firstOrCreate($fill);
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function is_deleted($id)
    {
        $model = $this->where("id", $id)->first();

        if ($model->is_deleted == false) {
            $model->is_deleted = true;
        } else {
            $model->is_deleted = false;
        }

        return $model->save();
    }

}
