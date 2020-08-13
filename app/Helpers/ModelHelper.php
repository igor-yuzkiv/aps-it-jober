<?php


namespace App\Helpers;


trait ModelHelper
{
    /**
     * @param $data
     * @param null $id
     * @return mixed
     */
    public function store($data, $id = null) {
        $model = clone  $this;

        if ($id != null) {
            $model = $this->where("id", $id)->first();
        }
        $model->fill($data);
        return $model->save();
    }

}
