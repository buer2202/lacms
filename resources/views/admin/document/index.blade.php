@extends('layouts.app')

@section('content')
<div class="container">
    <h3>
        文档管理
        <a href="{{ route('admindocedit') }}" class="btn btn-primary pull-right">添加新文档</a>
    </h3>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>文章标题</th>
                <th>栏目</th>
                <!-- <th>URL</th> -->
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataList as $data)
            <tr>
                <td>{{ $data->did }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->category_name ?: '空栏目' }}</td>
                <!-- <td><a href="/{{ $data->filename }}.html" title="新窗口预览" target="_blank">/{{ $data->filename }}.html <span class="glyphicon glyphicon-new-window"></span></a></td> -->
                <td>
                    @if ($data->status == 0) 删除
                    @elseif ($data->status == 1) 正常
                    @elseif ($data->status == 2) 禁用
                    @else 未知
                    @endif
                </td>
                <td>
                    <a href="{{ route('admindoceditdid', ['did' => $data['did']]) }}" class="btn btn-info btn-xs btn-edit">编辑</a>

                    @if ($data->status == 1)
                        <button type="button" class="btn btn-warning btn-xs set-status" data-did="{{ $data->did }}" data-status="2">禁用</button>
                    @else
                        <button type="button" class="btn btn-success btn-xs set-status" data-did="{{ $data->did }}" data-status="1">启用</button>
                    @endif

                    <button type="button" class="btn btn-danger btn-xs set-status" data-did="{{ $data->did }}" data-status="0">删除</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $dataList->links() !!}
</div>
@endsection

@section ('js')
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

        $.post("{{ route('admindocstatus') }}", {
            did: $(this).data("did"),
            status: status
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
