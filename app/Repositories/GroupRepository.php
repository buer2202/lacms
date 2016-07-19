<?php
namespace App\Repositories;

use App\Group;
use App\GroupContent;
use DB;

class GroupRepository
{
    protected $group;
    protected $groupContent;

    public function __construct(Group $group, GroupContent $groupContent)
    {
        $this->group = $group;
        $this->groupContent = $groupContent;
    }

    public function addNew($data)
    {
        return $this->group->insertGetId($data);
    }

    /**
     * 设置群组状态
     * @param int $gid 群组 id
     * @param int $status 状态: 0.删除 1.正常 2.停用
     * @return boolean 成功设置与否
     */
    public function setStatus ($gid, $status) {
        if(!in_array($status, array(0, 1, 2))) {
            $this->error = '状态错误';
            return false;
        }

        $result = $this->group->
            where('gid', $gid)->
            where('status', '<>', 0)->
            update(array('status' => $status));

        if(false === $result) {
            $this->error = '数据库写入错误';
            return false;
        }

        return true;
    }

    /**
     * 获取群组信息
     * @param int $gid 群组 id
     * @return array 群组信息
     */
    public function info($gid)
    {
        $info = $this->group->where('gid', $gid)->where('status', '<>', 0)->first();

        if(empty($info)) {
            $this->error = '没有获取到数据';
            return false;
        }

        return $info;
    }

    /**
     * 编辑
     * @param mixed $group
     * @param boolean 是否编辑成功
     */
    public function modify ($group) {
        $result = $this->group->where('gid', $group['gid'])->update($group);

        if($result === false) {
            $this->error = '数据库写入错误';
            return false;
        }

        return true;
    }

    /**
     * 获取内容列表
     * @param int $gid 群组 id
     * @param int $page 页号
     * @param int $pageSize 分页大小
     * @return mixed
     */
    public function contentList($gid)
    {
        $info = $this->info($gid);
        if(empty($info)) {
            $this->error = '群组错误';
            return false;
        }

        $groupContent = $this->groupContent->where('gid', $gid)->paginate(20);

        return array(
            'info'      => $info,
            'list'      => $groupContent,
        );
    }

    /**
     * 给群组添加内容
     * @param int $gid 群组 id
     * @param array $content 内容数组
     * @return boolean
     */
    public function addContent($content)
    {
        if(false === $this->info($content['gid'])) {
            $this->error = '群组错误';
            return false;
        }

        $newId = $this->groupContent->insertGetId($content);
        if(false === $newId) {
            $this->error = '数据库写入错误';
            return false;
        }

        return $newId;
    }

    /**
     * 获取群组内容信息
     * @param int $id 群组 id
     * @return array 群组信息
     */
    public function contentInfo($id) {
        $info = $this->groupContent->where('id', $id)->first();

        if(empty($info)) {
            $this->error = '没有获取到数据';
            return false;
        }

        return $info;
    }

    /**
     * 编辑群组内容
     * @param int $id 内容 id
     * @param array $content 内容数组
     * @return boolean
     */
    public function modifyContent($content) {
        $result = $this->groupContent->where('id', $content['id'])->update($content);

        if($result === false) {
            $this->error = '数据库写入错误';
            return false;
        }

        return true;
    }

    /**
     * 给群组批量添加内容
     * @param int $gid 群组 id
     * @param array $did 文档id数组
     * @return boolean
     */
    public function addContentBatch($gid, $did) {
        if(empty($gid)) {
            $this->error = '群组id不能为空';
            return false;
        }

        if(empty($did) && !is_array($did)) {
            $this->error = '文档id错误';
            return false;
        }

        $docs = DB::table('document as d')->
            leftJoin('attachment as a', 'a.aid', '=', 'd.cover_aid')->
            select('d.title', 'd.content', 'd.filename', 'd.time_document', 'a.uri')->
            whereIn('d.did', $did)->
            get();

        $sql = "INSERT INTO jcms_group_content(`gid`, `title`, `description`, `url`, `img`, `sortord`, `time`) VALUES";

        foreach ($docs as $value) {
            $description = mb_substr(htmlspecialchars(strip_tags($value->content), ENT_COMPAT), 0, 500);
            $sql .= "({$gid}, '{$value->title}', \"{$description}\", '/{$value->filename}.html', '{$value->uri}', 0, {$value->time_document}),";
        }

        $sql = rtrim($sql, ',');

        $result = DB::insert($sql);
        if($result === false) {
            $this->error = '数据写入失败';
            return false;
        }

        return true;
    }

    /**
     * 删除群组内容
     * @param array $ids 群组内容 id 数组
     * @return boolean
     */
    public function removeContent ($id) {
        $result = $this->groupContent->where('id', $id)->delete();
        if(false === $result) {
            $this->error = '数据库写入错误';
            return false;
        }
        return true;
    }
}
