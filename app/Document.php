<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Document extends Model
{
    protected $table = 'document';
    public $timestamps = false;

    protected $numberFilename = false;

    // protected $_validate = array(
    //     array('cid', 'require', '栏目必须', self::MUST_VALIDATE),
    //     array('cid', '_cateVerify', '栏目不存在', self::MUST_VALIDATE, 'callback'),
    //     array('filename', '', '文档文件名已经存在', self::EXISTS_VALIDATE, 'unique'),
    //     array('filename', '/^[a-zA-Z0-9]{0,50}$/', '文档文件名只能是50位以内字母或者数字组合', self::EXISTS_VALIDATE, 'regex'),
    //     array('title', 'require', '标题必须', self::MUST_VALIDATE),
    //     array('content', 'require', '内容必须', self::MUST_VALIDATE),
    // );

    // protected $_auto = array(
    //     array('filename', '_filenameVerify', self::MODEL_BOTH, 'callback'),
    //     array('time_create', 'time', self::MODEL_INSERT, 'function'),
    //     array('time_last_modify', 'time', self::MODEL_UPDATE, 'function'),
    // );

    /**
     * 新增文档
     * @param mixed $doc 文档数据
     * @return int 新增文档 id
     */
    public function addNew ($doc) {
        $newId = $this->insertGetId($doc);

        if($newId === false) {
            $this->error = '数据库写入错误';
            return false;
        }

        // 如果是数字文档文件名, 将 id 作为文档文件名
        if($this->numberFilename) {
            $this->where('did', $newId)->update(array('filename' => $newId));
        }

        return $newId;
    }

    /**
     * 验证 栏目 id 是否存在
     */
    // public function cateVerify (Category $category) {
    //     return !empty($category->info($cid));
    // }

    /**
     * 文件名验证: 如果没有输入文件名, 或者文件名为纯数字, 暂时将文件名写入随机字符串
     */
    // public function filenameVerify ($filename) {
    //     $this->numberFilename = !isset($filename) || empty($filename) || ctype_digit($filename);
    //     return $this->numberFilename ? uniqid() : strtolower($filename);
    // }

    /**
     * 编辑栏目
     * @param mixed $doc 栏目信息
     * @param boolean 是否编辑成功
     */
    public function modify ($doc) {
        $result = $this->where('did', $doc['did'])->update($doc);

        if($result === false) {
            $this->error = '数据库写入错误';
            return false;
        }

        return true;
    }

    /**
     * 获取文档详情
     * @param int $did 文档 id
     * @return mixed 文档内容
     */
    public function detail ($did) {
        $detail = $this->
            join('category as c', 'document.cid', '=', 'c.cid')->
            where('document.did', $did)->
            where('document.status', '<>', 0)->
            select('document.*', 'c.name as category_name')->
            first();

        if(false === $detail) {
            $this->error = '没有获取到数据';
            return false;
        }

        return $detail;
    }

    /**
     * 设置文档状态
     * @param int $did 文档 id
     * @param int $status 文档状态: 0.删除 1.正常 2.停用
     * @param int $uid 操作者 uid
     * @return boolean 成功设置与否
     * @todo 删除文档后, 文档关联的附件需要做处理
     */
    public function setStatus($did, $status, $uid)
    {
        $result = $this->
            where('did', $did)->
            where('status', '<>', 0)->
            update(array(
                'status'           => $status,
                'uid_last_modify'  => $uid,
                'time_last_modify' => NOW_TIME,
            ));

        if(false === $result) {
            $this->error = '数据库写入错误';
            return false;
        }

        // 删除文档处理相应的附件
        if($status == 0) {
             /**
              * @todo 处理文档相应的附件
              */
        }

        return true;
    }

    /**
     * 删除文档
     * @param int $did 文档 id
     * @param int $uid 操作者 uid
     * @return boolean 成功设置与否
     */
    public function remove ($did, $uid) {
        return $this->setStatus($did, 0, $uid);
    }

    /**
     * 获取文档附件列表
     * @param $textNo 富文本编号
     */
    public function getAttachList($textNo) {
        $data = DB::table('attach_doc as da')->
            join('attachment as a', 'a.aid', '=', 'da.aid')->
            where('da.text_no', $textNo)->
            get();

        return $data;
    }

    // 设置封面图片
    public function setCover($did, $aid) {
        $result = $this->where('did', $did)->update(array('cover_aid' => $aid));

        return $result;
    }
}
