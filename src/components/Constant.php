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

    const PERMISSION_MAIN_CONTENT = 'CONTENT:';
    const PERMISSION_MAIN_TAG = 'TAG:';
    const PERMISSION_MAIN_ITEM = 'ITEM:';
    const PERMISSION_MAIN_MENU = 'MENU:';
    const PERMISSION_MAIN_CONTENT_ITEM = 'CONTENT:ITEM:';
    const PERMISSION_MAIN_TAG_ITEM = 'TAG:ITEM:';
    const PERMISSION_MAIN_CONTENT_TAG = 'CONTENT:TAG';
    const PERMISSION_MAIN_CONFIG_TYPE = 'CONFIG:TYPE:';
    const PERMISSION_MAIN_CONFIG_ITEM = 'CONFIG:ITEM:';

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
