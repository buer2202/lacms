<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use App\Document;
use App\Attachment;

class DocumentController extends Controller
{
    public function index(Category $category, $did)
    {
        $doc = Document::where('did', $did)->first();
        $cid = $doc->cid;

        // 分类信息
        $cate = $category->where('cid', $cid)->first();

        // 边栏菜单
        if($cate->level == 1) {
            // 如果是顶级分类，菜单为子分类
            $menu = $category->
                where('level', $cate->level + 1)->
                where('parent_cid', $cid)->
                where('status', 1)->
                where('nav_show', 1)->
                get();
        } else {
            // 如果是子分类，菜单是同级分类
            $menu = $category->
                where('level', $cate->level)->
                where('parent_cid', $cate->parent_cid)->
                where('status', 1)->
                where('nav_show', 1)->
                get();
        }

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
        $tpl = 'home.document.' . $doc->template;
        $content = $doc;

        // 如果不存在，默认使用detail模板
        if(!view()->exists($tpl)) {
            $tpl = 'home.document.index';
        }

        return view($tpl, compact('cate', 'banner', 'menu', 'crumbs', 'content'));
    }
}
