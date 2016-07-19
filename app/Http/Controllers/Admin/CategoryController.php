<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\Category;
use App\Attachment;
use DB;


class CategoryController extends Controller
{
    public function index(Category $category)
    {
        $tree = $category->tree();

        return view('admin.category.index', compact('tree'));
    }

    public function editor(Category $category, $cid = 0, $parentCid = 0)
    {
        if(!$cid) { // 没有cid则新增
            $formAction = '/admin/category/addnew';
            $textNo     = uniqid();
            $data       = array();
            $attachment = array();
            $parentCid  = $parentCid ?: 0;
        } else { // 否则编辑
            $formAction = '/admin/category/update';
            $data       = $category->info($cid);
            $textNo     = $data->text_no;
            $attachment = $category->getAttachList($textNo);
            $parentCid  = $data->parent_cid;
        }

        categorySelector('parent_cid', 'parent_cid', 'form-control', $parentCid, true);

        return view('admin.category.editor', compact('data', 'textNo', 'formAction', 'parentCid', 'attachment'));
    }

    public function addnew(Request $request, Category $category, Attachment $attachment) {
        // 验证
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => '栏目名称不能为空',
        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();

            return ['info' => $msg, 'status' => 0];
        }

        $data = array(
            'parent_cid'      => $request->parent_cid,
            'text_no'         => $request->text_no,
            'nav_sortord'     => $request->nav_sortord,
            'name'            => $request->name,
            'path'            => $request->path,
            'sortord'         => $request->sortord,
            'description'     => $request->description,
            'seo_title'       => $request->seo_title,
            'seo_keywords'    => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'cate_tpl'        => $request->cate_tpl,
            'doc_tpl'         => $request->doc_tpl,
            'uid_creator'     => $request->user()->id,
            'time_create'     => NOW_TIME,
            'info_1'          => $request->info_1,
            'info_2'          => $request->info_2,
            'info_3'          => $request->info_3,
            'info_4'          => $request->info_4,
            'info_5'          => $request->info_5,
            'info_6'          => $request->info_6,
        );

        $cid = $category->addNew($data);

        if($cid) {
            // 设置富文本的附件状态
            $result = $attachment->updateAttachAssociation('attach_cate', $data['text_no'], 'cid', $cid);
            if(!$result) {
                return ['status' => 0, 'info' => $attachment->error];
            }

            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $category->error];
        }
    }

    // ajax设置状态
    public function ajaxsetstatus(Request $request, Category $category)
    {
        $result = $category->setStatus($request->cid, $request->status, $request->user()->id);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $category->error];
        }
    }

    // ajax设置首页显示
    public function ajaxsetnavshow(Request $request, Category $category)
    {
        $result = $category->setNavShow($request->cid, $request->navshow);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $category->error];
        }
    }

    // 编辑
    public function update(Request $request, Category $category, Attachment $attachment) {
        // 验证
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => '栏目名称不能为空',
        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();

            return ['info' => $msg, 'status' => 0];
        }

        $data = array(
            'cid'             => $request->cid,
            'parent_cid'      => $request->parent_cid,
            'nav_sortord'     => $request->nav_sortord,
            'name'            => $request->name,
            'path'            => $request->path,
            'sortord'         => $request->sortord,
            'cover_aid'       => $request->cover_aid,
            'description'     => $request->description,
            'seo_title'       => $request->seo_title,
            'seo_keywords'    => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'cate_tpl'        => $request->cate_tpl,
            'doc_tpl'         => $request->doc_tpl,
            'uid_last_modify' => $request->user()->id,
            'time_last_modify'=> NOW_TIME,
            'info_1'          => $request->info_1,
            'info_2'          => $request->info_2,
            'info_3'          => $request->info_3,
            'info_4'          => $request->info_4,
            'info_5'          => $request->info_5,
            'info_6'          => $request->info_6,
        );

        $result = $category->modify($data);

        if($result) {
            // 设置富文本的附件状态
            $result = $attachment->updateAttachAssociation('attach_cate', $request->text_no, 'cid', $data['cid']);
            if(!$result) {
                return ['status' => 0, 'info' => $attachment->error];
            }

            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $category->error];
        }
    }

    // 更新附件说明
    public function ajaxsetattachmentdescription(Request $request, Attachment $attachment) {
        $result = $attachment->setDescription($request->aid, $request->description);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $attachment->error];
        }
    }

    // 设附件为封面
    public function ajaxsetcover(Request $request, Category $category) {
        $result = $category->setCover($request->cid, $request->aid);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $category->error];
        }
    }

    // 删除附件
    public function ajaxdeleteattachment(Request $request, Attachment $attachment) {
        $result = $attachment->deleteAttachAssociation('attach_cate', $request->id);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $attachment->error];
        }
    }
}
