<?php

namespace App\Repository;

use App\Filters\JobLogFilter;
use App\Model\JobLog as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class JobLogRepository
 * @package App\Repository
 */
class JobLogRepository extends CoreRepository
{
    use JobLogFilter;

    /**
     * @var array
     */
    public $ReportingColumns = [
        "services_item.name as services_item_name" => "Найменування послуги",
        "job_log.price" => "Вартість без ПДВ",
        "job_log.count" => "Кількість",
        "job_log.coefficient" => "Коефіцієнт",
        "job_log.total_price" => "Сума",
        "clients.name as client_name" => "Клієнт",
        /*"job_log.user_exec"                                 => "Виконавці",*/
        "units.name as unit_name" => "Одиниця виміру",
        "job_log.date_time" => "Дата-час виконання",
        "projects.name as project_name" => "Назва проекту",
        "job_log.comment" => "Коментар",
    ];

    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }


    /**
     * @param $sum
     * @return float
     */
    public function calc_pdv($sum)
    {
//        return round(($sum * 0.2) + $sum, config("my.round"));
        return round(($sum * 1.2), config("my.round.db"));
    }

    /**
     * @param $projectId
     * @return mixed
     */
    public function getByProjectId($projectId)
    {
        $columns = [
            "services_item.name as services_item_name",
            "job_log.id",
            "job_log.price",
            "job_log.coefficient",
            "job_log.count",
            "job_log.total_price",
            "job_log.date_time",
            "job_log.created_at",
            "job_log.updated_at",
            "job_log.user_exec",
            "users.name as user_creator",
            "services_item.id as services_item_id",
            "projects.is_close as project_is_close",
            "units.name as unit",
        ];

        $result = $this->startCondition()
            ->select($columns)
            ->orderBy("created_at", "DESC")
            ->join("users", "users.id", "job_log.user_id")
            ->join("services_item", "services_item.id", "services_item_id")
            ->join("projects", "projects.id", "project_id")
            ->join("units", "units.id", "unit_id")
            ->where("project_id", $projectId);

        $result = $result->get();
        return $result;
    }


    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $columns = [
            "job_log.id",
            "job_log.price",
            "job_log.coefficient",
            "job_log.count",
            "job_log.total_price",
            "job_log.date_time",
            "job_log.created_at",
            "job_log.updated_at",
            "job_log.user_exec",
            "job_log.comment",
            "projects.name as project_name",
            "projects.id as project_id",
            "projects.is_close as project_is_close",
            "users.name as user_create",
            "services_item.id as services_item_id",
            "services_item.name as services_item_name",
            "clients.name as client_name",
        ];

        $result = $this->startCondition()
            ->select($columns)
            ->join("services_item", "services_item.id", "services_item_id")
            ->join("clients", "clients.id", "job_log.client_id")
            ->join("users", "users.id", "job_log.user_id")
            ->leftJoin("projects", "projects.id", "project_id");


        $total = $this->calcTotalFilteredJobLog($result->filter()->get());

        $result = $result->filter()->paginate(config("my.ui_setting.pagination"));

        $result->map(function ($item) {
            $item->services_item_name_order = preg_replace('/^[0-9]+.[0-9]+ - /', '', $item->services_item_name);
        });


        return ["dataTable" => $result, "total" => $total];
    }

    /**
     * @param Collection $data
     * @return array
     */
    private function calcTotalFilteredJobLog(Collection $data): array
    {
        $sum = $data->sum("total_price");
        $total = [
            "total" => $sum,
            "total_pdv" => $this->calc_pdv($sum),
        ];

        return $total;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getForEdit($id)
    {
        return $this->_GetForEdit($id);
    }

    /**
     * @return mixed
     */
    public function reportThisMonth()
    {
        $result = $this->startCondition()
            ->select()
            ->whereMonth('date_time', '=', date('m'))
            ->get();

        return $result;
    }

    /**
     * @param array $request
     * @return JobLogRepository|bool|Builder
     */
    public function getForReportingRaw(array $request)
    {
        if (empty($request))
            return false;

        $result = $this->startCondition()
            ->select($request['columns'] ?? array_keys($this->ReportingColumns))
            ->join("services_item", "services_item.id", "services_item_id")
            ->join("clients", "clients.id", "job_log.client_id")
            ->join("users", "users.id", "job_log.user_id")
            ->join("units", "units.id", "services_item.unit_id")
            ->leftJoin("projects", "projects.id", "project_id")
            ->orderBy("job_log.date_time", "DESC");

        if (isset($request['data_time_between'])) {
            $result = $this->data_time_between($result, $request['data_time_between']);
        }

        if (isset($request['client_id'])) {
            $result = $this->client_id($result, $request['client_id']);
        }
        return $result;
    }


    /**
     * @return array
     */
    public function getForTimeLine()
    {

        $columns = [
            "services_item.name as services_item_name",
            "job_log.total_price",
            DB::raw("DATE (job_log.created_at) as date"),
            DB::raw("TIME (job_log.created_at) as time"),
            "clients.name as client_name",
            "users.name as user_name",
            "projects.name as project_name"
        ];

        $job_log = $this->startCondition()
            ->select($columns)
            ->whereBetween("job_log.created_at", [Carbon::now()->firstOfMonth()->toDateTimeString(), date("Y-m-d") . " 23:59:59"])
            ->join("services_item", "services_item.id", "services_item_id")
            ->join("clients", "clients.id", "job_log.client_id")
            ->join("users", "users.id", "job_log.user_id")
            ->leftJoin("projects", "projects.id", "project_id")
            ->orderBy("job_log.created_at", "DESC")
            ->toBase()
            ->get();

        $result = array();
        $job_log->map(function ($item) use (&$result) {
            if (!key_exists($item->date, $result)) {
                $result[$item->date] = array();
            }
            $result[$item->date][] = $item;
        });

        return $result;
    }

    /**
     * @param $client_id
     * @return array|null
     *
     * Повертає services_item_id які не додано за поточний місяць
     */
    public function checkMonthlyServicesByClientId($client_id)
    {
        $client_monthly = RegistryRepository::client()->getMonthlyServices($client_id);

        if ($client_monthly !== null) {
            /*Перевіряю які послуги додані з тих що вказані клієнту*/
            $services_item = $this->startCondition()
                ->select(["services_item_id", "services_item.name"])
                ->join("services_item", "services_item.id", "job_log.services_item_id")
                ->whereIn("services_item_id", array_column($client_monthly, "services_item_id"))
                ->whereBetween("job_log.date_time", [Carbon::now()->firstOfMonth()->toDateTimeString(), Carbon::now()->lastOfMonth()->toDateTimeString()])
                ->pluck("services_item.name", "services_item_id")
                ->toArray();

            /*Отримую services_item_id ті які не додано*/
            $result = array();
            foreach ($client_monthly as $item) {
                if (!in_array($item["services_item_id"], array_keys($services_item))) {
                    $result[] = $item;
                }
            }

            return (!empty($result)) ? $result : null;
        }
    }

    /**
     * @param $client_id
     * @param null $month
     * @return mixed
     */
    public function getByClientIdGroupServices($client_id, $month = null)
    {

        $columns = [
            "services_item.id",
            "services_item.name",
            DB::raw("ROUND(SUM(job_log.total_price), 2) as total_price"),
            DB::raw("SUM(job_log.count) as count"),
        ];

        $result = $this->startCondition()
            ->select($columns)
            ->where("job_log.client_id", $client_id)
            ->where(DB::raw("MONTH(job_log.date_time)"), $month)
            ->join("services_item", "services_item.id", "job_log.services_item_id")
            ->groupBy(["services_item.id", "services_item.name"])
            ->orderBy("services_item.id")
            ->toBase()
            ->get();

        return $result;
    }


    /**
     * @param $client_id
     * @param null $month
     * @param null $servicesItemExcept
     * @return mixed
     */
    public function getForAccountingReport($client_id, $month = null, $servicesItemExcept = null)
    {
        $columns = [
            "services_group.id",
            "services_group.name",
            DB::raw("SUM(job_log.total_price) as total_price")
        ];

        $month = ($month == null) ? date("m") : $month;



        $result = $this->startCondition()
            ->select($columns)
            ->join("services_item", "services_item.id", "job_log.services_item_id")
            ->join("services_group", "services_group.id", "services_item.service_group_id")
            ->where("job_log.client_id", $client_id)
            ->where(DB::raw("MONTH(job_log.date_time)"), $month);

        if($servicesItemExcept !== null and is_array($servicesItemExcept)) {
            $result = $result->whereNotIn("services_item.id",  $servicesItemExcept);
        }

        $result = $result->orderBy("services_group.id", "ASC")
            ->groupBy("services_group.id", "services_group.name")
            ->get();

        return $result;
    }


}
