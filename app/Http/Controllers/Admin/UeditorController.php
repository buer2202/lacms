<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Repositories\AttachmentRepository;

class UeditorController extends Controller
{
    private $_config;
    protected $attachment;

    public function __construct(AttachmentRepository $attachment)
    {
        $this->attachment = $attachment;
    }

    public function upload(Request $request) {
        date_default_timezone_set("Asia/chongqing");
        error_reporting(E_ERROR);
        header("Content-Type: text/html; charset=utf-8");

        $this->_config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./plugins/ueditor/php/config.json")), true);

        switch ($request->action) {
            case 'config':
                $result =  json_encode($this->_config);
                break;

            /* 上传图片 */
            case 'uploadimage':
            /* 上传涂鸦 */
            case 'uploadscrawl':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':
                $result = $this->_uploadfile($request);
                break;

            /* 列出图片 */
            case 'listimage':
                $result = $this->_listImage($request);
                break;
            /* 列出文件 */
            case 'listfile':
                $result = $this->_listImage($request);
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = $this->_catchImage($request);
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($request->callback)) {
            if (preg_match("/^[\w_]+$/", $request->callback)) {
                echo htmlspecialchars($request->callback) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }

    private function _uploadfile($request) {
        /* 上传配置 */
        $base64 = "upload";
        switch (htmlspecialchars($request->action)) {
            case 'uploadimage':
                $config = array(
                    "pathFormat" => $this->_config['imagePathFormat'],
                    "maxSize" => $this->_config['imageMaxSize'],
                    "allowFiles" => $this->_config['imageAllowFiles']
                );
                $fieldName = $this->_config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathFormat" => $this->_config['scrawlPathFormat'],
                    "maxSize" => $this->_config['scrawlMaxSize'],
                    "allowFiles" => $this->_config['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $this->_config['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathFormat" => $this->_config['videoPathFormat'],
                    "maxSize" => $this->_config['videoMaxSize'],
                    "allowFiles" => $this->_config['videoAllowFiles']
                );
                $fieldName = $this->_config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathFormat" => $this->_config['filePathFormat'],
                    "maxSize" => $this->_config['fileMaxSize'],
                    "allowFiles" => $this->_config['fileAllowFiles']
                );
                $fieldName = $this->_config['fileFieldName'];
                break;
        }

        /* 生成上传实例对象并完成上传 */
        $parameters = [
            'fieldName' => $fieldName,
            'config'    => $config,
            'base64'    => $base64,
        ];

        $up = app('ueditorUploader', $parameters);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */
        $fileInfo = $up->getFileInfo();

        // 记录附件信息
        $attachmentId = $this->attachment->addnew(
            $fileInfo['title'],
            $fileInfo['md5'],
            $fileInfo['type'],
            $fileInfo['fileSize'],
            $fileInfo['uri']
        );

        /*记录数据*/
        // 判断改附件否已记录
        $ifExist = DB::table($request->model)->
            where('aid', $attachmentId)->
            where('text_no', $request->text_no)->
            first();

        if(!$ifExist) {
            // 保存关联数据
            DB::table($request->model)->insert([
                'aid'     => $attachmentId,
                'text_no' => $request->text_no,
            ]);
        }

        /* 返回数据 */
        return json_encode($fileInfo);
    }

    private function _listImage($request) {
        $files = DB::table($request->model . ' as t')->
            join('attachment as a', 'a.aid', '=', 't.aid')->
            select('a.uri as url', 'a.time_upload as mtime')->
            where('text_no', $request->text_no)->
            get();

        if(!$files) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            ));
        }

        /* 返回数据 */
        $result = json_encode(array(
            "state" => "SUCCESS",
            "list"  => $files,
            "start" => 0,
            "total" => count($files)
        ));

        return $result;
    }

    private function _catchImage() {
        /**
         * 抓取远程图片
         * User: Jinqn
         * Date: 14-04-14
         * Time: 下午19:18
         */
        set_time_limit(0);

        /* 上传配置 */
        $config = array(
            "pathFormat" => $this->_config['catcherPathFormat'],
            "maxSize" => $this->_config['catcherMaxSize'],
            "allowFiles" => $this->_config['catcherAllowFiles'],
            "oriName" => "remote.png"
        );
        $fieldName = $this->_config['catcherFieldName'];

        /* 抓取远程图片 */
        $list = array();
        if (isset($_POST[$fieldName])) {
            $source = $_POST[$fieldName];
        } else {
            $source = $_GET[$fieldName];
        }
        foreach ($source as $imgUrl) {
            $myParams = [
                'fieldName' => $imgUrl,
                'config'    => $config,
                'base64'    => 'remote',
            ];
            $item = app('ueditorUploader', $myParams);

            $info = $item->getFileInfo();
            array_push($list, array(
                "state" => $info["state"],
                "url" => $info["url"],
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ));
        }

        /* 返回抓取数据 */
        return json_encode(array(
            'state'=> count($list) ? 'SUCCESS':'ERROR',
            'list'=> $list
        ));
    }
}
