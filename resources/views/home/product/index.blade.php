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
        @if($fuser)
        <div class="ny_r_tit">
            <p>当前位置：<a href="{{ url('/') }}">首页</a>
            @foreach($crumbs as $cr)
            > <a href="{{ $cr['path'] }}">{{ $cr['name'] }}</a>
            @endforeach
            > <span>{{ $cate->name }}</span>
            </p>
        </div>
        <div class="ny_r"><img src="{{ $cate->info_2 }}" />
            <span>
                欢迎：{{ $fuser['name'] }}
                |
                <a href ="/fofuserlogout" style="font-size:12px;">退出查询</a>
                </span>
        </div>
        <div class="clear"></div>

        <div class="ny_about">{!! $content->description !!}</div>
        <div class="clear"></div>
        @else
        <div class="ny_about">请先登录</div>
        @endif
    </div>
    <!-- ny_right end-->
</div>
@endsection

@section('js')
<script src="/plugins/layer/layer.js"></script>
<script>
$(function () {
    @if(!$fuser)
    layer.open({
        type: 1,
        title: '净值查询',
        skin: 'layui-layer-rim', //加上边框
        area: ['420px', '240px'], //宽高
        content: '<div class="login_fromp"><div class="login_type"><div class="lt_1 login_type_on">个&nbsp;&nbsp;&nbsp;&nbsp;人</div><div class="lt_2">机&nbsp;&nbsp;&nbsp;&nbsp;构</div></div><div style="font-size:12px;padding:50px 0 0 10px;color:#b9a17b;">投资人无需注册，快速查阅</div><div class="login_fromp lf_1"><div class="input-box">帐号：<input type="text" name="id_number" class="ipt"><input type="hidden" name="id_type" value="1" /><span style="color: #ff0000;font-size:12px;"> (*请输入身份证后6位)</span></div><div class="login_formp_sub"><a class="btn btn-primary" id="login_submit">查 阅</a></div><input type="hidden" name="l_type" id="l_type" value="2"></div><div class="login_tips">提示：身份证号错误或未注册</div></div>'
    });
    @endif

    // 切断登陆类型
    $(".login_type .lt_1").click(function () {
        $(".input-box span").text(' (*请输入身份证后6位)');
        $(this).addClass('login_type_on').siblings().removeClass('login_type_on');
        $("[name='id_type']").val(1);
    });

    // 切断登陆类型
    $(".login_type .lt_2").click(function () {
        $(".input-box span").text(' (*请输入营业执照后6位)');
        $(this).addClass('login_type_on').siblings().removeClass('login_type_on');
        $("[name='id_type']").val(2);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        }
    });

    // 提交
    $("#login_submit").click(function () {
        var id_type = $("[name='id_type']").val();
        var id_number = $("[name='id_number']").val();

        if(id_number.length != 6) {
            if(id_type == 1) {
                layer.alert('请输入身份证后6位');
            } else {
                layer.alert('请输入营业执照后6位');
            }

            return false;
        }

        $.post("{{ route('product') }}", {
            "id_type": id_type,
            "id_number": id_number
        }, function (data) {
            if(data.status !== 1) {
                layer.alert(data.info);
            } else {
                window.location.reload();
            }
        }, "json");
    });
});
</script>
@endsection
