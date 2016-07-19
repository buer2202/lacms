@extends('layouts.app')

@section('css')
<style type="text/css">
.tree .name {font-weight: bold;}
.tree ul {margin-left: 2em; margin-bottom: 0; display: none;}
.tree>ul {margin-left: 0; display: block;}
.tree ul li {line-height: 35px;}
.tree ul li button {margin-left: 5px;}
.tree .info {padding: 0 5px;}
.tree .info:hover {background: #f0f0f0;}
.set-navshow {margin-right: 5px;}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h3 class="col-md-12">栏目管理</h3>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-body tree">
                    <button type="button" id="add-root" class="btn btn-default btn-sm">添加新栏目</button>
                    {{ outputTree($tree) }}
                </div>
            </div>
        </div>
        <div class="col-md-7" id="editor-box" style="display: none;">
            <iframe id="editor" style="width:100%;border: none;" scrolling="no"></iframe>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(function () {
    // 工具提示
    // $('.tree button').tooltip();

    // ajax请求头添加csrf令牌
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });


    // 添加新栏目
    $("#add-root").click(function () {
        $("#editor").attr("src", "/admin/category/editor");
        $("#editor-box").show();
        $(".tree .info").removeClass("bg-info");
        return false;
    });

    // 添加栏目
    $(".add").click(function () {
        $("#editor").attr("src", "/admin/category/editor/0/" + $(this).data("cid"));
        $("#editor-box").show();
        $(".tree .info").removeClass("bg-info");
        $(this).parents('.info').addClass("bg-info");
        return false;
    });

    // 编辑栏目
    $(".edit").click(function () {
        $("#editor").attr("src", "/admin/category/editor/" + $(this).data("cid") + "/0");
        $("#editor-box").show();
        $(".tree .info").removeClass("bg-info");
        $(this).parents('.info').addClass("bg-info");
        return false;
    });

    // 设置栏目状态
    $(".set-status").click(function () {
        var $this = $(this), status = $this.data("status");
        if(status == 0 && !confirm("确认删除")) return false;

        $.post("/admin/category/ajaxsetstatus", {
            cid: $this.data("cid"),
            status: status
        }, function (data) {
            if(data.status === 1) {
                if(status == 0) {
                    window.location.reload();
                } else if (status == 1) {
                    $this.removeClass('btn-success').addClass('btn-warning').data('status', 2).attr('title', '禁用本栏目')
                        .find('span').removeClass('glyphicon-ok-circle').addClass('glyphicon-ban-circle');
                } else {
                    $this.removeClass('btn-warning').addClass('btn-success').data('status', 1).attr('title', '启用本栏目')
                        .find('span').removeClass('glyphicon-ban-circle').addClass('glyphicon-ok-circle');
                }
            } else {
                alert(data.info);
            }
        }, "json");
        return false;
    });

    // 设置导航栏显示
    $(".set-navshow").click(function () {
        var $this = $(this), navshow = $this.data('navshow');
        $.post("/admin/category/ajaxsetnavshow", {
            cid: $this.data("cid"),
            navshow: navshow
        }, function (data) {
            if(data.status === 1) {
                if(navshow) {
                    $this.removeClass('btn-warning').addClass('btn-success').data('navshow', 0).attr('title', '导航栏显示，点击不显示')
                        .find('span').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                } else {
                    $this.removeClass('btn-success').addClass('btn-warning').data('navshow', 1).attr('title', '导航栏不显示，点击显示')
                        .find('span').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                }
            } else {
                alert(data.info);
            }
        }, "json");
        return false;
    });

    $('.info').click(function () {
        var $this = $(this), $arraw = $this.children('.glyphicon');
        if($arraw.length) {
            if($arraw.is('.glyphicon-chevron-right')) {
                $arraw.removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down')
                    .parent().siblings('ul').slideDown();
            } else {
                $arraw.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right')
                    .parent().siblings('ul').slideUp();
            }
        }
    });

    $('.tree ul li .info').each(function () {
        var $this = $(this);
        if($this.siblings('ul').length == 0) {
            $this.css('padding-left', '19px').children('.glyphicon').remove();
        }
    });
});
</script>
@endsection

<?php
function outputTree ($tree) {
    foreach($tree as $leaf) {
        echo '<ul class="list-unstyled">';
        echo '<li>';
        echo     '<div class="info clearfix">';
        echo         '<span class="glyphicon glyphicon-chevron-right"></span>';

        if($leaf['nav_show'] == 1) {
            echo     '<button type="button" class="btn btn-success btn-xs set-navshow" data-navshow="0" data-cid="' . $leaf['cid'] . '" data-placement="top" title="导航栏显示，点击不显示">';
            echo         '<span class="glyphicon glyphicon-eye-open"></span>';
            echo     '</button>';
        } else {
            echo     '<button type="button" class="btn btn-warning btn-xs set-navshow" data-navshow="1" data-cid="' . $leaf['cid'] . '" data-placement="top" title="导航栏不显示，点击显示">';
            echo         '<span class="glyphicon glyphicon-eye-close"></span>';
            echo     '</button>';
        }

        echo         '<span class="name">[' . $leaf['cid'] . '] ' . $leaf['name'] . '</span>';
        echo         '<p class="pull-right">';
        echo             '<button type="button" class="btn btn-primary btn-xs add" data-cid="' . $leaf['cid'] . '" data-placement="top" title="添加子栏目">';
        echo                 '<span class="glyphicon glyphicon-plus"></span>';
        echo             '</button>';
        echo             '<button type="button" class="btn btn-info btn-xs edit" data-cid="' . $leaf['cid'] . '" data-placement="top" title="编辑本栏目">';
        echo                 '<span class="glyphicon glyphicon-edit"></span>';
        echo             '</button>';

        if($leaf['status'] == 1) {
            echo         '<button type="button" class="btn btn-warning btn-xs set-status" data-status="2" data-cid="' . $leaf['cid'] . '" data-placement="top" title="禁用本栏目">';
            echo             '<span class="glyphicon glyphicon-ban-circle"></span>';
            echo         '</button>';
        } else {
            echo         '<button type="button" class="btn btn-success btn-xs set-status" data-status="1" data-cid="' . $leaf['cid'] . '" data-placement="top" title="启用本栏目">';
            echo             '<span class="glyphicon glyphicon-ok-circle"></span>';
            echo         '</button>';
        }

        echo             '<button type="button" class="btn btn-danger btn-xs set-status"  data-status="0" data-cid="' . $leaf['cid'] . '" data-placement="top" title="删除本栏目及子栏目">';
        echo                 '<span class="glyphicon glyphicon-remove-circle"></span>';
        echo             '</button>';
        echo         '</p>';
        echo     '</div>';
        if(isset($leaf['branch'])) {
            outputTree($leaf['branch']);
        }
        echo "</li>";
        echo '</ul>';
    }
}
?>