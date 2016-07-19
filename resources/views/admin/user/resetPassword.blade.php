@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/updatePassword') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="col-md-4 control-label">密码：</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">重复：</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation">
                @if ($errors->first())
                    <span class="help-block">
                        <strong>{{ $errors->first() }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    修改
                </button>
            </div>
        </div>
    </form>
</div>
@endsection