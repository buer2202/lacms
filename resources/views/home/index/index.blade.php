@extends('home.layouts.app')

@section('content')
<!-- banner begin-->
<div id="banner" style="height:498px;overflow:hidden;">
    <div id="nav"></div>
    <div class="menu_yiny"></div>
</div>
<!-- banner end-->

<!-- content begin-->
<div class="content">
    <div class="xwgg">
        <p class="xwgg_tit"></p>
        @foreach($news->content as $key => $content)
        <dl @if(count($news->content) == $key + 1) style="margin-right:0" @endif>
            <dt>
                <a href="#">{{ mb_substr($content->title, 0, 15) }}</a>
                <a href="#">
                <img src="{{ $content->img }}" /></a>
            </dt>
            <dd>
                <a href="{{ $content->url }}">{{ mb_substr($content->description, 0, 65) }}</a>
            </dd>
        </dl>
        @endforeach

        <div class="clear"></div>
    </div>

<!--     <div class="cpjz">
        <p class="cpjz_tit"></p>

        <ul><li>产品名称</li><li>最新净值</li><li>累计净值</li><li>累计净值增长率</li><li>成立日期</li><li>更新日期</li><li style="margin-right:0;">开放日</li></ul>
        <a href="#"><ul><li>大成1期</li><li>2.5518</li><li>2.5518</li><li>276.52%</li><li>13-03-01</li><li>16-04-01</li><li style="margin-right:0;">每月20日</li></ul></a>
        <a href="#"><ul><li>大成2期</li><li>2.5518</li><li>2.5518</li><li>276.52%</li><li>13-03-01</li><li>16-04-01</li><li style="margin-right:0;">每月20日</li></ul></a>
        <a href="#"><ul><li>大成3期</li><li>2.5518</li><li>2.5518</li><li>276.52%</li><li>13-03-01</li><li>16-04-01</li><li style="margin-right:0;">每月20日</li></ul></a>
        <a href="#"><ul><li>大成4期</li><li>2.5518</li><li>2.5518</li><li>276.52%</li><li>13-03-01</li><li>16-04-01</li><li style="margin-right:0;">每月20日</li></ul></a>
        <a href="#"><ul><li>大成5期</li><li>2.5518</li><li>2.5518</li><li>276.52%</li><li>13-03-01</li><li>16-04-01</li><li style="margin-right:0;">每月20日</li></ul></a>
        <div class="clear"></div>
    </div> -->

    <div class="hzhb">
        <p class="hzhb_tit"></p>
        <ul>
            @foreach($friendlylink->content as $key => $content)
            <li @if(count($friendlylink->content) == $key + 1) style="margin-right:0" @endif>
                <a href="{{ $content->url }}" target="_blank;"><img src="{{ $content->img }}" /></a>
            </li>
            @endforeach
        </ul>
        <div class="clear"></div>
    </div>
</div>
<!-- content end-->
@endsection

@section('js')
<!-- banner切换js 开始-->
<script type="text/javascript" src="/js/bgstretcher.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#banner').bgStretcher({
        images: [@foreach($slideshow->content as $content) '{{ $content->img }}', @endforeach],
        imageWidth: 1920,
        imageHeight: 498,
        slideDirection: 'N',
        slideShowSpeed: 2000,
        nextSlideDelay: 5000,
        transitionEffect: 'fade',
        sequenceMode: 'normal',
        buttonPrev: '#prev',
        buttonNext: '#next',
        pagination: '#nav',
        anchoring: 'center center',
        anchoringImg: 'center center'
    });
});
</script>
<!-- banner切换js 结束-->

<script>window.onerror=hide_error_message;function hide_error_message(){return true;}</script>
@endsection
