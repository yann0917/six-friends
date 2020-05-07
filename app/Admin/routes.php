<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('columnist', 'ColumnistController'); // 写手管理
    $router->resource('account_category', 'AccountCategoryController'); // 账单分类
    $router->resource('statement', 'StatementController'); // 账单流水

    $router->group(['prefix' => 'api'], function(Router $router){
        $router->get('account_category', 'AccountCategoryController@category');
    });

});
