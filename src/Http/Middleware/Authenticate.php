<?php

namespace Vis\Builder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->checkIp($request)) {
            return redirect()->to('/');
        }

        try {
            if (! Sentinel::check()) {
                if (Request::ajax()) {
                    $data = [
                        'status'  => 'error',
                        'code'    => '401',
                        'message' => 'Unauthorized',
                    ];

                    return Response::json($data, '401');
                } else {
                    return redirect()->guest('login');
                }
            }
            //check access
            $user = Sentinel::getUser();
            if (! $user->hasAccess(['admin.access'])) {
                Session::flash('login_not_found', 'Нет прав на вход в админку');
                Sentinel::logout();

                return Redirect::route('login_show');
            }
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            Session::flash('login_not_found', 'Пользователь не активирован');
            Sentinel::logout();

            return Redirect::route('login_show');
        }

        return $next($request);
    }

    private function checkIp($request)
    {
        $listIp = [];

        if (is_callable(config('builder.admin.limitation_of_ip'))) {
            $listIp = config('builder.admin.limitation_of_ip')();
        }

        if (is_array(config('builder.admin.limitation_of_ip'))) {
            $listIp = config('builder.admin.limitation_of_ip');
        }

        if (count($listIp)) {
            return in_array($request->ip(), $listIp);
        }

        return true;
    }
}
