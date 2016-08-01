@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="col-md-12">
            <p class="col-md-3">用户编辑器</p>
        </h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="nav">
                <li class="active"><a href="#editor" data-toggle="tab">编辑</a></li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div id="editor" class="tab-pane active">
            <form method="post" id="form-edit" action="{{ route('adminfofuserupdateorcreate') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cid">所属栏目</label>
                            <select class="form-control" name="type">
                                <option value="1" {{ isset($data->type) && $data->type == 1 ? 'selected' : '' }}>个人</option>
                                <option value="2" {{ isset($data->type) && $data->type == 2 ? 'selected' : '' }}>企业</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">名称</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ isset($data->name) ? $data->name : '' }}" placeholder="姓名或企业名" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_number">证件号码</label>
                            <input type="text" class="form-control" id="id_number" name="id_number" value="{{ isset($data->id_number) ? $data->id_number : '' }}" placeholder="身份证号或营业执照号" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_number">产品权限</label>
                            <div>
                                @foreach($category as $val)
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="cid[]" value="{{ $val->cid }}" {{ isset($auth) && $auth && $auth->contains($val->cid) ? 'checked' : '' }}> {{ $val->name }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <input type="hidden" name="fuid" value="{{ isset($data->fuid) ? $data->fuid : '' }}" />
                        <input type="submit" class="btn btn-success btn-xl" value="提交" />
                        <span class="text-danger">{{ isset($errors) ? $errors->first() : "" }}</span>
                    </div>
                    {!! csrf_field() !!}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
