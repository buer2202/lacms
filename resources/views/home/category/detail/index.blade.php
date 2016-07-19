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
            > <a href="{{ $cr['path'] }}">{{ $cr['name'] }}</a>
            @endforeach
            > <span>{{ $cate->name }}</span>
            </p>
        </div>
        <div class="ny_r"><img src="{{ $cate->info_2 }}" /><span>{{ $cate->info_3 }}</span></div>
        <div class="clear"></div>

        <div class="ny_about">{!! $content->description !!}</div>
        <div class="clear"></div>
    </div>
    <!-- ny_right end-->
</div>
@endsection
