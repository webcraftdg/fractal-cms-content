<?php
/**
 * CmsController.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\controllers
 */

namespace fractalCms\content\controllers;

use fractalCms\content\assets\WebpackAsset;
use yii\web\Controller;
use Exception;
use Yii;

class BaseAdminController extends Controller
{

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        try {
            parent::init();
            WebpackAsset::register($this->view);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

}
