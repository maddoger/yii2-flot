<?php

namespace maddoger\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class Highcharts extends Widget
{
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string
     */
    public $chartVariable;

    /**
     * @var array the options for the Highcharts plugin.
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for Highcharts plugin.
     */
    public $clientEvents = [];

    /**
     * @var array modules names like "data", "boost", etc.
     */
    public $modules = [];

    /**
     * @var string theme name like 'dark-blue'
     */
    public $theme;

    /**
     * @var bool
     */
    public $enable3d = false;

    /**
     * @var bool
     */
    public $enableMore = false;

    /**
     * @var string
     */
    private $_renderTo;

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (!$this->chartVariable) {
            $this->chartVariable = 'highchart_'.$this->options['id'];
        }
        $this->_renderTo = ArrayHelper::getValue($this->clientOptions, 'chart.renderTo');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $res = '';
        if (!$this->_renderTo) {
            $this->clientOptions['chart']['renderTo'] = $this->options['id'];
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'div');
            $res = Html::tag($tag, '', $options);
        }
        $this->registerClientScript();
        return $res;
    }
    /**
     * Registers CKEditor JS
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        $asset = HighchartsAsset::register($view);

        if (!empty($this->modules)) {
            foreach ($this->modules as $module) {
                $asset->js[] = 'modules/'.$module.(YII_DEBUG ? '.src.js' : '.js');
            }
        }

        if ($this->enable3d) {
            $asset->js[] = YII_DEBUG ? 'highcharts-3d.src.js' : 'highcharts-3d.js';
        }
        if ($this->enableMore) {
            $asset->js[] = YII_DEBUG ? 'highcharts-more.src.js' : 'highcharts-more.js';
        }

        $clientOptions = $this->clientOptions;
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $key=>$function) {
                $clientOptions['chart']['events'][$key] = $function;
            }
        }
        $jsonClientOptions = empty($clientOptions) ? '' : Json::encode($clientOptions);
        $js = "var {$this->chartVariable} = new Highcharts.Chart($jsonClientOptions);";
        $view->registerJs($js);
    }
}