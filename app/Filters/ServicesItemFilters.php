<?php


namespace App\Filters;
use App\Model\Services\ServicesItem;
use Illuminate\Database\Eloquent\Builder;

trait ServicesItemFilters
{
    /**
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function services_item_client_id (Builder $builder, $value) {
        /*$check = $builder -> whereIn("services_item.client_id", $value);*/

        $check = ServicesItem::whereIn("services_item.client_id", $value)->get()->isEmpty();


        if ($check) {
            $result = $builder
                -> whereNull("services_item.client_id");
        }else {
            $result = $builder
                -> whereIn("services_item.client_id", $value);
        }

        return  $result;
    }
}
