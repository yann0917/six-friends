<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Accounts\AccountBalance;
use App\Admin\Metrics\Accounts\Columnist;
use App\Admin\Metrics\Accounts\IncomeOutcome;
use App\Admin\Metrics\Accounts\Statement;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Dropdown;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('')
            ->body(function (Row $row) {

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new AccountBalance());
                        $row->column(6, new IncomeOutcome());
                    });
                });

                $row->column(6, function (Column $column) {
                    $column->row(new Columnist());
                });

                $menu = [
                    '7' => '最近 7 天',
                    '30' => '最近 30 天',
                ];
                $dropdown = Dropdown::make($menu)
                    ->button(current($menu))
                    ->click()
                    ->map(function ($v, $k) {
                        return "<a class='switch-bar' data-option='{$k}'>{$v}</a>";
                    });
                $bar = Statement::make()
                    ->fetching('$("#statement-box").loading()')
                    ->fetched('$("#statement-box").loading(false)')
                    ->click('.switch-bar');

                $box = Box::make('账单流水', $bar)
                    ->id('statement-box')
                    ->tool($dropdown);
                $row->column(12, $box);
            });
    }
}
