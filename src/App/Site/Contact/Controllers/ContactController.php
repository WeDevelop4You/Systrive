<?php

    namespace App\Site\Contact\Controllers;

    use Domain\Contact\Jobs\SendEmail;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;

class ContactController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'company_name' => 'nullable|string',
            'contact_number' => 'nullable|phone:NL',
            'message' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 400);
        }

        SendEmail::dispatch($request->email, $request->name);

        DB::table('wedevelop4you_nl_contact')->insert([
            'title' => $request->name,
            'email' => $request->email,
            'company' => $request->company_name,
            'number' => $request->contact_number,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Email has been sent.']);
    }
}
