<?php

Route::post('login', 'Auth\LoginController@login');


Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'auth:api'], function () {
    //用户信息
    Route::get('{id}/info', 'UserController@userInfo');

    Route::group(['prefix' => 'friend'], function () {
        //搜索好友
        Route::post('search', 'FriendController@searchFriend');
        //好友认证消息
        Route::post('auth', 'FriendController@storeFriendAuth');
        //好友添加消息列表
        Route::get('auth', 'FriendController@friendAuthList');
        //未读消息统计
        Route::get('auth/count', 'FriendController@friendAuthCount');
    });

    Route::apiResources([
        'column' => 'ColumnController',//好友分栏
        'friend' => 'FriendController',//好友
    ]);

});

Route::group(['prefix' => 'chat', 'namespace' => 'Chat', 'middleware' => 'auth:api'], function () {

    Route::apiResources([
        'msg' => 'MsgRecordController',//消息记录
    ]);

});
