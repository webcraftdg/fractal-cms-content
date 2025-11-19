<?php
/**
 * MenuController.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\controllers
 */

namespace fractalCms\content\controllers;

use Exception;
use fractalCms\content\components\Constant;
use fractalCms\core\components\Constant as CoreConstant;
use fractalCms\content\helpers\MenuItemBuilder;
use fractalCms\content\models\Menu;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MenuController extends BaseAdminController
{

    protected MenuItemBuilder $menuItemBuilder;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'update', 'create'],
                    'roles' => [Constant::PERMISSION_MAIN_MENU.CoreConstant::PERMISSION_ACTION_LIST],
                    'denyCallback' => function ($rule, $action) {
                        return $this->redirect(['default/index']);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => [Constant::PERMISSION_MAIN_MENU.CoreConstant::PERMISSION_ACTION_CREATE],
                    'denyCallback' => function ($rule, $action) {
                        return $this->redirect(['default/index']);
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'roles' => [Constant::PERMISSION_MAIN_MENU.CoreConstant::PERMISSION_ACTION_UPDATE],
                    'denyCallback' => function ($rule, $action) {
                        return $this->redirect(['default/index']);
                    }
                ]
            ]
        ];
        return $behaviors;
    }

    public function __construct($id, $module, MenuItemBuilder $menuItemBuilder, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->menuItemBuilder = $menuItemBuilder;
    }

    /**
     * Liste
     *
     * @return string
     * @throws Exception
     */
    public function actionIndex() : string
    {
        try {
            $modelsQuery = Menu::find();
            return $this->render('index', [
                'modelsQuery' => $modelsQuery
            ]);
        } catch (Exception $e)  {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }

    /**
     * Create
     *
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionCreate() : string | Response
    {
        try {
            $response = null;
            $model = Yii::createObject(Menu::class);
            $model->scenario = Menu::SCENARIO_CREATE;

            $request = Yii::$app->request;

            if ($request->isPost === true) {
                $body = $request->getBodyParams();
                $model->load($body);
                if ($model->validate() === true) {
                    $model->save();
                    $model->refresh();
                    $response = $this->redirect(['menu/update', 'id' => $model->id]);
                }
            }
            $menuItemHtml = null;
            if ($this->menuItemBuilder !== null) {
                $menuItemHtml = $this->menuItemBuilder->build($model);
            }
            if ($response === null) {
                $response =  $this->render('manage', [
                    'model' => $model,
                    'menuItemHtml' => $menuItemHtml,
                ]);
            }
            return  $response;
        } catch (Exception $e)  {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }

    /**
     * Update
     *
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id = null) : string | Response
    {
        try {
            //find menu
            $response = null;
            $model = Menu::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('content not found');
            }
            $model->scenario = Menu::SCENARIO_UPDATE;
            $request = Yii::$app->request;
            if ($request->isPost === true) {
                $body = $request->getBodyParams();
                $model->load($body);
                if ($model->validate() === true) {
                    $model->save();
                    $model->refresh();
                    $response = $this->redirect(['menu/index']);
                }
            }
            $menuItemHtml = null;
            if ($this->menuItemBuilder !== null) {
                $menuItemHtml = $this->menuItemBuilder->build($model);
            }
            if ($response === null) {
                $response = $this->render('manage', [
                    'model' => $model,
                    'menuItemHtml' => $menuItemHtml,
                ]);
            }
            return $response;
        } catch (Exception $e)  {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }

}
