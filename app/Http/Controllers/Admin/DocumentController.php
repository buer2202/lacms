<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Document;
use App\Attachment;

class DocumentController extends Controller
{
    public function index() {
        $dataList = Document::where('document.status', '<>', 0)->
            join('category', 'document.cid', '=', 'category.cid')->
            select('document.*', 'category.name as category_name')->
            orderBy('did', 'desc')->
            paginate(20);
        return view('admin.document.index', compact('dataList'));
    }

    // ajax设置状态
    public function ajaxsetstatus(Request $request, Document $document) {
        $result = $document->setStatus($request->did, $request->status, $request->user()->id);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $document->error];
        }
    }

    public function editor(Document $document, $did = null) {
        if(empty($did)) { // 没有did则新增
            $formAction = route('admindocadd');
            $textNo = uniqid();
            $row = array('cid' => 0);
            $attachment = array();
        } else { // 否则编辑
            $formAction = route('admindocupdate');
            $row = $document->detail($did);
            $textNo = $row['text_no'];
            $attachment = $document->getAttachList($row['text_no']);
        }

        categorySelector('cid', 'cid', 'form-control', $row['cid'], false);

        return view('admin.document.editor', compact('row', 'textNo', 'formAction', 'attachment'));
    }

    public function addnew(Request $request, Document $document, Attachment $attachment) {
        $data = array(
            'cid'             => $request->cid,
            'filename'        => $request->filename,
            'sortord'         => $request->sortord,
            'status'          => $request->status,
            'title'           => $request->title,
            'title_sub'       => $request->title_sub,
            'content'         => $request->content,
            'text_no'         => $request->text_no,
            'seo_title'       => $request->seo_title,
            'seo_keywords'    => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'template'        => $request->template,
            'time_document'   => strtotime($request->time_document),
            'uid_creator'     => $request->user()->id,
            'uid_last_modify' => $request->user()->id,
            'info_1'          => $request->info_1,
            'info_2'          => $request->info_2,
            'info_3'          => $request->info_3,
            'info_4'          => $request->info_4,
            'info_5'          => $request->info_5,
            'info_6'          => $request->info_6,
        );

        $did = $document->addNew($data);

        if($did) {
            // 更新附件信息
            $result = $attachment->updateAttachAssociation('attach_doc', $data['text_no'], 'did', $did);
            if(!$result) {
                return back()->withInput();
            }

            return redirect('/admin/document');
        } else {
            return back()->withInput();
        }
    }

    // 编辑
    public function update(Request $request, Document $document, Attachment $attachment) {
        $data = array(
            'did'             => $request->did,
            'cid'             => $request->cid,
            'filename'        => $request->filename,
            'sortord'         => $request->sortord,
            'status'          => $request->status,
            'title'           => $request->title,
            'title_sub'       => $request->title_sub,
            'content'         => $request->content,
            'seo_title'       => $request->seo_title,
            'seo_keywords'    => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'template'        => $request->template,
            'time_document'   => strtotime($request->time_document, 0),
            'uid_last_modify' => $request->user()->id,
            'info_1'          => $request->info_1,
            'info_2'          => $request->info_2,
            'info_3'          => $request->info_3,
            'info_4'          => $request->info_4,
            'info_5'          => $request->info_5,
            'info_6'          => $request->info_6,
        );

        $result = $document->modify($data);

        if($result) {
            // 设置富文本的附件状态
            $result = $attachment->updateAttachAssociation('attach_doc', $request->text_no, 'did', $data['did']);

            if(!$result) {
                return back()->withInput();
            }

            return redirect('/admin/document');
        } else {
            return back()->withInput();
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
    public function ajaxsetcover(Request $request, Document $document) {
        $result = $document->setCover($request->did, $request->aid);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, $document->error];
        }
    }

    // 删除附件
    public function ajaxdeleteattachment(Request $request, Attachment $attachment) {
        $result = $attachment->deleteAttachAssociation('attach_doc', $request->id);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $attachment];
        }
    }
}
