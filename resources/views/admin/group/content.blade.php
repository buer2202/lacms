@extends('layouts.app')

@section('content')
<div class="container">
    <h3>群组内容管理</h3>

    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>群组：{{ $info->name }}</b>
                    <button type="button" id="add" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target=".bs-modal-lg">批量添加</button>
                </div>
                <div class="panel-body">{{ $info->description }}</div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $row)
                        <tr>
                            <td>{{ $row->title }}</td>
                            <td>{{ date('Y-m-d', $row->time) }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs edit" data-id="{{ $row->id }}">编辑</button>
                                <button type="button" class="btn btn-danger btn-xs delete" data-id="{{ $row->id }}">删除</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="panel-footer">{{ $list->links() }}</div>

            </div>
        </div>
        <div class="col-md-7" id="select-box">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b id="operation-name">添加新内容至：{{ $info->name }}</b>
                </div>
                <div class="panel-body">
                    <div id="editor" class="tab-pane active">
                        <form method="post" id="form-editor" action="{{ route('admin_group_addcontent') }}">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="title">标题</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="标题" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="url">链接</label>
                                        <input type="text" class="form-control" id="url" name="url" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="sortord">排序</label>
                                        <input type="text" class="form-control" id="sortord" name="sortord" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="time">时间</label>
                                        <input type="text" class="form-control" id="time" name="time" readonly />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="img">图片地址</label>
                                        <input type="text" class="form-control" id="img" name="img" />
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="description">描述</label>
                                        <textarea type="text" class="form-control" id="description" name="description" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <input type="hidden" id="id" name="id" />
                                    <input type="hidden" id="gid" name="gid" value="{{ $info->gid }}" />
                                    <button type="button" id="submit" class="btn btn-success">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Large modal -->
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <form class="form-inline" id="form-search-content">
                    <div class="form-group">
                        {!! $categorySelector !!}
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="请输入查询条件" />
                    </div>
                    <button id="form-search-content-submit" type="button" class="btn btn-primary">查询</button>
                </form>
            </div>
            <div class="modal-body" id="search-result">
                <form>
                    <input type="hidden" name="gid" value="{{ $info->gid }}" />
                    <span></span>
                </form>
            </div>
        </div>
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
$('#time').datetimepicker({
    format: 'yyyy-mm-dd',
    language: 'zh-CN',
    weekStart: 1,
    autoclose: 1,
    todayHighlight: 1,
    pickerPosition: 'bottom-right',
    minView: 2
});
</script>

<script>
$(function () {
    // csrf
    $.ajaxSetup({
        'headers' : {
            'X-CSRF-TOKEN': "{!! csrf_token() !!}"
        }
    });

    // 新增
    $("#add").click(function () {
        $("#form-editor").attr("action", "{{ route('admin_group_addcontent') }}").find(":input").not("#gid").val("");
        $("#operation-name").text("添加新内容至：" + '{$info->name}');
    });

    // 编辑
    $(".edit").click(function () {
        $.get("{{ route('admin_group_ajaxgetcontentrow') }}", {
            id: $(this).data("id")
        }, function (data) {
            if(data.status === 1) {
                $("#operation-name").text("编辑：" + data.info.title);

                $("#id").val(data.info.id);
                $("#title").val(data.info.title);
                $("#url").val(data.info.url);
                $("#img").val(data.info.img);
                $("#sortord").val(data.info.sortord);
                $("#time").val(data.info.time);
                $("#description").val(data.info.description);

                $("#form-editor").attr("action", "{{ route('admin_group_updatecontent') }}");
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 提交
    $("#submit").click(function () {
        $.post($("#form-editor").attr("action"), $("#form-editor").serializeArray(), function (data) {
            if(data.status === 1) {
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 搜索
    $("#form-search-content-submit").click(function () {
        $.get("{{ route('admin_group_searchcontent') }}", $("#form-search-content").serializeArray(), function (data) {
            $("#search-result form span").html(data);
        }, "json");
    });

    // 批量添加
    $("#search-result").on('click', '#batch-add', function () {
        $.post("{{ route('admin_group_addcontentbatch') }}", $("#search-result form").serializeArray(), function (data) {
            if(data.status === 1) {
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 删除
    $(".delete").click(function () {
        if(!confirm("确认删除？")) return false;

        $.post("{{ route('admin_group_removecontent') }}", {
            id: $(this).data("id")
        }, function (data) {
            if(data.status === 1) {
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });
});
</script>
@endsection
