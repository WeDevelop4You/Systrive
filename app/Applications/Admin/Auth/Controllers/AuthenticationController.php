<?php

    namespace App\Admin\Auth\Controllers;

    use App\Admin\Auth\Requests\LoginRequest;
    use App\Controller;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Validation\ValidationException;

    class AuthenticationController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index()
        {
            return view('admin::pages.auth.login');
        }

        /**
         * @param LoginRequest $request
         * @return JsonResponse
         */
        public function login(LoginRequest $request): JsonResponse
        {
            try {
                $request->authenticate();

                return response()->json(['redirect' => route('admin.dashboard')]);
            } catch (ValidationException $e) {
                return response()->json(['errors' => $e->errors()], $e->status);
            }
        }

        /**
         * @param Request $request
         * @return Application|Factory|View|JsonResponse
         */
        public function logout(Request $request)
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return $request->expectsJson()
                ? response()->json(['redirect' => route('admin.dashboard')])
                : view('admin::pages.auth.login');
        }
    }
