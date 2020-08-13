<?php


namespace App\Repository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 * @package App\Repository
 */
abstract class CoreRepository
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Application|Model|mixed
     */
    protected function startCondition()
    {
        return clone $this->model;
    }

    /**
     * @param string $keyAttr
     * @param string $valueAttr
     * @param string $sortColumn
     * @param string $sortMethod
     * @return mixed
     */
    protected function _GetForSelect($keyAttr = "id", $valueAttr = "name", $sortColumn = "created_at", $sortMethod = "DESC")
    {
        $result = $this->startCondition()
            ->orderBy($sortColumn, $sortMethod)
            ->get()
            ->pluck($valueAttr, $keyAttr)
            ->toArray();

        return $result;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    protected function _GetForEdit($id, $columns = ["*"])
    {
        $result = $this->startCondition()
            ->select($columns)
            ->where("id", $id)
            ->first();

        return $result;
    }

    /**
     * @param array $columns
     * @param string $sortColumn
     * @param string $sortMethod
     * @param bool $toBase
     * @return mixed
     */
    protected function _GetAll(Array $columns = ["*"], $sortColumn = "created_at", $sortMethod = "DESC", bool $toBase = true)
    {
        $result = $this->startCondition()
            ->select($columns)
            ->orderBy($sortColumn, $sortMethod);
        if ($toBase) {
            $result = $result->toBase();
        }

        $result = $result->get();

        return $result;
    }
}
