<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\RegistryRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getServicesItem() {
        $data = RegistryRepository::get("client")->getForDataTable()->toArray();
        return response()->json(["id" => 1, "name" => "name"]);
    }
}
