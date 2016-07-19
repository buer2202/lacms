<?php
namespace App\Repositories;

use Doctrine\Common\Collections\Collection;
use App\Attachment;

class AttachmentRepository
{
    protected $attachment;

    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    public function addnew($description, $md5, $ext, $size, $uri)
    {
        // 如果是图片
        if(in_array($ext, array('jpg', 'gif', 'png', 'jpeg'))) {
            $imageSize = getimagesize('.' . $uri);
            $width     = $imageSize[0];
            $height    = $imageSize[1];

            $fileInfo = $this->attachment->addImage($description, $md5, $ext, $size, $uri, $width, $height); // 记录文件数据
            if(!$fileInfo) {
                unlink($uri);
                $this->error = $this->attachment->error;
                return false;
            }

            $aid = $fileInfo['aid'];
        } else {
            $fileInfo = $this->attachment->addnew($description, $md5, $ext, $size, 2); // 记录文件数据
            $aid = $fileInfo['aid'];

            if(!$aid) {
                unlink($uri);
                $this->error = $this->attachment->error;
                return false;
            }
        }

        return $aid;
    }
}
