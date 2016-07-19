<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Group;

class IndexController extends Controller
{
    public function index(Group $group)
    {
        // 图片轮播
        $slideshow = $group->getGroupContent(1);

        // 新闻公告
        $news = $group->getGroupContent(2, 3);

        // 友情链接
        $friendlylink = $group->getGroupContent(3, 6);

        return view('home.index.index', compact('slideshow', 'news', 'friendlylink'));
    }

    // 同意条款
    public function agreeterms()
    {
        if(!isset($_SESSION['agree_with_the_terms'])) {
            $_SESSION['agree_with_the_terms'] = 1;
        }

        return 1;
    }
}
