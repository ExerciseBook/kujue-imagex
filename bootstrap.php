<?php

/****************************************************************
 *
 * ImageX Storage 的初始化文件
 *
 ****************************************************************/

/**
 * 硬核包管理器
 */
require_once __DIR__ . '/./vendor/autoload.php';

/**
 * VolcEngine 与 ImageX
 */
require_once __DIR__ . '/./src/Volc/Base/SignatureTrait.php';
require_once __DIR__ . '/./src/Volc/Base/SignatureV4.php';
require_once __DIR__ . '/./src/Volc/Base/V4Curl.php';

require_once __DIR__ . '/./src/Volc/Service/ImageX.php';

/**
 * 伪 · FlySystem Adapter
 */
require_once __DIR__ . '/./src/ExerciseBook/Flysystem/ImageX/Exception/ImageXException.php';
require_once __DIR__ . '/./src/ExerciseBook/Flysystem/ImageX/Exception/FilesystemException.php';
require_once __DIR__ . '/./src/ExerciseBook/Flysystem/ImageX/Exception/FileNotFoundException.php';

require_once __DIR__ . '/./src/ExerciseBook/Flysystem/ImageX/Config.php';
require_once __DIR__ . '/./src/ExerciseBook/Flysystem/ImageX/ImageXConfig.php';
require_once __DIR__ . '/./src/ExerciseBook/Flysystem/ImageX/ImageXAdapter.php';

/**
 * KuJue
 */
require_once __DIR__ . '/./src/ExerciseBook/ImageXKuJue/Config/Config.php';
require_once __DIR__ . '/./src/ExerciseBook/ImageXKuJue/Model/FileProcessingCommand.php';
