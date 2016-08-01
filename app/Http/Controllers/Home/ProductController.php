<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use App\Attachment;
use App\Document;
use App\FofUserProduct;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('product', ['only' => ['index']]);
    }

    public function index(Request $request, Category $category, $cid = 0)
    {
        $fuser = $request->session()->get(config('session.fof_user_session_key'));
        $fuid = isset($fuser['fuid']) ? $fuser['fuid'] : 0;

        $cateIds = FofUserProduct::where('fuid', $fuid)->lists('cid')->toArray();
        if(!$cateIds) {
            $cateIds = [15];
        }

        // 分类信息
        $cid = $cid ?: $cateIds[0];
        $cate = $category->where('cid', $cid)->where('status', 1)->where('nav_show', 1)->first();
        if(!$cate) abort(404);

        // 边栏菜单
        $menu = $category->
            whereIn('cid', $cateIds)->
            where('status', 1)->
            where('nav_show', 1)->
            get();

        // 面包屑
        $crumbs = $category->parents($cid);
        if($crumbs) {
            krsort($crumbs);
        } else {
            $crumbs = [];
        }

        // banner
        $parentTop = array_first($crumbs) ?: $cate;
        $banner = Attachment::where('aid', $parentTop['cover_aid'])->first();
        $banner = $banner ? $banner->uri : '';

        // 默认视图
        $content = $cate;

        return view('home.product.index', compact('fuser', 'cate', 'banner', 'menu', 'crumbs', 'content'));
    }

    // 注销
    public function logout(Request $request)
    {
        $request->session()->forget(config('session.fof_user_session_key'));
        return redirect()->route('product');
    }
}
