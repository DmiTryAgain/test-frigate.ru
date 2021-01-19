<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/all.min.css',
        'css/main.css',
    ];
    public $js = [
        'https://code.jquery.com/jquery-3.5.1.slim.min.js',
        'js/bootstrap.bundle.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
