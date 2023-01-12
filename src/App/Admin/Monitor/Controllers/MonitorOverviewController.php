<?php

namespace App\Admin\Monitor\Controllers;

use App\Admin\Monitor\Responses\MonitorOverviewResponse;

class MonitorOverviewController
{
    public function index()
    {
        return MonitorOverviewResponse::create()->toJson();
    }
}
