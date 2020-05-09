<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/9 10:10
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/9 10:10
 */

namespace App\Admin\Extensions;


use Dcat\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/vendors/wangEditor-3.1.1/release/wangEditor.min.css',
    ];

    protected static $js = [
        '/vendors/wangEditor-3.1.1/release/wangEditor.min.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);

        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.zIndex = 0
editor.customConfig.uploadImgShowBase64 = true
editor.customConfig.onchange = function (html) {
    $('input[name=$name]').val(html);
}
editor.create()

EOT;
        return parent::render();
    }
}
