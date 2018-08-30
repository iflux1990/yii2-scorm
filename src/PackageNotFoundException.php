<?php
namespace iflux1990\scorm;

use yii\base\InvalidArgumentException;

/**
 * Class FileNotFoundException
 * @package iflux1990\scorm
 * @version 1.0.0rc
 */
class PackageNotFoundException extends InvalidArgumentException
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Scorm Package Not Found';
    }
}