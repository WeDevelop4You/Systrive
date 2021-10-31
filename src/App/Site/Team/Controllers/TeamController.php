<?php

namespace App\Site\Team\Controllers;

use App\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $team = [];
//        $users = DB::table('users_profiles')->get(['user_id', 'picture', 'content']);
//
//        foreach ($users as $user) {
//            $user_info = DB::table('users')->where('id', $user->user_id)->first(['first_name', 'last_name', 'role']);
//            $role = DB::table('users_roles')->where('id', $user_info->role)->first('name');
//
//            array_push($team, ['work_function' => $role->name, 'picture' => $user->picture, 'name' => $user_info->first_name . ' ' . $user_info->last_name, 'content' => $user->content]);
//        }

        return response()->json(['status' => 'success', 'team' => $team]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function team(): JsonResponse
    {
        $team = [];
//        $users = DB::table('users_profiles')->take(2)->get(['user_id', 'picture', 'content']);
//
//        foreach ($users as $user) {
//            $user_info = DB::table('users')->where('id', $user->user_id)->first(['first_name', 'last_name', 'role']);
//            $role = DB::table('users_roles')->where('id', $user_info->role)->first('name');
//
//            array_push($team, ['work_function' => $role->name, 'picture' => $user->picture, 'name' => $user_info->first_name . ' ' . $user_info->last_name, 'content' => $user->content]);
//        }

        return response()->json(['status' => 'success', 'team' => $team]);
    }
}
