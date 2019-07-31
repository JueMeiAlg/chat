<?php

Route::post('login', 'Auth\LoginController@login');


Route::group(['prefix'=>'user', 'namespace'=>'User'], function (){
    //用户信息
    Route::get('{id}/info', 'UserController@userInfo');
});