<?php

namespace App\Model;

use App\Helpers\ModelHelper;
use App\Model\Services\ServicesItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Units
 * @package App\Model
 */
class Units extends Model
{
    use ModelHelper;

    /**
     * @var string
     */
    protected $table = "units";

    /**
     * @var array
     */
    protected $fillable = [
        "name",
        "formula_calc_total"
    ];

    /**
     * @return HasMany
     */
    public function services_item()
    {
        return $this->hasMany(ServicesItem::class, "unit_id", "id");
    }
}
