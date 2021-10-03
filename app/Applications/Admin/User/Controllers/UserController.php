<?php

    namespace App\Admin\User\Controllers;

    use Illuminate\Support\Facades\Auth;

    class UserController
    {
        public function index()
        {
            return response()->json(Auth::user());
        }
    }
