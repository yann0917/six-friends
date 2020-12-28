<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('columnist', 'ColumnistController'); // 写手管理
    $router->get('statement/export', 'StatementController@export'); // 账单流水
    $router->resource('account_category', 'AccountCategoryController'); // 账单分类
    $router->resource('statement', 'StatementController'); // 账单流水
    $router->resource('messages', 'MessageController'); // 留言
    $router->resource('announce', 'AnnounceController'); // 公告
    $router->resource('archives', 'ArchiveDocController'); // 资料库
    $router->resource('tags', 'ArchiveTagController'); // 资料库标签
    $router->resource('stars', 'ArchiveStarController'); // 资料库明星

    $router->group(['prefix' => 'api'], function (Router $router) {
        $router->get('account_category', 'AccountCategoryController@category');
        $router->get('tags', 'ArchiveTagController@tags');
        $router->get('stars', 'ArchiveStarController@stars');
    });

});
