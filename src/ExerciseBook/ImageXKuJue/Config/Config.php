<?php

namespace ExerciseBook\ImageXKuJue\Config;

use ExerciseBook\Flysystem\ImageX\ImageXConfig;

class Config extends ImageXConfig
{
    /**
     * @var string 存储类型
     */
    public $storageType;

    /**
     * @var string 处理模板
     */
    public $template;

    /**
     * @return bool
     */
    public function isImageProcessing() {
        return $this->storageType === "image";
    }

    /**
     * @return bool
     */
    public function isFileStorage() {
        return $this->storageType === "file";
    }

    /**
     * @return bool
     */
    public function hasTemplate() {
        return ($this->template === null || trim($this->template) === '');
    }
}