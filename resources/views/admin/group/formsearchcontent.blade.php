@foreach($dataList as $vo)
    <div class="checkbox">
        <label>
            <input type="checkbox" name="did[]" value="{{ $vo->did }}">
            {{ $vo->title }}
        </label>
    </div>
@endforeach
<button id="batch-add" type="button" class="btn btn-primary">提交</button>