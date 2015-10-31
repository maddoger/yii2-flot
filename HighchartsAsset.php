<?php

namespace maddoger\widgets;

use yii\web\AssetBundle;

class HighchartsAsset extends AssetBundle
{
    public $sourcePath = '@bower/highcharts-release';

    public $js = [
        'highcharts.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}