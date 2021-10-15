<?php

    namespace App\Site\Information\Controllers;

    use App\Controller;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;
    use shweshi\OpenGraph\OpenGraph;

    class InfoController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return JsonResponse
         */
        public function about()
        {
            $about = new \stdClass();

//            $about = DB::table('wedevelop4you_nl_about')->first('about');

            return response()->json(['status' => 'success', 'about' => $about]);
        }

        /**
         * Display a listing of the resource.
         *
         * @return JsonResponse
         */
        public function websites()
        {
            $websites = [];

//            $links = DB::table('wedevelop4you_nl_websites')->get('link');
//
//            foreach ($links as $link) {
//                $websites[] = (new OpenGraph)->fetch($link->link, true);
//            }

            return response()->json(['status' => 'success', 'websites' => $websites]);
        }
    }
