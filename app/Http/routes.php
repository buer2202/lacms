<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*前端*/
Route::group(['middleware' => 'home'], function () {
    Route::get('/', 'Home\IndexController@index');
    Route::get('/category/{cid}', 'Home\CategoryController@index')->name('category');
    Route::get('/document/{did}', 'Home\DocumentController@index')->name('document');
    Route::get('/agreeterms', 'Home\IndexController@agreeterms');

    Route::match(['get', 'post'], '/product', 'Home\ProductController@index')->name('product');
    Route::get('/product/{cid}', 'Home\ProductController@index');
    Route::get('/fofuserlogout', 'Home\ProductController@logout');
});

// 认证
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

Route::group(['middleware' => 'auth'], function () {
    /*栏目*/
    Route::get('/admin/category', 'Admin\CategoryController@index');
    Route::post('/admin/category/ajaxsetstatus', 'Admin\CategoryController@ajaxsetstatus');
    Route::post('/admin/category/ajaxsetnavshow', 'Admin\CategoryController@ajaxsetnavshow');

    Route::get('/admin/category/editor', 'Admin\CategoryController@editor');
    Route::get('/admin/category/editor/{cid}/{parentCid}', 'Admin\CategoryController@editor');

    Route::post('/admin/category/update', 'Admin\CategoryController@update');
    Route::post('/admin/category/addnew', 'Admin\CategoryController@addnew');

    Route::post('/admin/category/ajaxsetattachmentdescription', 'Admin\CategoryController@ajaxsetattachmentdescription')->name('asad');
    Route::post('/admin/category/ajaxsetcover', 'Admin\CategoryController@ajaxsetcover')->name('asc');
    Route::post('/admin/category/ajaxdeleteattachment', 'Admin\CategoryController@ajaxdeleteattachment')->name('ada');

    /*ueditor*/
    Route::any('/admin/ueditor/upload', 'Admin\UeditorController@upload');

    /*文档*/
    Route::get('/admin/document', 'Admin\DocumentController@index');
    Route::post('/admin/document/ajaxsetstatus', 'Admin\DocumentController@ajaxsetstatus')->name('admindocstatus');

    Route::get('/admin/document/editor', 'Admin\DocumentController@editor')->name('admindocedit');
    Route::get('/admin/document/editor/{did}', 'Admin\DocumentController@editor')->name('admindoceditdid');

    Route::post('/admin/document/addnew', 'Admin\DocumentController@addnew')->name('admindocadd');
    Route::post('/admin/document/update', 'Admin\DocumentController@update')->name('admindocupdate');

    Route::post('/admin/document/ajaxsetattachmentdescription', 'Admin\DocumentController@ajaxsetattachmentdescription')->name('admindocasad');
    Route::post('/admin/document/ajaxsetcover', 'Admin\DocumentController@ajaxsetcover')->name('admindocasc');
    Route::post('/admin/document/ajaxdeleteattachment', 'Admin\DocumentController@ajaxdeleteattachment')->name('admindocada');

    /*群组*/
    Route::get('/admin/group', 'Admin\GroupController@index');
    Route::get('/admin/group/ajaxgetrow', 'Admin\GroupController@ajaxgetrow')->name('admingrouprow');

    Route::get('/admin/group/content/{gid}', 'Admin\GroupController@content')->name('groupcontent');

    Route::post('/admin/group/addnew', 'Admin\GroupController@addnew')->name('admin_group_addnew');
    Route::post('/admin/group/ajaxsetstatus', 'Admin\GroupController@ajaxsetstatus')->name('admin_group_ajaxsetstatus');

    Route::post('/admin/group/update', 'Admin\GroupController@update')->name('admin_group_update');

    Route::get('/admin/group/ajaxgetcontentrow', 'Admin\GroupController@ajaxgetcontentrow')->name('admin_group_ajaxgetcontentrow');
    Route::post('/admin/group/addcontent', 'Admin\GroupController@addcontent')->name('admin_group_addcontent');
    Route::post('/admin/group/updatecontent', 'Admin\GroupController@updatecontent')->name('admin_group_updatecontent');
    Route::post('/admin/group/addcontentbatch', 'Admin\GroupController@addcontentbatch')->name('admin_group_addcontentbatch');
    Route::post('/admin/group/removecontent', 'Admin\GroupController@removecontent')->name('admin_group_removecontent');

    Route::get('/admin/group/searchcontent', 'Admin\GroupController@searchcontent')->name('admin_group_searchcontent');

    /*fof用户权限*/
    Route::get('/admin/fofuserauth', 'Admin\FofUserAuthController@index');

    Route::delete('/admin/fofuserauth/ajaxdel', 'Admin\FofUserAuthController@ajaxdel')->name('fofuserdel');

    Route::get('/admin/fofuserauth/editor', 'Admin\FofUserAuthController@editor')->name('fofusereditor');
    Route::post('/admin/fofuserauth/updateorcreate', 'Admin\FofUserAuthController@updateOrCreate')->name('adminfofuserupdateorcreate');

    /*修改登陆密码*/
    Route::get('/admin/user/resetPassword', 'Admin\UserController@resetPassword');
    Route::post('/admin/user/updatePassword', 'Admin\UserController@updatePassword');
});

Route::get('/test', function (App\Document $document) {
    dump(DB::table('group')->first()->count());
    // dump(App\Group::where('gid', 0)->first()->count());

    // dump(view())
});