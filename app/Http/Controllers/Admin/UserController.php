<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Validator;

class UserController extends Controller
{
    public function resetPassword()
    {
        return view('admin.user.resetPassword');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'              => 'required|min:6|max:20|confirmed',
        ], [
            'required'  => '密码不能为空',
            'min'       => '密码不能小于6个字符',
            'max'       => '密码不能超过20个字符',
            'confirmed' => '重复密码不一致',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = User::where('id', $request->user()->id)->update(['password' => bcrypt($request->password)]);

        if($result) {
            $err = '密码更新成功';
        } else {
            $err = '密码更新失败';
        }

        return redirect()->back()->withErrors(['err' => $err]);
    }
}
