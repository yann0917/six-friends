<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/10 20:02
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/10 20:02
 */

namespace App\Admin\Metrics\Accounts;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeOutcome extends Donut
{
    protected $labels = ['收入', '支出'];
    /**
     * 卡片底部内容.
     *
     * @var string|Renderable|\Closure
     */
    protected $footer;

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->success(), $color->alpha('danger', 0.5)];

        $this->title('收支统计');
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
        $this->dropdown([
            '7' => '最近 7 天',
            '30' => '最近一个月',
            '180' => '最近半年',
            '365' => '最近一年',
        ]);
        $this->unit();
    }

    /**
     * 处理请求
     *
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $year = date('Y-m-d 00:00:00', strtotime('-1 year'));
        $half_year = date('Y-m-d 00:00:00', strtotime('-180 days'));
        $month = date('Y-m-d 00:00:00', strtotime('-1 month'));
        $week = date('Y-m-d 00:00:00', strtotime('-1 week'));

        $balance = \App\Models\Statement::select(DB::raw('sum(if (type=1, money, 0)) as income, sum(if (type=2,money,0)) as outcome'));
        switch ($request->get('option')) {
            case '365':
                $balance = $balance->where('date', '>=', $year)->first();
                break;
            case '180':
                $balance = $balance->where('date', '>=', $half_year)->first();
                break;
            case '30':
                $balance = $balance->where('date', '>=', $month)->first();
                break;
            case '7':
            default:
                $balance = $balance->where('date', '>=', $week)->first();
        }

        $income = $balance->income ? $balance->income * 0.01 : 0;
        $outcome = $balance->outcome ? $balance->outcome * 0.01 : 0;

        // 卡片内容
        $this->withContent($income, $outcome);

        // 图表数据
        $this->withChart([$income, $outcome]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $income
     * @param mixed $outcome
     * @return $this
     */
    protected function withContent($income, $outcome)
    {
        $blue = Admin::color()->alpha('danger', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-success"></i> {$this->labels[0]}
    </div>
    <div>{$income}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$outcome}</div>
</div>

<div class="ml-1 mt-1 font-weight-bold text-80">
    {$this->renderFooter()}
</div>
HTML
        );
    }

    /**
     * 设置单位
     *
     * @return $this
     */
    public function unit()
    {
        return $this->footer(
            "<i class=\"feather icon-minus-circle text-secondary\"></i> 单位：元"
        );
    }

    /**
     * 设置卡片底部内容.
     *
     * @param string|Renderable|\Closure $footer
     * @return $this
     */
    public function footer($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * 渲染卡片底部内容.
     *
     * @return string
     */
    public function renderFooter()
    {
        return $this->toString($this->footer);
    }
}
