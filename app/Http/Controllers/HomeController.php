<?php

namespace App\Http\Controllers;

use App\Model\Clients;
use App\Model\JobLog;
use App\Repository\RegistryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;

class HomeController extends Controller
{
    public function index() {
        /*$jobLogModel = new JobLog();
        $jobLogModel->calcAllTotalPrice();*/

        return view("index", [
            "title" => "Головна",
            "timeLineData" => RegistryRepository::job_log()->getForTimeLine()
        ]);
    }

}
