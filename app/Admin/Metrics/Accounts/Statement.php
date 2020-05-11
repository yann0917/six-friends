<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/10 16:46
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/10 16:46
 */

namespace App\Admin\Metrics\Accounts;


use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\ApexCharts\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Statement extends Chart
{
    public function __construct($containerSelector = null, $options = [])
    {
        parent::__construct($containerSelector, $options);
        $this->setUpOptions();
    }

    protected function setUpOptions()
    {
        $color = Admin::color();

        $colors = [$color->success(), $color->danger()];

        $this->options([
            'colors' => $colors,
            'chart' => [
                'type' => 'bar',
                'height' => 430,
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'dataLabels' => [
                        'position' => 'top',
                    ],
                    'columnWidth' => '55%',
                    'endingShape' => 'rounded',
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
                'offsetX' => -6,
                'style' => [
                    'fontSize' => '12px',
                    'colors' => ['#fff'],
                ],
            ],
            'stroke' => [
                'show' => true,
                'width' => 1,
                'colors' => ['#fff'],
            ],
            'xaxis' => [
                'categories' => [],
            ],
            'yaxis' => [
                'title' => [
                    'text' => '单位：元'
                ]
            ],
            'title' => [
                'text' => '账单流水',
                'align' => 'center',
            ],
        ]);
    }


    /**
     * 处理请求
     *
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $month = date('Y-m-d 00:00:00', strtotime('-1 month'));
        $week = date('Y-m-d 00:00:00', strtotime('-1 week'));
        $statements = \App\Models\Statement::select(DB::raw('sum(if (type=1, money, 0)) as income, sum(if (type=2,money,0)) as outcome'), 'date')->groupBy('date');
        switch ((int)$request->get('option')) {
            case 30:
                $statements = $statements->where('created_at', '>=', $month)->get();
                break;
            case 7:
            default:
                $statements = $statements->where('created_at', '>=', $week)->get();
                break;
        }

        $data = [
            [
                'name' => '收入',
                'data' => $statements->pluck('income')->map(
                    function ($item, $key) {
                        return $item * 0.01;
                    }
                )->all()
            ],
            [
                'name' => '支出',
                'data' => $statements->pluck('outcome')->map(
                    function ($item, $key) {
                    return $item * 0.01;
                })->all()
            ],
        ];
        $categories = $statements->pluck('date')->all();

        $this->withData($data);
        $this->withCategories($categories);
    }

    /**
     * 设置图表数据
     *
     * @param array $data
     * @return $this
     */
    public function withData(array $data)
    {
        return $this->option('series', $data);
    }

    /**
     * 设置图表类别.
     *
     * @param array $data
     * @return $this
     */
    public function withCategories(array $data)
    {
        return $this->option('xaxis.categories', $data);
    }

    /**
     * 渲染图表
     *
     * @return string
     */
    public function render()
    {
        $this->buildData();

        return parent::render();
    }
    
}
