<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/10 16:49
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/10 16:49
 */

namespace App\Admin\Metrics\Accounts;


use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Columnist extends Round
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->danger(), $color->success(), $color->orange(), $color->gray()];

        $this->title('写手统计');
        $this->chartLabels(\App\Models\Columnist::getStatus());
        $this->chartColors($colors);
        $this->dropdown([
            // '7' => '最近 7 天',
            // '30' => '最近一个月',
            // '365' => '最近一年',
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
        switch ($request->get('option')) {
            // case '365':
            // case '30':
            // case '7':
            default:
                $columnists = \App\Models\Columnist::select(DB::raw('count(*) as count, status'))
                    ->groupBy('status')
                    ->pluck('count', 'status');

                $rejected = 0;
                $cooperating = 0;
                $pending = 0;
                $finished = 0;

                foreach ($columnists as $key => $count) {
                    switch ($key) {
                        case 0:
                            $rejected = $count;
                            break;
                        case 1:
                            $cooperating = $count;
                            break;
                        case 2:
                            $pending = $count;
                            break;
                        case 3:
                            $finished = $count;
                            break;
                    }
                }

                // 卡片内容
                $this->withContent($rejected, $cooperating, $pending, $finished);

                // 图表数据
                $total = $columnists->sum($columnists->pluck('count')->all());

                $rejected_rate = round($rejected / $total,2) * 100;
                $cooperating_rate = round($cooperating / $total, 2) * 100;
                $pending_rate = round($pending / $total, 2) * 100;
                $finished_rate = round($finished / $total, 2) * 100;

                $this->withChart([$rejected_rate, $cooperating_rate, $pending_rate, $finished_rate]);

                // 总数
                $this->chartTotal('Total', $total);
        }
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
     * 卡片内容.
     *
     * @param int $rejected
     * @param int $cooperating
     * @param int $pending
     * @param int $finished
     * @return $this
     */
    public function withContent($rejected, $cooperating, $pending, $finished)
    {
        return $this->content(
            <<<HTML
<div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
    <div class="chart-info d-flex justify-content-between mb-1 mt-2">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-danger"></i>
              <span class="text-bold-600 ml-50">淘汰</span>
          </div>
          <div class="columnist-result">
              <span>{$rejected}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1" >
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-success"></i>
              <span class="text-bold-600 ml-50">合作中</span>
          </div>
          <div class="columnist-result">
              <span>{$cooperating}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-warning"></i>
              <span class="text-bold-600 ml-50">暂停合作</span>
          </div>
          <div class="columnist-result">
              <span>{$pending}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1" >
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-secondary"></i>
              <span class="text-bold-600 ml-50">终止合作</span>
          </div>
          <div class="columnist-result">
              <span>{$finished}</span>
          </div>
    </div>

</div>
HTML
        );
    }

}
