<?php

namespace App\Model;

use App\Helpers\ModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Projects
 * @package App\Model
 */
class Projects extends Model
{
    use ModelHelper;

    /**
     * @var string
     */
    protected $table = "projects";

    /**
     * @var array
     */
    protected $fillable = [
        "name", "comment", "is_close"
    ];

    /**
     * @return HasMany
     */
    public function jobLog()
    {
        return $this->hasMany(JobLog::class, "project_id", "id");
    }

    /**
     * @param $id
     * @return mixed
     */
    public function closeProject($id)
    {
        $model = $this->where("id", $id)->first();

        if ($model->is_close == false) {
            $model->is_close = true;
        } else {
            $model->is_close = false;
        }

        return $model->save();
    }

}


