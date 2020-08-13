<?php

namespace App\Model;

use App\Helpers\ModelHelper;
use App\Model\Services\ServicesGroup;
use App\Model\Services\ServicesItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ZeroDaHero\LaravelWorkflow\Traits\WorkflowTrait;

/**
 * Class Clients
 * @package App\Model
 */
class Clients extends Model
{
    use ModelHelper;

    /**
     * @var string
     */
    protected $table = "clients";

    protected $fillable = [
        "name", "position", "short_name"
    ];

    protected $casts = [
        "monthly_services" => "array"
    ];

    /**
     * @return HasMany
     */
    public function jobLog()
    {
        return $this->hasMany(JobLog::class, "client_id", "id");
    }

    /**
     * @return HasMany
     */
    public function services_item()
    {
        return $this->hasMany(ServicesItem::class, "client_id", "id");
    }

    /**
     * @return HasMany
     */
    public function services_group()
    {
        return $this->hasMany(ServicesGroup::class, "client_id", "id");
    }


    /**
     * @param $data
     * @param null $id
     * @return mixed
     */
    public function store($data, $id = null)
    {
        $model = clone $this;

        if ($id != null) {
            $model = $this->where("id", $id)->first();

            if (isset($data["monthly_services"])){
                $monthly_services = $model->getAttribute("monthly_services");
                if ($monthly_services !== null) {
                    $monthly_services = array_values($monthly_services);
                    $monthly_services[] = $data["monthly_services"][0];
                    $monthly_services = collect($monthly_services)->unique("services_item_id")->toArray();
                    $model = $model->setAttribute("monthly_services", $monthly_services);
                } else {
                    $model = $model->setAttribute("monthly_services", $data["monthly_services"]);
                }
            }
        }

        $model->fill($data);
        return $model->save();
    }

    /**
     * @param $id
     * @param $services_item_id
     * @return bool
     */
    public function delete_monthly_service_item($id, $services_item_id)
    {
        $model = $this->where("id", $id)->first();

        $monthly_services = $model->getAttribute("monthly_services");
        if ($monthly_services !== null) {
            $monthly_services = array_values($monthly_services);

            $key = array_search($services_item_id, array_column($monthly_services, "services_item_id"));
            unset($monthly_services[$key]);
            $model->setAttribute("monthly_services", array_values($monthly_services));

            return $model->save();
        } else
            return false;
    }


}
