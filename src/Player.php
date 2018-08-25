<?php
namespace iflux1990\scorm;

use ZipArchive;
use PlayerAsset;
use yii\base\Widget;

/**
 * Widget class for scorm player.
 * Takes a SCORM package and unzips it into a playable iframe.
 */
class Player extends Widget
{
    private $_tempLocation = ___DIR___ . "/assets/package";

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function run()
    {
        PlayerAsset::register($this);

        return "Player loaded!";
    }

    /**
     * extracts the contents of a zip file to known location
     *
     * @param string $filePath The path to a compliant SCORM package in the .zip format
     *
     * @return void
     */
    private function _openZip($filePath)
    {
        $zipObject = new ZipArchive();
        if ($zipObject->open($filePath)) {
            $zipObject->extractTo($this->_tempLocation);
            $zipObject->close();
    
            unlink($filePath);
        } else {
            throw new ErrorException(Yii::t('yii2-scorm', "Unable to open the suplied file"));
        }
    }
}
