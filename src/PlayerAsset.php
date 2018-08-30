<?php
namespace iflux1990\scorm;


use yii\web\AssetBundle;

/**
 * Supplies a web accessable folder for the contents for
 * whatever zip file the playerWidget was supplied
 * 
 * @author iflux1990 <dfj@iflux.dk>
 * @version 1.0.0rc
 */
class PlayerAsset extends AssetBundle
{
    public $sourcePath = "@vendor/iflux1990/yii2-scorm/src/assets";

    public $js = [
        "js/scorm-player.js"
    ];
}