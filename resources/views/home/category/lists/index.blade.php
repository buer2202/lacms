@extends('home.layouts.app')

@section('content')
 <!-- banner begin-->
<div class="ny_banner_about" style="background:url({{ $banner }}) center top no-repeat"></div>
<!-- banner end-->

<div class="ny">
    <!-- ny_left begin-->
    <div class="ny_left">
        <p class="ny_left_tit"><img src="{{ $cate->info_1 }}" /></p>
        <ul class="ny_left_ul">
            @foreach($menu as $m)
            <li @if($m['cid'] == $cate->cid) class="ny_left_on" @endif><a href="{{ $m['path'] ?: route('category', ['cid' => $m['cid']]) }}">{{ $m['name'] }}</a></li>
            @endforeach
            <li></li>
        </ul>
    </div>
    <!-- ny_left end-->

    <!-- ny_right begin-->
    <div class="ny_right">
        <div class="ny_r_tit">
            <p>当前位置：<a href="{{ url('/') }}">首页</a>
            @foreach($crumbs as $cr)
            > <a href="{{ route('category', ['cid' => $cr['cid']]) }}">{{ $cr['name'] }}</a>
            @endforeach
            > <span>{{ $cate->name }}</span>
            </p>
        </div>
        <div class="ny_r"><img src="{{ $cate->info_2 }}" /><span>{{ $cate->info_3 }}</span></div>
        <div class="clear"></div>

        <div class="ny_news">
            @foreach($content as $doc)
            <dl>
                <dt><a href="{{ route('document', ['did' => $doc->did]) }}"><img src="{{ $doc->uri }}" /></a></dt>
                <dd>
                    <h1><a href="{{ route('document', ['did' => $doc->did]) }}">{{ $doc->title }}</a></h1>
                    <p>{{ $doc->seo_description }}</p>
                    <a class="xq" href="{{ route('document', ['did' => $doc->did]) }}">【详细】</a>
                </dd>
            </dl>
            @endforeach
        </div>
        <div class="clear"></div>

        <!-- 程序分页div begin-->
        {!! $content->links() !!}
        <!-- 程序分页div end-->
    </div>
    <!-- ny_right end-->

</div>
@endsection
