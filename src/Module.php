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
use fractalCms\content\assets\WebpackAsset;
use fractalCms\content\components\UrlRule;
use fractalCms\content\helpers\ConfigType;
use fractalCms\content\helpers\MenuItemBuilder;
use fractalCms\content\helpers\SitemapBuilder;
use fractalCms\content\console\InitController;
use fractalCms\content\components\Constant;
use fractalCms\core\components\Constant as CoreConstant;
use Yii;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\helpers\Url;
use yii\web\Application as WebApplication;
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
    public string $commandNameSpace = 'fractalCms\content:';

    private string $contextId = 'cms';
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

    /**
     * Return context Permission
     * @return array
     */
    public function getPermissions(): array
    {
        return [
            Constant::PERMISSION_MAIN_CONTENT,
            Constant::PERMISSION_MAIN_ITEM,
            Constant::PERMISSION_MAIN_TAG,
            Constant::PERMISSION_MAIN_MENU,
            Constant::PERMISSION_MAIN_CONTENT_ITEM,
            Constant::PERMISSION_MAIN_TAG_ITEM,
            Constant::PERMISSION_MAIN_CONTENT_TAG,
            Constant::PERMISSION_MAIN_CONFIG_TYPE,
            Constant::PERMISSION_MAIN_CONFIG_ITEM,
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
            $admins = [
                'title' => 'Administration',
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
                    'url' => Url::to(['config-type/index']),
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
                    'url' => Url::to(['config-item/index']),
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
                    'url' => Url::to(['content/index']),
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
                    'url' => Url::to(['menu/index']),
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
                    'url' => Url::to(['tag/index']),
                    'optionsClass' => $optionsClass,
                    'children' => [],
                ];
            }
            $data = [];
            if (empty($admins['children']) === false) {
                $data[] = $admins;
            }
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
        return [
            [
                'pattern' => 'configuration-des-items/liste',
                'route' => 'config-item/index',
            ],
            [
                'pattern' => 'configuration-des-items/creer',
                'route' => 'config-item/create',
            ],
            [
                'pattern' => 'configuration-des-items/<id:([^/]+)>/editer',
                'route' => 'config-item/update',
            ],
            [
                'pattern' => 'configuration-des-items/<id:([^/]+)>/supprimer',
                'route' => 'api/config-item/delete',
            ],

            [
                'pattern' => 'configuration-type-article/liste',
                'route' => 'config-type/index',
            ],
            [
                'pattern' => 'configuration-type-article/creer',
                'route' => 'config-type/create',
            ],
            [
                'pattern' => 'configuration-type-article/<id:([^/]+)>/editer',
                'route' => 'config-type/update',
            ],
            [
                'pattern' => 'configuration-type-article/<id:([^/]+)>/supprimer',
                'route' => 'api/config-type/delete',
            ],
            [
                'pattern' => 'articles/liste',
                'route' => 'content/index',
            ],
            [
                'pattern' => 'articles/creer',
                'route' => 'content/create',
            ],
            [
                'pattern' => 'articles/<id:([^/]+)>/editer',
                'route' => 'content/update',
            ],
            [
                'pattern' => 'articles/<id:([^/]+)>/supprimer',
                'route' => 'api/content/delete',
            ],

            [
                'pattern' => 'menus/liste',
                'route' => 'menu/index',
            ],
            [
                'pattern' => 'menu/creer',
                'route' => 'menu/create',
            ],
            [
                'pattern' => 'menu/<id:([^/]+)>/editer',
                'route' => 'menu/update',
            ],
            [
                'pattern' => 'menu/<id:([^/]+)>/supprimer',
                'route' => 'api/menu/delete',
            ],
            [
                'pattern' => 'menu/<id:([^/]+)>/manage-menu-items',
                'route' => 'api/menu/manage-menu-items',
            ],
            [
                'pattern' => 'contents/<targetId:([^/]+)>/manage-items',
                'route' => 'api/content/manage-items',
            ],

            [
                'pattern' => 'tags/<targetId:([^/]+)>/manage-items',
                'route' => 'api/tag/manage-items',
            ],
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
}
