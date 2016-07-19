<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
    public $timestamps = false;

    // 获取群组及内容
    public function getGroupContent($gid, $limit = 0)
    {
        $group = $this->where('gid', $gid)->where('status', 1)->first();
        $content = \App\GroupContent::where('gid', $gid)->orderBy('sortord', 'desc');

        if($limit) {
            $content = $content->limit($limit);
        }

        $group->content = $content->get();

        return $group;
    }
}
