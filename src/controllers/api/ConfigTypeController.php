<?php
/**
 * ConfigTypeController.php
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
use fractalCms\content\models\ConfigType;
use fractalCms\content\models\Content;
use fractalCms\core\controllers\api\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ConfigTypeController extends BaseController
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
                    'roles' => [Constant::PERMISSION_MAIN_CONFIG_TYPE.Constant::PERMISSION_ACTION_DELETE],
                ],
            ],
            'denyCallback' => function ($rule, $action) {
                throw new ForbiddenHttpException();
            }
        ];
        return $behaviors;
    }


    /**
     * Delete Config Type
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
            $model = ConfigType::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('user not found');
            }
            $updated = Content::updateAll(
                ['configTypeId' => null],
                'configTypeId=:configId',
                [':configId' => $id]
            );
            $model->delete();
            $response->statusCode = 204;
            return $response;
        } catch (Exception $e)  {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }
}
