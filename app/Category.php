<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Cache;

class Category extends Model
{
    protected $table = 'category';
    public $timestamps = false;

    /**
     * 获取栏目列表
     * @return array
     */
    public function getList()
    {
        $cacheKey = config('cache.cache_keys.category_list');

        Cache::rememberForever($cacheKey, function () {
            return $this->
                where('status', '<>', 0)->
                orderBy('level')->
                orderBy('sortord',  'desc')->
                select('cid', 'parent_cid', 'level', 'nav_show', 'name', 'path', 'list_allow', 'status', 'cover_aid', 'info_1')->
                get();
        });

        return Cache::get($cacheKey);
    }

    /**
     * 获取栏目树
     * @return mixed 整个栏目树
     */
    public function tree()
    {
        $cacheKey = config('cache.cache_keys.category_tree');

        Cache::rememberForever($cacheKey, function () {
            $list = $this->getList()->toArray();

            $levelCate = array();
            foreach($list as $cate) {
                $levelCate[$cate['level']][$cate['cid']] = $cate;
            }

            $root = array();

            for($level = count($levelCate); $level > 0; $level--) { // 从最底层开始构建树
                if($level > 1) { // 非顶层树枝往高一层树枝上挂
                    foreach($levelCate[$level] as $cateLow) { // 循环当前层, 取每个元素
                        foreach($levelCate[$level - 1] as &$cateHigh) { // 循环上层元素, 寻找当前元素的父
                            if($cateLow['parent_cid'] == $cateHigh['cid']) { // 如果发现了父
                                $cateHigh['branch'][] = $cateLow; // 将当前元素挂在父元素的 branch 字段下
                                break; // 跳出循环, 对下一个低层元素操作
                            }
                        }
                    }
                } else { // 顶层树枝往根上挂
                    foreach($levelCate[$level] as $cate) {
                        $root[] = $cate;
                    }
                }
            }

            return $root;
        });

        return Cache::get($cacheKey);
    }

    /**
     * 清理缓存
     */
    public function _clearCache () {
        Cache::forget(config('cache.cache_keys.category_list'));
        Cache::forget(config('cache.cache_keys.category_tree'));
        Cache::forget(config('cache.cache_keys.category_tree_status_1'));
    }

    /**
     * 设置栏目状态
     *     设置删除状态, 检查该栏目下是否还有子栏目或者文章
     *     设置正常状态, 判断该栏目所有父栏目必须都是正常状态
     *     设置停用状态, 设置当前栏目下所有子栏目均为停用
     * @param int $cid 栏目 id
     * @param int $status 栏目状态: 0.删除 1.正常 2.停用
     * @param int $uid 操作者 uid
     * @return boolean 成功设置与否
     * @todo 删除栏目后, 栏目关联的附件需要做处理
     */
    public function setStatus($cid, $status, $uid)
    {
        switch($status) {
            default:
                $this->error = '状态错误';
                return false;
                break;
            case 0: // 删除
                // 检查子栏目
                $children = $this->children($cid);
                if(!empty($children)) {
                    $this->error = '该栏目下还有子栏目, 不能删除';
                    return false;
                }

                // 检查文档
                $docs = DB::table('Document')->where('cid', $cid)->where('status', '<>', 0)->count();
                if(!empty($docs)) {
                    $this->error = '该栏目下还有文章, 不能删除';
                    return false;
                }

                // 更新数据
                $result = $this->
                    where('cid', $cid)->
                    where('status', '<>', 0)->
                    update([
                        'status'           => 0,
                        'uid_last_modify'  => $uid,
                        'time_last_modify' => NOW_TIME,
                    ]);
                if(false === $result) {
                    $this->error = '数据库写入错误';
                    return false;
                }

                // 删除栏目处理相应的附件
                /**
                 * @todo 处理栏目相应的附件
                 */

                break;
            case 1: // 设置正常
                // 判断有无状态不为正常的父栏目
                $parents = $this->parents($cid);
                if(is_array($parents)) foreach($parents as $cate) {
                    if($cate['status'] != 1) {
                        $this->error = '该栏目有“状态不为正常的”父栏目';
                        return false;
                    }
                }

                // 更新数据
                $result = $this->
                    where('cid', $cid)->
                    where('status', '<>', 0)->
                    update([
                        'status'           => 1,
                        'uid_last_modify'  => $uid,
                        'time_last_modify' => NOW_TIME,
                    ]);
                if(false === $result) {
                    $this->error = '数据库写入错误';
                    return false;
                }
                break;
            case 2: // 设置停用
                $cids = array($cid);
                // 取所有子栏目
                $children = $this->children($cid);
                if(is_array($children)) foreach($children as $cate) {
                    $cids[] = $cate['cid'];
                }
                $result = $this->
                    whereIn('cid', $cids)->
                    where('status', '<>', 0)->
                    update([
                        'status'           => 2,
                        'uid_last_modify'  => $uid,
                        'time_last_modify' => NOW_TIME,
                    ]);
                if(false === $result) {
                    $this->error = '数据库写入错误';
                    return false;
                }
                break;
        }

        // 清理缓存
        $this->_clearCache();

        return true;
    }

    /**
     * 根据 cid 找到某个树枝
     * @param $cid 要找的栏目 id
     * @param $root 要寻找的树, 为空时寻找整棵树
     * @return mixed
     */
    public function branch($cid, $root = null)
    {
        // $cid 为零时返回整个树
        if($cid == 0) {
            return $this->tree();
        }

        if(null === $root) {
            $root = $this->tree();
        }

        foreach($root as $branch) {
            if($branch['cid'] == $cid) {
                return $branch;
            }
            if(isset($branch['branch'])) {
                $result = $this->branch($cid, $branch['branch']);
                if($result) {
                    return $result;
                }
            }
        }

        return false;
    }

