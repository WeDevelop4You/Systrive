<?php

    namespace App\Admin\User\Controllers;

    use Illuminate\Support\Facades\Auth;

    class UserController
    {
        public function index()
        {
            return response()->json(['data' => Auth::user(), 'popup' => [
                'type' => 'Simple',
                'message' => [
                    'type' => 'success',
                    'text' => 'dwa dan daoind anda nda'
                ]
            ]]);
        }
    }
