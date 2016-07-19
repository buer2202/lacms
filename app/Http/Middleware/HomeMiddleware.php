<?php

namespace App\Http\Middleware;

use Closure;

class HomeMiddleware
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
        // 第一次打开网站，弹出条款层
        session_start();
        if(isset($_SESSION['agree_with_the_terms']) && !empty($_SESSION['agree_with_the_terms'])) {
            $riskWarning = 0;
        } else {
            $riskWarning = \App\Category::where('category.status', '<>', 0)->
                join('document', 'document.cid', '=', 'category.cid')->
                where('category.cid', 22)->
                select('document.*')->
                orderBy('document.sortord', 'desc')->
                first();
        }

        // 共享视图数据
        view()->composer('home.*', function ($view) use ($riskWarning) {
            $view->with('riskWarning', $riskWarning);
        });

        return $next($request);
    }
}
