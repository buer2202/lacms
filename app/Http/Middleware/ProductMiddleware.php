<?php

namespace App\Http\Middleware;

use Closure;

use App\FofUser;

class ProductMiddleware
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
        $key = config('session.fof_user_session_key');

        // 如果是ajax登陆请求且未登陆，则登陆
        if($request->ajax() && !$request->session()->has($key)) {
            $id_type = $request->input('id_type', 1);
            $id_number_last_6 = $request->input('id_number', '');

            $fofUser = FofUser::join('fof_user_products as p', 'p.fuid', '=', 'fof_users.fuid')->
                where('type', $id_type)->
                where('id_number_last_6', $id_number_last_6)->
                select('fof_users.*')->
                first();

            if(!$fofUser) {
                return ['status' => 0, 'info' => '提示：身份证号错误或未注册'];
            }

            $request->session()->put($key, ['fuid' => $fofUser->fuid, 'name' => $fofUser->name]);
            return ['status' => 1];
        }

        return $next($request);
    }
}
