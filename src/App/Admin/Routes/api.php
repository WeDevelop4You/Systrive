<?php

    use Illuminate\Http\Request;
    use Support\Helpers\Response\Response;

    Route::delete('delete/session', function (Request $request) {
        Session::forget($request->query('key'));

        return Response::create()->toJson();
    })->name('session.delete');
