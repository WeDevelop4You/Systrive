<?php

namespace App\Misc\Session\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Support\Client\Response;

class DeleteSessionController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request): \Illuminate\Http\Response
    {
        Session::forget($request->query('key'));

        return Response::create()->toJson();
    }
}
