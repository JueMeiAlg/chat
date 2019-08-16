<?php

Route::post('login', 'Auth\LoginController@login');


Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'auth:api'], function () {
    //用户信息
    Route::get('{id}/info', 'UserController@userInfo');

    Route::group(['prefix' => 'friend'], function () {
        //搜索好友
        Route::post('search', 'FriendController@searchFriend');
    });

    Route::apiResources([
        'column' => 'ColumnController',//好友分栏
        'friend' => 'FriendController'//好友
    ]);

});
