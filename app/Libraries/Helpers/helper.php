<?php
// 显示分类选择器
function categorySelector($selectId, $selectName, $selectClass, $value, $showRoot)
{
    $category = app(App\Category::class);

    $tree = $category->tree();
    $select = array(
        'id'    => $selectId,
        'name'  => $selectName,
        'class' => $selectClass,
        'value' => $value,
    );
    $showRoot = $showRoot;

    $html = view('admin.category.selector', compact('tree', 'select', 'showRoot'))->render();

    view()->share('categorySelector', $html);
}

/**
 * 获取文件路径
 * @param string $md5 附件MD5
 * @param string $ext 附件后缀名
 * @param string $action 动作：set：创建路径, 否则获取路径
 */
function attachmentUri($md5, $ext, $action = 'get') {
    $rootPath = config('upload.attachment.path');   // 附件根路径
    $relativePath = '.' . $rootPath;
    $dir = substr($md5, 0, 2);

    // 将新文件以md5去掉前两位字符命名
    $newName = substr($md5, 2) . '.' . $ext;

    // 文件路径
    $path = $rootPath . '/' . $dir . '/' . $newName;

    return [
        'dir'      => $rootPath . '/' . $dir,
        'filename' => $newName,
        'path'     => $path,
    ];
}
