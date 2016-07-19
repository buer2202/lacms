<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Attachment extends Model
{
    protected $table = 'attachment';
    public $timestamps = false;

    protected $error;

    /**
     * 新增
     * @param int type 文件类型
     * @param string description 描述
     * @param string md5
     * @param string ext 后缀名
     * @param int uri 文件路径
     * @param int size 文件大小
     * @param int type 文件类型：1.图片；2.文档
     * @return
     */
    public function addnew($description, $md5, $ext, $size, $uri, $type = 2) {
        // 检索md5码
        $sameFile = $this->where('md5', $md5)->first();

        if($sameFile) {
            $file['aid'] = $sameFile->aid;
            $file['isAdd'] = false;
        } else {
            $data = array(
                'type'        => $type,
                'description' => $description,
                'md5'         => $md5,
                'ext'         => $ext,
                'size'        => $size,
                'refer'       => 0,
                'time_upload' => NOW_TIME,
                'uri'         => $uri,
            );

            $file['aid'] = $this->insertGetId($data);

            if(!$file['aid']) {
                $this->error = '数据库写入失败';
                return false;
            }

            $file['isAdd'] = true;
        }

        return $file;
    }

    /**
     * 新增图片
     * @param string description 标题
     * @param string md5
     * @param string ext 后缀名
     * @param int size 文件大小
     * @param int uri 文件路径
     * @param int width 图片宽
     * @param int height 图片高
     * @return
     */
    public function addImage($description, $md5, $ext, $size, $uri, $width, $height)
    {
        DB::beginTransaction();
        $result = $this->addnew($description, $md5, $ext, $size, $uri, 1);
        if(!$result) {
            $this->error = parent::error;
            return false;
        }

        if($result['isAdd']) {
            $data = array(
                'aid'    => $result['aid'],
                'width'  => $width ?: 0,
                'height' => $height ?: 0,
            );

            if(false === Image::insert($data)) {
                DB::rollBack();
                $this->error = '数据库写入失败';
                return false;
            }
        }

        DB::commit();

        return $result;
    }

    /**
     * 更新引用
     * @param int/array aid 附件id
     * @param string incOrDec 值为'inc'是增加，'dec'减少
     * @return
     */
    public function refer($aid, $incOrDec) {
        if(is_array($aid)) {
            $this->whereIn('aid', $aid);
        } else {
            $this->where('aid', $aid);
        }

        switch ($incOrDec) {
            case 'inc':
                $result = $this->increment('refer');
                break;
            case 'dec':
                $result = $this->decrement('refer');
                break;
            default:
                $this->error = '更新操作不能识别';
                return false;
        }

        if(false === $result) {
            $this->error = '数据库写入失败';
            return false;
        }

        return true;
    }

    /**
     * 更新说明
     * @param int aid 附件id
     * @param string description 说明文
     * @return
     */
    public function setDescription($aid, $description) {
        $result = $this->where('aid', $aid)->update(array('description' => $description));

        if(false === $result) {
            $this->error = '数据库写入失败';
            return false;
        }

        return true;
    }

    /**
     * 设置附件的关联状态
     * @param string $modelName 模型名称
     * @param string $textNo 富文本编号
     * @param int $foreignKeyName 外键名
     * @param int $foreignKeyValue 外键值
     */
    public function updateAttachAssociation($modelName, $textNo, $foreignKeyName, $foreignKeyValue) {
        // 获取之前有效的附件，引用次数减去1
        $foreignKeyOld = DB::table($modelName)->where($foreignKeyName, $foreignKeyValue)->lists('aid');
        if($foreignKeyOld) {
            // 减少引用次数
            $this->refer($foreignKeyOld, 'dec');
        }

        // 更新附件信息
        DB::table($modelName)->where('text_no', $textNo)->update([$foreignKeyName => $foreignKeyValue]);

        // 获取文件列表
        $aids = DB::table($modelName)->where('text_no', $textNo)->lists('aid');

        // 增加引用次数
        $this->refer($aids, 'inc');

        return true;
    }

    /**
     * 删除附件关联
     * @param string $modelName 模型名称
     * @param int $id 关联id
     */
    public function deleteAttachAssociation($modelName, $id) {
        $aid = DB::table($modelName)->where('id', $id)->value('aid');

        if(!$aid) {
            $this->error = '没有该关联信息';
            return false;
        }

        // 删除记录
        DB::table($modelName)->where('id', $id)->delete();

        // 减少引用次数
        $this->refer($aid, 'dec');

        return true;
    }
}
