<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FofUser;
use App\FofUserProduct;
use App\Category;

use DB;

class FofUserAuthController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $id_number = $request->id_number;

        $model = FofUser::where([]);

        if($name) {
            $model = $model->where('name', $name);
        }

        if($id_number) {
            $model = $model->where('id_number', $id_number);
        }

        $dataList = $model->paginate(20);

        return view('admin.fofuserauth.index', compact('dataList', 'name', 'id_number'));
    }

    // ajax设置状态
    public function ajaxdel(Request $request) {
        DB::beginTransaction();

        $result = FofUser::where('fuid', $request->fuid)->delete();
        if(!$result) {
            DB::rollBack();
            return ['status' => 0, 'info' => '删除失败'];
        }

        $result = FofUserProduct::where('fuid', $request->fuid)->delete();
        if(!$result) {
            DB::rollBack();
            return ['status' => 0, 'info' => '删除失败'];
        }

        DB::commit();

        return ['status' => 1];
    }

    public function editor(Request $request) {
        $fuid = $request->input('fuid', 0);
        if($fuid) {
            $data = FofUser::where('fuid', $fuid)->first();
            $auth = FofUserProduct::where('fuid', $fuid)->lists('cid');
        } else {
            $data = null;
            $auth = null;
        }

        $category = Category::where(['parent_cid' => 3, 'status' => 1])->get();

        return view('admin.fofuserauth.editor', compact('data', 'auth', 'category'));
    }

    public function updateOrCreate(Request $request) {
        $fuid = $request->input('fuid', 0);
        $data = [
            'type'             => $request->type,
            'name'             => $request->name,
            'id_number'        => $request->id_number,
            'id_number_last_6' => substr($request->id_number, -6, 6) ?: '',
        ];

        $result = FofUser::updateOrCreate(['fuid' => $fuid], $data);

        if(!$result) {
            return back()->withInput()->withErrors('操作失败！');
        }

        $cids = $request->input('cid', []);

        if($fuid) {
            FofUserProduct::where('fuid', $fuid)->delete();
        }

        if($cids) {
            foreach ($cids as $cid) {
                $data_fofUserProduct[] = ['fuid' => $fuid ?: $result->fuid, 'cid' => $cid];
            }

            $result = FofUserProduct::insert($data_fofUserProduct);
        }

        return redirect('/admin/fofuserauth');
    }
}
