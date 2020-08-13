<?php

namespace App\Model\Services;

use App\Helpers\ModelHelper;
use App\Model\Clients;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ServiceGroup
 * @package App\Model\Services
 */
class ServicesGroup extends Model
{
    use ModelHelper;

    /**
     * @var string
     */
    protected $table = "services_group";

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        "is_deleted",
        "client_id",
    ];

    /**
     * @return HasMany
     */
    public function services_item()
    {
        return $this->hasMany(ServicesItem::class, "service_group_id", "id");
    }

    /**
     * @return HasOne
     */
    public function client()
    {
        return $this->hasOne(Clients::class);
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
