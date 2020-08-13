<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

return [
    "users" => [
        "avatar" => [
            "path" => "public/users/avatars",
            "default" => "public/users/avatars/default.png"
        ]
    ],
    /*Знаків після коми*/
    "round" => [
        "db" => 2,
        "public" => 2
    ],

    "monthly_services_id" => [24,25,26,27,34,35,37],

    "ui_setting" => [
        "pagination" => 50
    ]

];
