<?php
/**
 * Constant.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\components
 */
namespace fractalCms\content\components;

use Yii;
use Exception;

class Constant
{

    const PERMISSION_MAIN_CONTENT = 'FRACTAL_CMS:CONTENT:';
    const PERMISSION_MAIN_TAG = 'FRACTAL_CMS:TAG:';
    const PERMISSION_MAIN_ITEM = 'FRACTAL_CMS:ITEM:';
    const PERMISSION_MAIN_MENU = 'FRACTAL_CMS:MENU:';
    const PERMISSION_MAIN_CONTENT_ITEM = 'FRACTAL_CMS:CONTENT:ITEM:';
    const PERMISSION_MAIN_TAG_ITEM = 'FRACTAL_CMS:TAG:ITEM:';
    const PERMISSION_MAIN_CONTENT_TAG = 'FRACTAL_CMS:CONTENT:TAG';
    const PERMISSION_MAIN_CONFIG_TYPE = 'FRACTAL_CMS:CONFIG:TYPE:';
    const PERMISSION_MAIN_CONFIG_ITEM = 'FRACTAL_CMS:CONFIG:ITEM:';

    const TRACE_DEBUG = 'debug';

    public static $main = [
        Constant::PERMISSION_MAIN_CONTENT => 'Article',
        Constant::PERMISSION_MAIN_ITEM => 'Elément',
        Constant::PERMISSION_MAIN_TAG => 'Tag (étiquette)',
        Constant::PERMISSION_MAIN_MENU => 'Menu',
        Constant::PERMISSION_MAIN_CONFIG_TYPE => 'Configuration article',
        Constant::PERMISSION_MAIN_CONFIG_ITEM => 'Configuration élément',
    ];
}
