<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
    <title>大成永兴</title>
    <link rel="stylesheet" type="text/css" href="/css/home.css">
    <style type="text/css">
    .shade {
        width:100%;
        position:absolute;
        background-color:#222;
        opacity:0.9;
        z-index: 9;
    }
    .warning-box {
        position: absolute;
        width: 100%;
        height:0;
    }
    .warning-content{
        position: relative;
        top: 100px;
        margin: 0 auto;
        width: 1000px;
        height:550px;
        background-color: #fff;
        z-index: 10;
    }

    #Container {
      position: absolute;
      width: 100%;
      height: 450px;
      overflow: hidden;
      z-index: 11;
      background-color: #fff;
    }
    .Scroller-Container {
        position: absolute;
        background: transparent;
        padding: 30px 50px;
    }
    .Scroller-Container h3 {
        margin-bottom: 20px;
    }
    #Scrollbar-Container {
      position: absolute;
      top: 20px;
      left: 980px;
      width: 10px;
      height: 340px;
    }
    .Scrollbar-Track {
      width: 10px;
      height: 340px;
    }
    .Scrollbar-Handle {
      position: absolute;
      width: 10px;
      height: 50px;
      background-color: #8b8bff;
      z-index: 11;
    }

    .agree {
        position: relative;
        top: 480px;
        width: 200px;
        margin: 0 auto;
    }
    .agree button {
        width: 80px;
        height: 30px;
    }
    #button-refuse {
        float: right;
    }
    </style>
    <script src="/js/jquery-1.11.3.min.js"></script>

    @if($riskWarning)
    <script type="text/javascript" src="/plugins/jsScrolling/jsScroller.js"></script>
    <script type="text/javascript" src="/plugins/jsScrolling/jsScrollbar.js"></script>
    <script type="text/javascript" src="/plugins/jsScrolling/jsScrollerTween.js"></script>
    <script type="text/javascript">
    window.onload = function () {
        pageHeight = document.body.scrollHeight;
        $(".shade").css('height', pageHeight + 'px');

        scroller  = new jsScroller(document.getElementById("Container"), 270, 330);
        scrollbar = new jsScrollbar(document.getElementById("Scrollbar-Container"), scroller, true);
        scrollTween = new jsScrollerTween(scrollbar, true);
        scrollTween.stepDelay = 30;

        scrollbar._moveContentOld = scrollbar._moveContent;
        scrollbar._moveContent = function () {
        this._moveContentOld();
        var percent = this._y/(this._trackHeight - this._handleHeight);
        document.getElementById("sbLine").style.top = Math.round((this._handleHeight - 5) * percent) +"px";
        };

        $("#button-agree").click(function () {
            $.get('/agreeterms', function (data) {
                $("#risk-warning").hide();
            }, "json");
        });

        $("#button-refuse").click(function () {
            alert("拒绝条款无法浏览网站");
        });
    }
    </script>
    @endif

    @yield('css')
</head>
<body>
    @if($riskWarning)
    <!-- 遵守国家法规->基金网站规定风险提示 -->
    <div id="risk-warning">
        <div class="shade"></div>
        <div class="warning-box">
            <div class="warning-content">
                <div id="Container">
                    <div class="Scroller-Container">
                        <h3>{{ $riskWarning->title }}</h3>
                        <div>{!! $riskWarning->content !!}</div>
                    </div>
                </div>
                <div id="Scrollbar-Container">
                    <div class="Scrollbar-Track">
                        <div class="Scrollbar-Handle"><div class="Scrollbar-Handle" id="sbLine"></div></div>
                    </div>
                </div>
                <div class="agree">
                    <button id="button-agree">接受</button>
                    <button id="button-refuse">拒绝</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- top begin-->
    <div class="top">
        <a href="/"><img class="logo" src="/image/pic/logo.jpg" /></a>
        <div class="menu">
            <ul>
                <li><a href="/">网站首页</a></li>
                @foreach($mainMenu as $menu)
                <li><a href="{{ $menu['path'] }}">{{ $menu['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    <!-- top end-->

    @yield('content')

    <!-- bottom begin-->
    <div class="bottom">
        <div class="bottom_top">
            @foreach($mainMenu as $menu)
            <dl>
                <dt>{{ $menu['name'] }}</dt>

                @if(isset($menu['sub']))
                    @foreach($menu['sub'] as $sub)
                    <dd>
                        <a href="{{ $sub['path'] ?: route('category', ['cid' => $sub['cid']]) }}">{{ $sub['name'] }}</a>
                    </dd>
                    @endforeach
                @endif
            </dl>
            @endforeach

            <div class="bottom_top_kf">
                <p class="bottom_top_kf_1">
                    <img src="/image/pic/index_6.png" />
                </p>
                <p class="bottom_top_kf_2">24小时全天候在线</p>
                <p class="bottom_top_kf_3">
                    在线客服
                    <br />
                    9:00-17:30
                </p>
            </div>
            <!-- <div class="bottom_top_wx">
                <p>微信二维码</p>
                <img src="/image/pic/index_7.jpg" />
                扫一扫 关注有礼
            </div>
            <div class="bottom_top_wx">
                <p>微信二维码</p>
                <img src="/image/pic/index_7.jpg" />
                扫一扫 关注有礼
            </div> -->
            <div class="clear"></div>
        </div>
        <div class="bottom_bot">
            <p>
                武汉大成永兴股权投资基金管理有限公司  地址：武汉市江汉区建设大道737号广发银行大厦23楼1号    服务热线：400-862-0686
                <br />
                Copyright © 2004-2015  武汉大成永兴股权投资基金管理有限公司 版权所有  鄂ICP证00000000号</p>
            <img src="/image/pic/index_8.jpg" />
        </div>
    </div>

    <!-- bottom end-->

    <!-- JavaScripts -->
    @yield('js')
</body>
</html>
