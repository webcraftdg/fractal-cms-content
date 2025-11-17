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

use fractalCms\content\interfaces\ControllerInterface;
use fractalCms\content\models\Content;
use fractalCms\content\models\Slug;
use fractalCms\content\models\Tag;
use yii\web\Controller;
use Exception;
use Yii;

class CmsController extends Controller implements ControllerInterface
{

    const EVENT_CONTENT_READY = 'contentReady';

    /**
     * @var Content | Tag $target
     */
    private Content | Tag $target;

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        try {
            parent::init();
            $target = null;
            $request = Yii::$app->request;
            $pathInfo = $request->getPathInfo();
            //Get slug with path info
            $slug = Slug::find()->andWhere(['path' => $pathInfo, 'active' => 1])->one();
            if ($slug instanceof Slug) {
                //Get content with slug
                $target = $slug->getTarget()->one();
            }
            $this->target = $target;
            //Event send when content is ready
            if ($this->target !== null) {
                $this->trigger(static::EVENT_CONTENT_READY);
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * Get content in context
     *
     * @return Content | Tag |null
     * @throws Exception
     */
    public function getTarget() : Content | Tag | null
    {
        try {
            return $this->target;
        }catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
