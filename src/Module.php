<?php

/**
 * @package yii2-scorm
 * @author iflux1990
 * @version 1.0rc
 */

use Yii;
use yii\base\Module as YiiModule;

/**
 * @inheritDoc
 */
class Module extends YiiModule
{
    /**
     * @inheritdoc
     *
     * @return void
     */
    public function init()
    {
        Yii::setAlias("@yii2-scorm", @vendor/iflux1990/yii2-scorm);

        $config = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yii2-scorm/src/messages',
            'forceTranslation' => true
        ];

        $globalConfig = ArrayHelper::getValue(Yii::$app->i18n->translations, "yii2-scorm", []);

        if(!empty($this->i18n) && is_array($this->i18n)) {
            $config = array_merge($config, is_array($globalConfig) ? $globalConfig : (array)$globalConfig);
        }

        if (!empty($this->i18n) && is_array($this->i18n)) {
            $config = array_merge($config, $this->i18n);
        }

        Yii::$app->i18n->translations["yii-scorm"] = $config;

        parent::init();
    }
}