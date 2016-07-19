<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Repositories\GroupRepository;
use App\Group;

class GroupController extends Controller
{
    protected $request;
    protected $group;

    public function __construct(Request $request, GroupRepository $group)
    {
        $this->request = $request;
        $this->group = $group;
    }

    public function index() {
        $data = Group::where('status', '<>', 0)->paginate(20);

        return view('admin.group.index', compact('data'));
    }

    public function ajaxgetrow() {
        $data = $this->group->info($this->request->gid);

        if($data) {
            return ['status' => 1, 'info' => $data];
        } else {
            return ['status' => 0, 'info' => '不存在该群组'];
        }
    }

    public function addnew() {
        $data = array(
            'name'        => $this->request->name,
            'description' => $this->request->description,
            'status'      => 1,
        );

        $gid = $this->group->addNew($data);

        return redirect('/admin/group');
    }

    // ajax设置状态
    public function ajaxsetstatus() {
        $result = $this->group->setStatus($this->request->gid, $this->request->status, $this->request->user()->id);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $this->group->error];
        }
    }

    // 编辑
    public function update() {
        $data = array(
            'gid'         => $this->request->gid,
            'name'        => $this->request->name,
            'description' => $this->request->description,
        );

        $result = $this->group->modify($data);

        return redirect('/admin/group');
    }

    // 内容
    public function content() {
        $data = $this->group->contentList($this->request->gid);

        categorySelector('cid', 'cid', 'form-control', 0, true);

        return view('admin.group.content', ['info' => $data['info'], 'list' => $data['list']]);
    }

    // 获取一行内容
    public function ajaxgetcontentrow() {
        $data = $this->group->contentInfo($this->request->id);

        if($data) {
            $data['time'] = date('Y-m-d', $data['time']);
            return ['status' => 1, 'info' => $data];
        } else {
            return ['status' => 0, 'info' => '不存在该群组'];
        }
    }

    // 添加内容
    public function addcontent() {
        $data = array(
            'gid'         => $this->request->gid,
            'title'       => $this->request->title,
            'url'         => $this->request->url,
            'sortord'     => $this->request->sortord,
            'time'        => strtotime($this->request->time),
            'img'         => $this->request->img,
            'description' => $this->request->description,
        );
        $result = $this->group->addContent($data);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $this->group->error];
        }
    }

    // 更新内容
    public function updatecontent() {
        $data = array(
            'id'          => $this->request->id,
            'title'       => $this->request->title,
            'url'         => $this->request->url,
            'sortord'     => $this->request->sortord,
            'time'        => strtotime($this->request->time),
            'img'         => $this->request->img,
            'description' => $this->request->description,
        );
        $result = $this->group->modifyContent($data);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $this->group->error];
        }
    }

    // 搜索结果列表
    public function searchcontent(Request $request, \App\Document $document) {
        if($this->request->cid) {
            $document = $document->where('cid', $this->request->cid);
        }
        if($this->request->title) {
            $document = $document->where('title', $title);
        }

        $dataList = $document->get();

        if($dataList->count()) {
            return [view('admin.group.formsearchcontent', ['dataList' => $dataList])->render()];
        } else {
            return ['没有搜索到结果'];
        }
    }

    // 批量添加内容
    public function addcontentbatch() {
        $result = $this->group->addContentBatch($this->request->gid, $this->request->did);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $this->group->error];
        }
    }

    // 删除内容
    public function removecontent()
    {
        $result = $this->group->removeContent($this->request->id);

        if($result) {
            return ['status' => 1];
        } else {
            return ['status' => 0, 'info' => $this->group->error];
        }
    }
}
