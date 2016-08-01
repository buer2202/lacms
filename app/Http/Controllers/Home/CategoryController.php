<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use App\Document;
use App\Attachment;

class CategoryController extends Controller
{
    public function index(Category $category, $cid)
    {

        // 分类信息
        $cate = $category->where('cid', $cid)->where('status', 1)->where('nav_show', 1)->first();
        if(!$cate) abort(404);
        if($cate->parent_cid == 3) return redirect()->route('product');    // 屏蔽产品分类

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
        $tpl = 'home.category.detail.' . $cate->doc_tpl;
        $content = $cate;

        // 优先选取列表模板，如果没有则选取文章模板
        if($cate->cate_tpl) {
            // 内容
            $list = Document::leftJoin('attachment', 'attachment.aid', '=', 'document.cover_aid')->
                where('cid', $cid)->
                where('status', 1)->
                select(
                    'document.did',
                    'document.title',
                    'document.title_sub',
                    'document.time_last_modify',
                    'document.seo_description',
                    'attachment.uri'
                )->
                orderBy('sortord', 'desc')->
                orderBy('time_create', 'desc')->
                paginate(5);

            // 第一篇文章的封面图片
            if($list->count()) {
                $tpl = 'home.category.lists.' . $cate->cate_tpl;
                $content = $list;
            }
        }

        // 如果不存在，默认使用detail模板
        if(!view()->exists($tpl)) {
            $tpl = 'home.category.detail.index';
        }

        return view($tpl, compact('cate', 'banner', 'menu', 'crumbs', 'content'));
    }
}