    /**
     * 获取某个元素的所有子栏目列表
     * @param int $cid 元素 id
     * @return array
     */
    public function children($cid)
    {
        $root = $this->branch($cid);

        if($cid == 0) {
            $root['branch'] = $root;
        }

        function children ($root, &$children) {
            if(isset($root['branch'])) {
                foreach($root['branch'] as $branch) {
                    children($branch, $children);
                }
                unset($root['branch']);
            }
            $children[] = $root;
            return $children;
        }

        if(isset($root['branch'])) {
            $children = array();
            foreach($root['branch'] as $branch) {
               children($branch, $children);
            }
        } else {
            $children = false;
        }

        return $children;
    }

    /**
     * 获取某个元素的所有父栏目列表
     * @param int $cid 元素 id
     * @return array
     */
    public function parents($cid)
    {
        $listArr = $this->getList()->toArray();
        foreach ($listArr as $value) {
            $list[$value['cid']] = $value;
        }

        $parents = array();
        $currentCid = $cid;

        while(1) {
            if(!isset($list[$currentCid]) || !isset($list[$list[$currentCid]['parent_cid']])) {
                break;
            }
            $parents[] = $list[$list[$currentCid]['parent_cid']];
            $currentCid = $list[$currentCid]['parent_cid'];
        }

        return $parents ?: false;
    }

    // 设置主菜单显示
    public function setNavShow($cid, $navShow)
    {
        $result = $this->where('cid', $cid)->update(['nav_show' => $navShow]);

        // 清理缓存
        $this->_clearCache();

        return $result;
    }

    /**
     * 获取栏目信息
     * @param int $cid 栏目 id
     * @return array 栏目信息
     */
    public function info($cid)
    {
        $info = $this->where('cid', $cid)->where('status', '<>', 0)->first();

        return $info;
    }

    /**
     * 获取栏目附件列表
     * @param $textNo 富文本编号
     */
    public function getAttachList($textNo)
    {
        $data = DB::table('attach_cate as ca')->
            join('attachment as a', 'a.aid', '=', 'ca.aid')->
            where('ca.text_no', $textNo)->
            get();

        return $data;
    }

    /**
     * 编辑栏目
     * @param mixed $cate 栏目信息
     * @param boolean 是否编辑成功
     */
    public function modify($data)
    {
        // 父栏目不能为自己
        if($data['parent_cid'] == $data['cid']) {
            $this->error = '栏目层级关系错误';
            return false;
        }
        // 取旧数据, 如果父栏目发生变化, 验证合理性, 并处理子栏目的栏目级别
        $oldInfo = DB::table('category')->where('cid', $data['cid'])->first();
        if($oldInfo->parent_cid != $data['parent_cid']) {
            // 取当前栏目的所有子栏目
            $children = $this->children($data['cid']);
            $toUpdateCids = array(); // 需要更新的栏目 id
            foreach($children as $cate) {
                // 如果新的父栏目是子栏目中的一个, 退出
                if($cate['cid'] == $data['parent_cid']) {
                    $this->error = '栏目层级关系错误';
                    return false;
                }
                $toUpdateCids[] = $cate['cid'];
            }

            // 新的栏目级别
            $parent = $this->info($data['parent_cid']);
            $newLevel = $data['parent_cid'] == 0 ? 1 : $parent->level + 1;

            // 需要更新的级别
            $updateLevel = $newLevel - $oldInfo->level;
            if($updateLevel && !empty($toUpdateCids)) {
                $this->whereIn('cid', $toUpdateCids)->increment('level', $updateLevel);
            }

            // 处理当前栏目级别
            $data['level'] = $newLevel;
        }

        $result = $this->where('cid', $data['cid'])->update($data);

        if($result === false) {
            $this->error = '数据库写入错误';
            return false;
        }

        // 清理缓存
        $this->_clearCache();

        return true;
    }

    /**
     * 新增栏目
     * @param mixed $cate 栏目信息
     * @return int 新增栏目 id
     */
    public function addNew ($cate) {
        // 处理栏目级别
        $parent = $this->info($cate['parent_cid']);
        $cate['level'] = $cate['parent_cid'] == 0 ? 1 : ++$parent->level;

        $newId = $this->insertGetId($cate);

        if($newId === false) {
            $this->error = '数据库写入错误';
            return false;
        }

        // 清理缓存
        $this->_clearCache();

        return $newId;
    }

    // 设置封面图片
    public function setCover($cid, $aid) {
        $result = $this->where('cid', $cid)->update(['cover_aid' => $aid]);
        $this->_clearCache();

        return $result;
    }

    /**
     * 删除栏目
     * @param int $cid 栏目 id
     * @param int $uid 操作者 uid
     * @return boolean 成功设置与否
     */
    public function remove ($cid, $uid) {
        return $this->setStatus($cid, 0, $uid);
    }

    // 获取整个树的两层
    public function treeLevel2()
    {
        $cacheKey = config('cache.cache_keys.category_tree_status_1');

        Cache::rememberForever($cacheKey, function () {
            return $this->
                where('status', 1)->
                where('level', '<=', 2)->
                where('nav_show', 1)->
                orderBy('level')->
                orderBy('sortord',  'desc')->
                select('cid', 'parent_cid', 'level', 'nav_show', 'name', 'path', 'list_allow', 'status', 'cover_aid')->
                get()->
                toArray();
        });

        $list = Cache::get($cacheKey);
        $tree = [];

        foreach ($list as $key => $value) {
            if($value['level'] == 1) {
                $tree[$value['cid']] = $value;
            }
        }

        foreach ($list as $key => $value) {
            if($value['level'] == 2)
            $tree[$value['parent_cid']]['sub'][] = $value;
        }

        return $tree;
    }
}
