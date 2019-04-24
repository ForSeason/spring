<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use App\User;
use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = array('account', 'token');
        if ($request->has($params)) {
            $user = User::where('account', $request->account)->first();
            if (empty($user) || $request->token != $user->token)
                return response(array('message' => '您的账号已在别处登录！'), 401);
        }
        return $next($request);
    }
}
