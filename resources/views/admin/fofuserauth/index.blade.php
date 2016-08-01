@extends('layouts.app')

@section('content')
<div class="container">
    <h3>
        用户产品管理
        <a href="{{ route('fofusereditor') }}" class="btn btn-primary pull-right">添加新用户</a>
    </h3>

    <form class="form-inline" style="margin:20px 0;">
        <div class="form-group">
            <label for="name">姓名：</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" />
        </div>
        <div class="form-group">
            <label for="id_number">证件号：</label>
            <input type="text" class="form-control" id="id_number" name="id_number" value="{{ $id_number }}" />
        </div>
        <button type="submit" class="btn btn-primary">查询</button>
        <a href="{{ url('/admin/fofuserauth') }}" class="btn btn-default">全部</a>
    </form>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>类型</th>
                <th>姓名</th>
                <th>证件号</th>
                <th>创建时间</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataList as $data)
            <tr>
                <td>{{ $data->fuid }}</td>
                <td>{{ $data->type == 1 ? '个人' : '企业' }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->id_number }}</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->updated_at }}</td>
                <td>
                    <a href="{{ route('fofusereditor', ['fuid' => $data->fuid]) }}" class="btn btn-info btn-xs btn-edit">编辑</a>
                    <button type="button" class="btn btn-danger btn-xs del" data-fuid="{{ $data->fuid }}">删除</button>
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

    // 删除
    $(".del").click(function () {
        if(!confirm("再次确认")) return false;

        $.post("{{ route('fofuserdel') }}", {
            fuid: $(this).data("fuid"),
            _method: 'delete'
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
