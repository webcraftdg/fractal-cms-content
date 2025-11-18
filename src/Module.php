<?php
/**
 * Module.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content
 */

namespace fractalCms\content;


use Exception;
use fractalCms\content\components\UrlRule;
use fractalCms\content\helpers\ConfigType;
use fractalCms\content\helpers\MenuItemBuilder;
use fractalCms\content\helpers\SitemapBuilder;
use fractalCms\content\console\InitController;
use fractalCms\content\components\Constant;
use fractalCms\core\components\Constant as CoreConstant;
use fractalCms\core\models\Data;
use fractalCms\content\models\Content;
use Yii;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\helpers\Url;
use yii\web\Application as WebApplication;
use fractalCms\core\Module as CoreModule;
use fractalCms\core\interfaces\FractalCmsCoreInterface;
class Module extends \yii\base\Module implements BootstrapInterface, FractalCmsCoreInterface
{


    public $layoutPath = '@fractalCms/core/views/layouts';
    public string $viewItemPath = '@webapp/views/fractal-cms';
    public $layout = 'main';
    public $defaultRoute = 'default/index';
    public string $filePath = '@webroot/data';
    public string $relativeItemImgDirName = 'items';
    public string $relativeSeoImgDirName = 'seo';
    public string $cacheImgPath = 'cache';
    public $version = 'v1.7.0';
    public string $name = 'FractalCMS';
    public string $commandNameSpace = 'fractalCmsContent:';

