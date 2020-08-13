<?php


namespace App\Filters;


use App\User;
use Illuminate\Database\Eloquent\Builder;

trait JobLogFilter
{
    public function data_time_between(Builder $builder, $value)
    {
        $value = explode(' - ', $value);
        return $builder->whereBetween("job_log.date_time", $value);
    }

    public function user_exec(Builder $builder, $value)
    {
        if ($value === null)
            return $builder;
        else
        {
            return $builder->where("job_log.user_exec", "LIKE",  '%"'.$value.'"%');
        }

    }

    public function client_id (Builder $builder, $value) {
        if ($value === null)
            return $builder;
        else
        {
            return $builder->where("job_log.client_id", "=",  $value);
        }
    }
}
