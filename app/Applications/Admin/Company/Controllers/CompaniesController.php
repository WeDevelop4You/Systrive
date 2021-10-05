<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyDetailResource;
    use App\Controller;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class CompaniesController extends Controller
    {
        public function index()
        {
            $companies = Auth::user()->companies;

            $response = new Response();
            $response->addData($companies, CompanyDetailResource::class, true);

            return $response->toJson();
        }
    }
