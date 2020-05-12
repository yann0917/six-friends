<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/10 16:37
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/10 16:37
 */

namespace App\Admin\Metrics\Accounts;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountBalance extends Card
{
    /**
     * 卡片底部内容.
     *
     * @var string|Renderable|\Closure
     */
    protected $footer;

    protected $labels = ['余额', '收入', '支出'];

    /**
     * 初始化卡片.
     */
    protected function init()
    {
        parent::init();

        $this->title('账户余额');
        $this->subTitle('收入-支出:￥');
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
        $balance = \App\Models\Statement::select(DB::raw('sum(if (type=1, money, 0)) as income, sum(if (type=2,money,0)) as outcome'))->first();
        $income = $balance->income * 0.01;
        $outcome = $balance->outcome * 0.01;
        $total = $income - $outcome;
        $this->withContent(number_format($total, 2),
            number_format($income, 2),
            number_format($outcome,2));
    }

    /**
     * @param string $total
     * @param string $income
     * @param string $outcome
     * @return AccountBalance
     */
    public function withContent(string $total, string $income, string $outcome)
    {
        $pink = Admin::color()->alpha('danger', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$total}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-success"></i> {$this->labels[1]}
    </div>
    <div>{$income}</div>
</div>

<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $pink"></i> {$this->labels[2]}
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
