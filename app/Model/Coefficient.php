<?php

namespace App\Model;

use App\Helpers\ModelHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coefficient
 * @package App\Model
 */
class Coefficient extends Model
{
    use ModelHelper;

    /**
     * @var string
     */
    protected $table = "coefficient";

    /**
     * @var array
     */
    protected $fillable = [
        "name",
        "value",
    ];
    /**
     * @var array
     */
    protected $casts = [
        'services_items_id' => 'array',
    ];

    /**
     * @param $data
     * @param null $id
     * @return bool
     */
    public function store($data, $id = null)
    {
        $model = clone $this;

        if ($id != null) {
            $model = $this->where("id", $id)->first();
        }

        $model->setAttribute("services_items_id", $data["services_items_id"] ?? []);

        $model->fill($data);
        return $model->save();
    }

    /**
     * @return array
     */
    public function getServicesItemsId()
    {
        $roles = $this->getAttribute('services_items_id');

        if (is_null($roles)) {
            $roles = [];
        }

        return $roles;
    }

}
