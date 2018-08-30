<?php
namespace iflux1990\scorm;

use yii\base\Component;
use yii\helpers\Json;

/**
 * Class CacheManager
 * Saves record of each unpack with fileName, hash and a timestamp.
 *
 * @package iflux1990\scorm
 * @version 1.0.0rc
 */
class CacheManager extends Component
{
    private $_cacheFileName;
    private $_cacheCount;
    private $_cache;


    public function init()
    {
        if (!file_exists(__DIR__ . "\\" . $this->getCacheFileName())) {
            touch($this->getCacheFileName());
        }

        $this->_cache = Json::decode(file_get_contents($this->getCacheFileName()));

        parent::init();
    }

    public function add($filePath)
    {
        $hash = md5_file($filePath);

        $this->_cache[$hash] = [
            'fileName' => basename($filePath),
            'timestamp' => time(),
            'size' => filesize($filePath)
        ];

        if ($this->save()) {
            return $hash;
        }
    }

    /**
     *  Saves the cache array to local json file
     */
    private function save()
    {
        $return = false;

        $cacheFile = fopen(__DIR__ . "\\" . $this->getCacheFileName(), "w");

        if ($cacheFile) {
            if(fwrite($cacheFile, Json::encode($this->_cache))) {
                $return = true;
            }

            fclose($cacheFile);
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getCacheFileName()
    {
        if ($this->_cacheFileName) {
            return $this->_cacheFileName;
        }

        return "cached-packages.json";

    }

    /**
     * @param mixed $cacheFileName
     */
    public function setCacheFileName($cacheFileName)
    {
        $this->_cacheFileName = $cacheFileName;
    }

    /**
     * @return integer
     */
    public function getCacheCount()
    {
        return $this->_cacheCount;
    }

    /**
     * @param mixed $cacheCount
     */
    public function setCacheCount($cacheCount)
    {
        $this->_cacheCount = $cacheCount;
    }
}