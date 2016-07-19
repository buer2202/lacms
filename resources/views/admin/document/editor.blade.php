@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="col-md-12">
            <p class="col-md-3">文档编辑器</p>
        </h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="nav">
                <li class="active"><a href="#editor" data-toggle="tab">编辑</a></li>
                @if($attachment)
                    <li><a href="#attachment" data-toggle="tab">附件</a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div id="editor" class="tab-pane active">
            <form method="post" id="form-edit" action="{{ $formAction }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cid">所属栏目</label>
                            {!! $categorySelector !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title">文档标题</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ isset($row->title) ? $row->title : '' }}" placeholder="文档标题" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title_sub">子标题</label>
                            <input type="text" class="form-control" id="title_sub" name="title_sub" value="{{ isset($row->title_sub) ? $row->title_sub : '' }}" placeholder="子标题" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="template">模板</label>
                            <input type="text" class="form-control" id="template" name="template" value="{{ isset($row['template']) ? $row['template'] : 'index' }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">状态</label>
                            <select class="form-control" name="status">
                                <option value="1" {{ isset($row->status) && $row->status == 1 ? 'selected' : '' }}>正常</option>
                                <option value="2" {{ isset($row->status) && $row->status == 2 ? 'selected' : '' }}>禁用</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filename">文件名</label>
                            <input type="text" class="form-control" id="filename" name="filename" value="{{ isset($row->filename) ? $row->filename : '' }}" placeholder="文件名" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sortord">排序</label>
                            <input type="text" class="form-control" id="sortord" name="sortord" value="{{ isset($row->sortord) ? $row->sortord : '' }}" value="0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time_document">文档时间</label>
                            <input type="text" class="form-control" id="time_document" name="time_document" value="{{ isset($row['time_document']) && $row->time_document > 0 ? date('Y-m-d', $row['time_document']) : date('Y-m-d') }}" readonly />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seo_title">SEO-标题</label>
                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ isset($row->seo_title) ? $row->seo_title : '' }}" placeholder="SEO-标题" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seo_keywords">SEO-关键字</label>
                            <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" value="{{ isset($row->seo_keywords) ? $row->seo_keywords : '' }}" placeholder="SEO-关键字" />
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="seo_description">SEO-描述</label>
                            <input type="text" class="form-control" id="seo_description" name="seo_description" value="{{ isset($row->seo_description) ? $row->seo_description : '' }}" placeholder="SEO-描述" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="info_1">备选信息1</label>
                            <input type="text" class="form-control" id="info_1" name="info_1" value="{{ isset($row->info_1) ? $row->info_1 : '' }}" placeholder="备选信息" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="info_2">备选信息2</label>
                            <input type="text" class="form-control" id="info_2" name="info_2" value="{{ isset($row->info_2) ? $row->info_2 : '' }}" placeholder="备选信息" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="info_3">备选信息3</label>
                            <input type="text" class="form-control" id="info_3" name="info_3" value="{{ isset($row->info_3) ? $row->info_3 : '' }}" placeholder="备选信息" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="info_4">备选信息4</label>
                            <input type="text" class="form-control" id="info_4" name="info_4" value="{{ isset($row->info_4) ? $row->info_4 : '' }}" placeholder="备选信息" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="info_5">备选信息5</label>
                            <input type="text" class="form-control" id="info_5" name="info_5" value="{{ isset($row->info_5) ? $row->info_5 : '' }}" placeholder="备选信息" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="info_6">备选信息6</label>
                            <input type="text" class="form-control" id="info_6" name="info_6" value="{{ isset($row->info_6) ? $row->info_6 : '' }}" placeholder="备选信息" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">内容</label>
                            <script type="text/plain" id="myEditor" name="content"></script>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="did" value="{{ isset($row->did) ? $row->did : '' }}" />
                        <input type="hidden" name="text_no" value="{{ $textNo }}" />
                        <input type="submit" class="btn btn-success btn-xl" value="提交" />
                    </div>
                    {!! csrf_field() !!}
                </div>
            </form>
        </div>

        @if($attachment)
            <div id="attachment" class="tab-pane">
                <div class="row" style="padding-top: 20px">
                    @foreach($attachment as $vo)
                    <div class="col-md-2">
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
                                        @if($row->cover_aid != $vo->aid)
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
@endsection

@section('css')
<link href="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection

@section('js')
<!-- datetimepicker插件 -->
<script src="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<script>
$('#time_document').datetimepicker({
    format: 'yyyy-mm-dd',
    language: 'zh-CN',
    weekStart: 1,
    autoclose: 1,
    todayHighlight: 1,
    pickerPosition: 'bottom-right',
    minView: 2
});
</script>

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
        'text_no': "{{ $textNo }}",
        'model': "attach_doc",
    });

    ue.setContent('{!! isset($row->content) ? $row->content : '' !!}');
});
</script>

<script>
$(function() {
    // CSRF token
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});

    // 修改附件描述
    $(".btn-set-description").click(function () {
        if(!confirm("确认修改？")) return false;

        $.post("{{ route('admindocasad') }}", {
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

        $.post("{{ route('admindocasc') }}", {
            aid: $(this).data("aid"),
            did: '{{ isset($row->did) ? $row->did : 0 }}'
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
        $.post("{{ route('admindocada') }}", {
            id: $that.data("id")
        }, function(data) {
            if(data.status === 1) {
                $that.closest(".col-md-2").remove();
            } else {
                alert(data.info);
            }
        }, "json");
    });
});
</script>
@endsection
