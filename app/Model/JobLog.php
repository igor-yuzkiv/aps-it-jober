<?php

namespace App\Model;

use App\Filters\JobLogFilter;
use App\Helpers\ModelHelper;
use App\Model\Services\ServicesItem;
use App\Repository\RegistryRepository;
use App\User;
use Carbon\Carbon;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * Class JobLog
 * @package App\Model
 */
class JobLog extends Model
{

    use ModelHelper, JobLogFilter, Filterable;

    /**
     * @var string
     */
    protected $table = "job_log";

    /**
     * @var array
     */
    protected $fillable = [
        "services_item_id",
        "user_id",
        "client_id",
        "project_id",
        "price",
        "coefficient",
        "comment",
        "count",
        "total_price",
        'date_time'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'user_exec' => 'array',
        //'date_time' => 'datetime'
    ];

    /**
     * @var array
     */
    private static $whiteListFilter = [
        "data_time_between",
        "user_exec",
        "client_id",
    ];

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return HasOne
     */
    public function project()
    {
        return $this->hasOne(Projects::class, "id", "project_id");
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
    public function services_item()
    {
        return $this->hasOne(ServicesItem::class, "id", "services_item_id");
    }

    /**
     * @return array|mixed
     */
    public function getUserExec()
    {
        $users = $this->getAttribute("user_exec");
        if (is_null($users)) {
            $users = [];
        }
        return $users;
    }

    /**
     * @param $data
     * @param null $id
     * @return bool
     */
    public function store($data, $id = null)
    {
        $this->prepare_data($data);

        $model = clone $this;

        if ($id != null) {
            $model = $this->where("id", $id)->first();
        }

        $data["total_price"] = $this->calc_total_price($data);

        $model = $model->fill($data);
        $model->setAttribute("user_exec", $data['user_exec']);
        $model->user_id = Auth::id();

        $result = $model->save();
        return $result;
    }

    /**
     * @param $data
     */
    public function prepare_data(array &$data)
    {
        $data["coefficient"] = str_replace(",", ".", $data["coefficient"]);
        $data["price"] = str_replace(",", ".", $data["price"]);
    }


    /**
     * @param array $data
     * @return float|int|mixed|string
     */
    public function calc_total_price(array $data)
    {
        $unit = ServicesItem::whereId($data["services_item_id"])->first()->units()->first();

        if ($unit->formula_calc_total !== null) {
            $formula = $unit->formula_calc_total;
            $result = eval ("return" . strtr($formula, $data) . ";");
            $result = number_format((float)$result, config("my.round.db"), ".", "");
            $result = round($result, config("my.round.db"));

        } else {
            $result = ($data["price"] * $data["count"]) * $data["coefficient"];
            $result = number_format((float)$result, config("my.round.db"), ".", "");
            $result = round($result, config("my.round.db"));
        }

        return $result;
    }


    /**
     * @param $value
     * @return string|null
     *
     * Повертає назви користувачів з поля user_exec
     */
    public function getUserExecNameAttribute($value)
    {

        $clients = User::whereIn("id", $this->user_exec)
            ->get()
            ->pluck("name")
            ->toArray();

        if (!empty($clients)) {
            return implode(", ", $clients);
        } else {
            return null;
        }
    }

    /**
     *
     */
    public function calcAllTotalPrice () {
        $jobLogModel = $this->all();

        $jobLogModel->map(function ($item) {
            $total_price = $this->calc_total_price($item->toArray());
            $model = JobLog::where("id", $item->id)->first();
            $model->total_price = $total_price;
            $model->save();
            dump($total_price);
        });
    }

    /**
     * @param $client_id
     * @return array
     */
    public function addMonthlyServicesByClientId($client_id) {
        $no_added = RegistryRepository::job_log()->checkMonthlyServicesByClientId($client_id);

        $result = array();

        if (!empty($no_added)) {
            foreach ($no_added as $key => $item) {
                $services_item = RegistryRepository::services_item()->getForEdit($item["services_item_id"]);

                $data = new JobLog();
                $data->services_item_id = $services_item->id;
                $data->user_id = Auth::id();
                $data->client_id = $client_id;
                $data->price = $services_item->price;
                $data->coefficient = $item["coefficient"];
                $data->setAttribute("user_exec", ["".Auth::id().""]);
                $data->count = 1;
                $data->total_price = $this->calc_total_price($data->toArray());
                $data->date_time = Carbon::now()->toDateTimeString();
                $data->comment = __("basic.messages.comment.job_log.auto.monthly");

                if ($data->save()) {
                    $result["added"][] = [true, "services_item" => $services_item, "job_log" => $data];
                }else {
                    $result["no_added"][] = ["services_item" => $services_item, "job_log" => $data];
                }
            }
        }

        return $result;
    }

}
