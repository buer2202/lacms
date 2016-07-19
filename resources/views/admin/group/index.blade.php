@extends('layouts.app')

@section('content')
<div class="container">
    <h3>群组管理</h3>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="nav">
                <li class="active"><a href="#list" data-toggle="tab">列表</a></li>
                <li><a href="#editor" data-toggle="tab">添加</a></li>
                <li><a id="tab-edit" class="disabled">编辑</a></li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div id="list" class="tab-pane active">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>描述</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->gid }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->description }}</td>
                        <td>
                            <switch name="row.status">
                                <case value="0">删除</case>
                                <case value="1">正常</case>
                                <case value="2">禁用</case>
                            </switch>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs edit" data-gid="{{ $row->gid }}">编辑</button>
                            @if($row->status == 1)
                                <button type="button" class="btn btn-warning btn-xs set-status" data-gid="{{ $row->gid }}" data-status="2">禁用</button>
                            @else
                                <button type="button" class="btn btn-success btn-xs set-status" data-gid="{{ $row->gid }}" data-status="1">启用</button>
                            @endif
                            <button type="button" class="btn btn-danger btn-xs set-status" data-gid="{{ $row->gid }}" data-status="0">删除</button>
                            <a href="{{ route('groupcontent', ['gid' => $row->gid]) }}" type="button" class="btn btn-primary btn-xs">内容</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $data->links() !!}
        </div>

        <div id="editor" class="tab-pane">
            <form method="post" id="form-editor">
                <input type="hidden" name="id" value="0" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">名称</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名称" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">描述</label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="描述" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="gid" />
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-success btn-xl">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    // ajax请求头添加csrf令牌
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // 设置栏目状态
    $(".set-status").click(function () {
        var status = $(this).data("status");
        if(status == 0 && !confirm("再次确认")) return false;

        $.post("{{ route('admin_group_ajaxsetstatus') }}", {
            gid: $(this).data("gid"),
            status: status
        }, function (data) {
            if(data.status === 1) {
                window.location.reload();
            } else {
                alert(data.info);
            }
        }, "json");
    });

    // 添加
    $("[href='#editor']").click(function () {
        $("#form-editor").attr("action", "{{ route('admin_group_addnew') }}").find(":input").not('[name=_token]').val("");
    });

    // 编辑
    $(".edit").click(function () {
        var gid = $(this).data("gid");

        $.get("{{ route('admingrouprow') }}", {
            gid: gid
        }, function (data) {
            if(data.status === 1) {
                $("#tab-edit").parent().addClass("active").siblings().removeClass("active");
                $("#list").removeClass("active");
                $("#editor").addClass("active");
                $("#form-editor").attr("action", "{{ route('admin_group_update') }}").show();
                $("[name='gid']").val(gid);
                $("#name").val(data.info.name);
                $("#description").val(data.info.description);
            } else {
                alert(data.info);
            }
        }, "json");
    });
});
</script>
@endsection
