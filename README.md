Yii2 Highcharts Wrapper
=======================

Highcharts widget is a wrapper of [Highcharts](http://www.highcharts.com/) for Yii2 Framework.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist maddoger/yii2-highcharts "*"
```

or add

```
"maddoger/yii2-highcharts": "*"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply use it in your code by:

```php
use maddoger\widgets\Highcharts;

echo Highcharts::widget([
        'chartVariable' => 'cpuChart',
        'options' => [
            'style' => 'width: 100%; height: 400px;',
        ],
        'clientOptions' => [
            'chart' => [
                'type' => 'line',
            ],
            'title' => [
                'text' => 'CPU Usage',
            ],
            'xAxis' => [
                'type' => 'datetime',
                'tickPixelInterval' => 150,
                'maxZoom' => 20 * 2000,
            ],
            'yAxis' => [
                'min' => 0,
                'max' => 100,
                'title' => [
                    'text' => '%',
                ],
            ],
            'series' => [
                [
                    'name'=> 'Core 1',
                    'data'=> [],
                ],
                [
                    'name'=> 'Core 2',
                    'data'=> [],
                ],
            ],
        ],
    ]);
```