    private string $contextId = 'fractal-cms-content';
    public function bootstrap($app)
    {
        try {
            Yii::setAlias('@fractalCms/content', __DIR__);

            Yii::$container->setSingleton(MenuItemBuilder::class, [
                'class' => MenuItemBuilder::class,
            ]);
            Yii::$container->setSingleton(ConfigType::class, [
                'class' => ConfigType::class,
            ]);
            Yii::$container->setSingleton(SitemapBuilder::class, [
                'class' => SitemapBuilder::class,
            ]);
            if ($app instanceof ConsoleApplication) {
                $this->configConsoleApp($app);
            } elseif ($app instanceof WebApplication) {
                $this->configWebApp($app);
            }
        } catch (Exception $e){
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * Config Web application
     *
     * @param WebApplication $app
     * @return void
     * @throws Exception
     */
    public function configWebApp(WebApplication $app) : void
    {
        try {
            $app->urlManager->addRules([
                [
                    'class' => UrlRule::class,
                ]
            ], true);
            $filePath = Yii::getAlias($this->filePath);
            if(file_exists($filePath) === false) {
                mkdir($filePath);
            }
        }catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }

    /**
     * Config Console Application
     *
     * @param ConsoleApplication $app
     * @return void
     * @throws Exception
     */
    protected function configConsoleApp(ConsoleApplication $app) : void
    {
        try {
            //Init migration
            if (isset($app->controllerMap['migrate']) === true) {
                //Add migrations namespace
                if (isset($app->controllerMap['migrate']['migrationNamespaces']) === true) {
                    $app->controllerMap['migrate']['migrationNamespaces'][] = 'fractalCms\content\migrations';
                } else {
                    $app->controllerMap['migrate']['migrationNamespaces'] = ['fractalCms\content\migrations'];
                }
            }
            $app->controllerMap[$this->commandNameSpace.'init'] = [
                'class' => InitController::class,
            ];
        }catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }

    public function getData() : Data
    {
        $nbSections = Con::find()->andWhere(['type' => Content::TYPE_SECTION])->count();
        $nbActicles = Content::find()->andWhere(['type' => Content::TYPE_ARTICLE])->count();
        $lastDate = Content::find()->max('dateCreate');
        /** @var Data $data */
        $data =  new Data(['scenario' => Data::SCENARIO_CREATE]);
        $data->nbSections = $nbSections;
        $data->nbActicles = $nbActicles;
        $data->lastDate = $lastDate;
        return $data;
    }

    /**
     * Return context Permission
     * @return array
     */
    public function getPermissions(): array
    {
        return [
            Constant::PERMISSION_MAIN_CONTENT => 'Article',
            Constant::PERMISSION_MAIN_ITEM => 'Elément',
            Constant::PERMISSION_MAIN_TAG => 'Tag (étiquette)',
            Constant::PERMISSION_MAIN_MENU => 'Menu',
            Constant::PERMISSION_MAIN_CONFIG_TYPE => 'Configuration article',
            Constant::PERMISSION_MAIN_CONFIG_ITEM => 'Configuration élément',
        ];
    }

    public function getMenu() : array
    {
        try {
            Yii::debug(Constant::TRACE_DEBUG, __METHOD__, __METHOD__);
            $configuration = [
                'title' => 'Configuration',
                'url' => null,
                'optionsClass' => [],
                'children' => []
            ];
            $contents = [
                'title' => 'Contenus',
                'url' => null,
                'optionsClass' => [],
                'children' => []
            ];
            if (Yii::$app->user->can(Constant::PERMISSION_MAIN_CONFIG_TYPE.CoreConstant::PERMISSION_ACTION_LIST) === true) {
                $optionsClass = [];
                if (Yii::$app->controller->id == 'config-type') {
                    $optionsClass[] = 'text-primary fw-bold';
                }
                if(empty($configuration['optionsClass']) === true) {
                    $configuration['optionsClass'] = $optionsClass;
                }
                $configuration['children'][] = [
                    'title' => 'Configuration article',
                    'url' => Url::to(['/'.$this->contextId.'/config-type/index']),
                    'optionsClass' => $optionsClass,
                    'children' => [],
                ];
            }
            if (Yii::$app->user->can(Constant::PERMISSION_MAIN_CONFIG_ITEM.CoreConstant::PERMISSION_ACTION_LIST) === true) {
                $optionsClass = [];
                if (Yii::$app->controller->id == 'config-item') {
                    $optionsClass[] = 'text-primary fw-bold';
                }
                if(empty($configuration['optionsClass']) === true) {
                    $configuration['optionsClass'] = $optionsClass;
                }
                $configuration['children'][] = [
                    'title' => 'Configuration élément',
                    'url' => Url::to(['/'.$this->contextId.'/config-item/index']),
                    'optionsClass' => $optionsClass,
                    'children' => [],
                ];
            }

            if (Yii::$app->user->can(Constant::PERMISSION_MAIN_CONTENT.CoreConstant::PERMISSION_ACTION_LIST) === true) {
                $optionsClass = [];
                if (Yii::$app->controller->id == 'content') {
                    $optionsClass[] = 'text-primary fw-bold';
                }
                if(empty($contents['optionsClass']) === true) {
                    $contents['optionsClass'] = $optionsClass;
                }

                $contents['children'][] = [
                    'title' => 'Articles',
                    'url' => Url::to(['/'.$this->contextId.'/content/index']),
                    'optionsClass' => $optionsClass,
                    'children' => [],
                ];
            }
            if (Yii::$app->user->can(Constant::PERMISSION_MAIN_MENU.CoreConstant::PERMISSION_ACTION_LIST) === true) {
                $optionsClass = [];
                if (Yii::$app->controller->id == 'menu') {
                    $optionsClass[] = 'text-primary fw-bold';
                }
                if(empty($contents['optionsClass']) === true) {
                    $contents['optionsClass'] = $optionsClass;
                }
                $contents['children'][] = [
                    'title' => 'Menu',
                    'url' => Url::to(['/'.$this->contextId.'/menu/index']),
                    'optionsClass' => $optionsClass,
                    'children' => [],
                ];
            }

            if (Yii::$app->user->can(Constant::PERMISSION_MAIN_TAG.CoreConstant::PERMISSION_ACTION_LIST) === true) {
                $optionsClass = [];
                if (Yii::$app->controller->id == 'tag') {
                    $optionsClass[] = 'text-primary fw-bold';
                }
                if(empty($contents['optionsClass']) === true) {
                    $contents['optionsClass'] = $optionsClass;
                }
                $contents['children'][] = [
                    'title' => 'Etiquettes (Tags)',
                    'url' => Url::to(['/'.$this->contextId.'/tag/index']),
                    'optionsClass' => $optionsClass,
                    'children' => [],
                ];
            }
            $data = [];
            if (empty($configuration['children']) === false) {
                $data[] = $configuration;
            }
            if (empty($contents['children']) === false) {
                $data[] = $contents;
            }
            return $data;
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * Get context routes
     *
     * @return array[]
     */
    public function getRoutes(): array
    {
        $coreId = CoreModule::getInstance()->id;
        $contextId = $this->contextId;
        return [
            $coreId.'/configuration-des-items/liste' => $contextId.'/config-item/index',
            $coreId.'/configuration-des-items/creer' => $contextId.'/config-item/create',
            $coreId.'/configuration-des-items/<id:([^/]+)>/editer' => $contextId.'/config-item/update',
            $coreId.'/configuration-des-items/<id:([^/]+)>/supprimer' => $contextId.'/api/config-item/delete',
            $coreId.'/configuration-type-article/liste'=> $contextId.'/config-type/index',
            $coreId.'/configuration-type-article/creer' => $contextId.'/config-type/create',
            $coreId.'/configuration-type-article/<id:([^/]+)>/editer'=> $contextId.'/config-type/update',
            $coreId.'/configuration-type-article/<id:([^/]+)>/supprimer' => $contextId.'/api/config-type/delete',
            $coreId.'/articles/liste' => $contextId.'/content/index',
            $coreId.'/articles/creer'=> $contextId.'/content/create',
            $coreId.'/articles/<id:([^/]+)>/editer'=> $contextId.'/content/update',
            $coreId.'/articles/<id:([^/]+)>/supprimer'=> $contextId.'/api/content/delete',
            $coreId.'/tags/liste' => $contextId.'/tag/index',
            $coreId.'/tags/creer'=> $contextId.'/tag/create',
            $coreId.'/tags/<id:([^/]+)>/editer'=> $contextId.'/tag/update',
            $coreId.'/tags/<id:([^/]+)>/supprimer'=> $contextId.'/api/tag/delete',
            $coreId.'/menus/liste'=> $contextId.'/menu/index',
            $coreId.'/menu/creer'=> $contextId.'/menu/create',
            $coreId.'/menu/<id:([^/]+)>/editer' => $contextId.'/menu/update',
            $coreId.'/menu/<id:([^/]+)>/supprimer'=> $contextId.'/api/menu/delete',
            $coreId.'/menu/<id:([^/]+)>/manage-menu-items'=> $contextId.'/api/menu/manage-menu-items',
            $coreId.'/contents/<targetId:([^/]+)>/manage-items'=> $contextId.'/api/content/manage-items',
            $coreId.'/tags/<targetId:([^/]+)>/manage-items'=> $contextId.'/api/tag/manage-items',
            $coreId.'/api/file/upload'=> $contextId.'/api/file/upload',
            $coreId.'/api/file/preview'=> $contextId.'/api/file/preview',
            $coreId.'/api/file/delete'=> $contextId.'/api/file/delete',
        ];
    }

    /**
     * Get context id
     *
     * @return string
     * @throws Exception
     */
    public function getContextId() : string
    {
        try {
            return $this->contextId;
        }catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }

    /**
     * Set context id
     *
     * @param $id
     * @return void
     * @throws Exception
     */
    public function setContextId($id) : void
    {
        try {
            $this->contextId = $id;
        }catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw  $e;
        }
    }
}
