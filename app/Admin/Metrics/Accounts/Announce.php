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

class Announce extends Card
{
    /**
     * 卡片底部内容.
     *
     * @var string|Renderable|\Closure
     */
    protected $footer;

    protected $labels = ['主题', '内容', '时间'];

    /**
     * 初始化卡片.
     */
    protected function init()
    {
        parent::init();

        $this->title('公告栏');
        $this->subTitle('最新公告');
    }

    /**
     * 处理请求
     *
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $notice = \App\Models\Announce::select('title', 'content', 'created_at')->orderBy('id', 'desc')->first();
        $title = $notice->title ?? '';
        $content = $notice->content ?? '';
        $created = $notice->created_at ?? '';
        if ($content) {
            $this->withContent($title, $content, $created);
        }
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $created
     * @return AccountBalance
     */
    public function withContent(string $title, string $content, string $created)
    {
        $pink = Admin::color()->alpha('danger', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 240;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$title}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-success"></i> {$this->labels[1]}
    </div>
    <div>{$content}</div>
</div>

<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-success"></i> {$this->labels[2]}
    </div>
    <div>{$created}</div>
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
            "<i class=\"feather icon-speaker text-secondary\"></i> "
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
