<?php namespace Phpcmf\ThirdParty\Storage;

require_once __DIR__ . '/bootstrap.php';

use ExerciseBook\Flysystem\ImageX\Config as ImageXConfig;
use ExerciseBook\Flysystem\ImageX\ImageXAdapter;
use ExerciseBook\ImageXKuJue\Config\Config;
use ExerciseBook\ImageXKuJue\Config\FileProcessingCommand;

class ImageXKuJueProvider
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var FileProcessingCommand
     */
    private $command;

    /**
     * @var ImageXAdapter
     */
    private $imagexService;

    /**
     * @param $attachmentConfig ?array 存储设置，和你在 `config.html` 中定义的 `value` 字段含义保持一致。</br>
     * 例：你在 `config.html` 的 `value` 写的是 `$data['value']['example']`
     * 在这里你可以通过 `$attachmentConfig['value']['example']` 读取出来。
     * @param $filename string 用户上传的文件的文件名
     * @return ImageXKuJueProvider
     */
    public function init($attachmentConfig, $filename)
    {
        $this->config = new Config();

        $this->config->region = $attachmentConfig['value']['region'];
        $this->config->accessKey = $attachmentConfig['value']['assess_key'];
        $this->config->secretKey = $attachmentConfig['value']['assess_secret'];
        $this->config->serviceId = $attachmentConfig['value']['service_id'];
        $this->config->domain = $attachmentConfig['value']['domain'];

        $this->config->storageType = $attachmentConfig['value']['storage_type'];
        $template = $attachmentConfig['value']['template'];
        if (strpos($template, '~')  === 0) {
            $template = substr($template, 1, strlen($template));
        }
        if (strpos($template, '.') === false) {
            $template = $template . '.image';
        }
        $this->config->template = $template;

        $this->command = new FileProcessingCommand();
        $this->command->filename = $filename;

        $this->imagexService = new ImageXAdapter($this->config);

        return $this;
    }

    /**
     * @param $type int 存储服务编号
     * @param $data string
     * @param $watermark int
     * @return array
     */
    public function upload($type, $data, $watermark)
    {
        $contents = fopen($data, 'rb');
        $meta = $this->imagexService->writeStream($this->command->filename, $contents, new ImageXConfig());

        $md5 = md5_file($this->command->filename);

        $schemeHttps = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'));
        $url = ($schemeHttps ? 'https:' : 'http:') . "//" . $this->config->domain . '/' . $this->command->filename;
        if ($this->config->isImageProcessing() && $this->config->hasTemplate()) {
            $url = $url . '~' . $this->config->template;
        }

        return dr_return_data(1, 'ok', [
            'url' =>  $url,
            'md5' => $md5,
            'size' => $meta['size'],
            'info' => $meta
        ]);
    }

    /**
     * @return void
     */
    public function delete()
    {
        $this->imagexService->delete($this->command->filename);
    }
}
