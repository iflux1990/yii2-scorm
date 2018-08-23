<?php
namespace iflux1990\scorm;

use ZipArchive;
use yii\base\Widget;

/**
 * Widget class for scorm player.
 * Takes a SCORM package and unzips it into a playable iframe.
 */
class Player extends Widget
{
    private $_tempLocation = ___DIR___/package;

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function run()
    {
        return "Player loaded!";
    }

    /**
     * Undocumented function
     *
     * @param string $filePath The path to a compliant SCORM package in the .zip format
     *
     * @return void
     */
    private function _openZip($filePath)
    {
        $zipObject = new ZipArchive();
        if ($zipObject->open($filePath)) {
            $zipObject->extractTo($target);
            $zipObject->close();
    
            unlink($filePath);
        } else {
            throw new ErrorException(Yii::t('yii2-scorm', "Unable to open the suplied file"));
        }
    }
}
