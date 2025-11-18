<?php
/**
 * ConfigItemApiController.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\controllers\api
 */

namespace fractalCms\content\controllers\api;

use Exception;
use fractalCms\content\components\Constant;
use fractalCms\core\components\Constant as CoreConstant;
use fractalCms\content\models\ConfigItem;
use fractalCms\core\controllers\api\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ConfigItemController extends BaseController
{


    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['delete'],
                    'verbs' => ['delete'],
                    'roles' => [Constant::PERMISSION_MAIN_CONFIG_ITEM.CoreConstant::PERMISSION_ACTION_DELETE],
                ],
            ],
            'denyCallback' => function ($rule, $action) {
                throw new ForbiddenHttpException();
            }
        ];
        return $behaviors;
    }


    /**
     * Delete item config
     *
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id) : Response
    {
        try {
            $response = Yii::$app->getResponse();
            $model = ConfigItem::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('config not found');
            }
            $model->delete();
            $response->statusCode = 204;
            return $response;
        } catch (Exception $e)  {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }
}
