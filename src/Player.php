<?php
namespace iflux1990\scorm;

use Yii;
use ZipArchive;
use yii\web\View;
use yii\base\Widget;
use yii\helpers\Html;
use yii\base\Exception;

/**
 * Widget class for scorm player.
 * Takes a SCORM package and unzips it into a playable iframe.
 */
class Player extends Widget
{
    private $_tempLocation = __DIR__ . "\assets\package";
    public $path;

    /**
     * @throws Exception
     */
    public function init()
    {
        if(!$this->path) {
            throw new Exception(Yii::t("yii2-scorm", 'Missing parameter "path" for yii2-scorm/Player'));
        }

        if(!file_exists($this->path)) {
            throw new PackageNotFoundException(Yii::t('yii2-scorm', "{path} not found.", ['path' => $this->path]));
        }

        $this->_unpackZip($this->path);

        PlayerAsset::register($this->getView());

        parent::init();
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function run()
    {
        $str = "";
        $str .= Html::beginTag('div', ['id' => $this->id, 'class' => 'scorm-player']);
        $str .= Html::button('Go!', ['id' => 'yii2-scorm-go-button', 'class' => 'btn btn-default', 'onclick' => "openPackage('{$this->path}')"]);
        $str .= Html::endTag('div');

        $this->getView()->registerJs('var widgetId = "' . $this->path . "\";", View::POS_HEAD);

        return $str;
    }

    /**
     * extracts the contents of a zip file to known location
     *
     * @param string $filePath The path to a compliant SCORM package in the .zip format
     *
     * @return void
     */
    private function _unpackZip($filePath)
    {
        $zipObject = new ZipArchive();
        $packageMd5 = md5_file($filePath);

        if(file_exists($this->_tempLocation . "/" . $packageMd5)) {
            return;
        }

        if ($zipObject->open($filePath)) {

            $tempName = time();
            $cache = new CacheManager();

            if ($zipObject->extractTo($this->_tempLocation . "/" . $tempName)) {
                $packageName = $cache->add($filePath);

                if (isset($packageName) && $packageName) {
                    $zipObject->close();

                    if (file_exists($this->_tempLocation . "/" . $packageName) && file_exists($this->_tempLocation . "/" . $tempName)) {
                        $this->deleteDirectory($this->_tempLocation . "/" . $tempName);
                    } else {
                        rename($this->_tempLocation . "/" . $tempName, $this->_tempLocation . "/" . $packageName);
                    }
                }
            }

        } else {
            throw new ErrorException(Yii::t('yii2-scorm', "Unable to open the supplied file"));
        }
    }

    /**
     * @param $directory
     * @return bool
     */
    private function deleteDirectory($directory)
    {
        if (!file_exists($directory)) {
            return true;
        }

        if (!is_dir($directory)) {
            return unlink($directory);
        }

        foreach (scandir($directory) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($directory . "/" . $item)) {
                return false;
            }

        }

        return rmdir($directory);
    }

}
