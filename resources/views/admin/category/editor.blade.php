<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    @include('layouts.head')
    <style rel="stylesheet">
        body { padding: 0px; }
        .panel { margin-top: 100px; }
    </style>
</head>
<body id="editor-page">
<div class="container-fluid">

    <ul class="nav nav-tabs" id="nav">
        <li class="active"><a href="#editor" data-toggle="tab">编辑器</a></li>
        @if ($attachment)
            <li><a href="#attachment" data-toggle="tab">附件</a></li>
        @endif
    </ul>


    <div class="tab-content">
        <div id="editor" class="tab-pane active">
            <form method="post" id="form-editor">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="parent_cid">父栏目</label>
                            {!! $categorySelector !!}
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="name">名称</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="栏目名称" value="{{ isset($data['name']) ? $data['name'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="sortord">排序</label>
                            <input type="text" class="form-control" id="sortord" name="sortord" value="{{ isset($data['sortord']) ? $data['sortord'] : 0 }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="nav_sortord">导航栏排序</label>
                            <input type="text" class="form-control" id="nav_sortord" name="nav_sortord" value="{{ isset($data['nav_sortord']) ? $data['nav_sortord'] : 0 }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="path">栏目路径</label>
                            <input type="text" class="form-control" id="path" name="path" value="{{ isset($data['path']) ? $data['path'] : 0 }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="doc_tpl">文章模板</label>
                            <input type="text" class="form-control" id="doc_tpl" name="doc_tpl" value="{{ isset($data['doc_tpl']) ? $data['doc_tpl'] : 'index' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="cate_tpl">列表模板</label>
                            <input type="text" class="form-control" id="cate_tpl" name="cate_tpl" value="{{ isset($data['cate_tpl']) ? $data['cate_tpl'] : 'index' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="seo_title">SEO标题</label>
                            <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="SEO标题" value="{{ isset($data['seo_title']) ? $data['seo_title'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="seo_keywords">SEO关键字</label>
                            <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" placeholder="SEO关键字" value="{{ isset($data['seo_keywords']) ? $data['seo_keywords'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="seo_description">SEO描述</label>
                            <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="SEO描述" value="{{ isset($data['seo_description']) ? $data['seo_description'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="info_1">备选信息1</label>
                            <input type="text" class="form-control" id="info_1" name="info_1" placeholder="备选信息" value="{{ isset($data['info_1']) ? $data['info_1'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="info_1">备选信息2</label>
                            <input type="text" class="form-control" id="info_2" name="info_2" placeholder="备选信息" value="{{ isset($data['info_2']) ? $data['info_2'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="info_1">备选信息3</label>
                            <input type="text" class="form-control" id="info_3" name="info_3" placeholder="备选信息" value="{{ isset($data['info_3']) ? $data['info_3'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="info_1">备选信息4</label>
                            <input type="text" class="form-control" id="info_4" name="info_4" placeholder="备选信息" value="{{ isset($data['info_4']) ? $data['info_4'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="info_1">备选信息5</label>
                            <input type="text" class="form-control" id="info_5" name="info_5" placeholder="备选信息" value="{{ isset($data['info_5']) ? $data['info_5'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="info_1">备选信息6</label>
                            <input type="text" class="form-control" id="info_6" name="info_6" placeholder="备选信息" value="{{ isset($data['info_6']) ? $data['info_6'] : '' }}" />
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="description">栏目介绍</label>
                            <script type="text/plain" id="myEditor" name="description"></script>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" id="cid" name="cid" value="{{ isset($data['cid']) ? $data['cid'] : '' }}" />
                        <input type="hidden" name="text_no" value="{{ $textNo }}" />
                        <button type="button" id="submit" class="btn btn-success">提交</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($attachment)
            <div id="attachment" class="tab-pane">
                <div class="row" style="padding-top: 20px">
                    @foreach ($attachment as $vo)
                        <div class="col-xs-4">
                            <div class="thumbnail">
                                <img src="{{ $vo->uri }}" style="height:200px" />
                                <div class="caption">
                                    <p>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control input-description" value="{{ $vo->description }}" placeholder="请输入附件说明" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default btn-set-description" type="button" data-aid="{{ $vo->aid }}">修改</button>
                                            </span>
                                        </div>
                                    </p>
                                    <p>
                                        @if($vo->type == 1)
                                            @if($data->cover_aid != $vo->aid)
                                                <button class="btn btn-info btn-sm btn-set-cover" data-aid="{{ $vo->aid }}">设为封面</button>
                                            @else
                                                <button class="btn btn-warning btn-sm btn-set-cover" data-aid="{{ $vo->aid }}" disabled>当前封面</button>
                                            @endif
                                        @endif
                                        <button class="btn btn-danger btn-sm btn-del" data-id="{{ $vo->id }}">删除</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- 富文本编译器插件 -->
<script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.all.js"></script>

<!-- 实例化编辑器 -->
<script>
var ue = UE.getEditor('myEditor');

// 自定义参数
// 文章自定义编号，以及图文表名
ue.ready(function() {
    ue.execCommand('serverparam', {
        text_no: "{{ $textNo }}",
        model: "attach_cate",
    });

    ue.setContent('{!! isset($data->description) ? $data->description : "" !!}');

    ue.setHeight(500);
});
</script>

<script>
// CSRF-TOKEN
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$(function() {
    // 提交
    $("#submit").click(function () {
        $.post("{{ $formAction }}", $("#form-editor").serializeArray(), function (data) {
            if(data.status === 1) {
                alert("操作成功");
                window.parent.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 修改附件描述
    $(".btn-set-description").click(function () {
        if(!confirm("确认修改？")) return false;

        $.post("{{ route('asad') }}", {
            aid: $(this).data("aid"),
            description: $(this).parent().siblings(".input-description").val()
        }, function(data) {
            if(data.status === 1) {
                alert("操作成功");
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 设置封面
    $(".btn-set-cover").click(function () {
        if(!confirm("设置封面？")) return false;

        $.post("{{ route('asc') }}", {
            aid: $(this).data("aid"),
            cid: "{{ isset($data->cid) ? $data->cid : 0 }}"
        }, function(data) {
            if(data.status === 1) {
                alert("操作成功");
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 删除附件关联
    $(".btn-del").click(function () {
        if(!confirm("删除附件？")) return false;

        var $that = $(this);
        $.post("{{ route('ada') }}", {
            id: $that.data("id")
        }, function(data) {
            if(data.status === 1) {
                $that.closest(".col-xs-4").remove();
            } else {
                alert(data.info);
            }
        }, "json");
    });
});
</script>
<script>
// iframe自适应高度
function iframeResize() {
    var o = window.document.getElementById("editor-page");
    var h = o.offsetHeight;

    var p = window.parent.document.getElementById("editor");
    if(h <= 1500) {
        p.height = 1500;
    } else {
        p.height = h + 200;
    }
}

iframeResize();

ue.addListener('contentChange', function(editor) {
     iframeResize();
});
</script>
</body>
</html>