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
        return [
                'configuration-des-items/liste' => $this->contextId.'/config-item/index',
                'configuration-des-items/creer' => $this->contextId.'/config-item/create',
                'configuration-des-items/<id:([^/]+)>/editer' => $this->contextId.'/config-item/update',
                'configuration-des-items/<id:([^/]+)>/supprimer' => $this->contextId.'/api/config-item/delete',
                'configuration-type-article/liste'=> $this->contextId.'/config-type/index',
                'configuration-type-article/creer' => $this->contextId.'/config-type/create',
                'configuration-type-article/<id:([^/]+)>/editer'=> $this->contextId.'/config-type/update',
                'configuration-type-article/<id:([^/]+)>/supprimer' => $this->contextId.'/api/config-type/delete',
                'articles/liste' => $this->contextId.'/content/index',
                'articles/creer'=> $this->contextId.'/content/create',
                'articles/<id:([^/]+)>/editer'=> $this->contextId.'/content/update',
                'articles/<id:([^/]+)>/supprimer'=> $this->contextId.'/api/content/delete',
                'menus/liste'=> $this->contextId.'/menu/index',
                'menu/creer'=> $this->contextId.'/menu/create',
                'menu/<id:([^/]+)>/editer' => $this->contextId.'/menu/update',
                'menu/<id:([^/]+)>/supprimer'=> $this->contextId.'/api/menu/delete',
                'menu/<id:([^/]+)>/manage-menu-items'=> $this->contextId.'/api/menu/manage-menu-items',
                'contents/<targetId:([^/]+)>/manage-items'=> $this->contextId.'/api/content/manage-items',
                'tags/<targetId:([^/]+)>/manage-items'=> $this->contextId.'/api/tag/manage-items',
        ];
/*
        return [
            [
                'pattern' => 'configuration-des-items/liste',
                'route' => $this->contextId.'/config-item/index',
            ],
            [
                'pattern' => 'configuration-des-items/creer',
                'route' => $this->contextId.'/config-item/create',
            ],
            [
                'pattern' => 'configuration-des-items/<id:([^/]+)>/editer',
                'route' => $this->contextId.'/config-item/update',
            ],
            [
                'pattern' => 'configuration-des-items/<id:([^/]+)>/supprimer',
                'route' => $this->contextId.'/api/config-item/delete',
            ],

            [
                'pattern' => 'configuration-type-article/liste',
                'route' => $this->contextId.'/config-type/index',
            ],
            [
                'pattern' => 'configuration-type-article/creer',
                'route' => $this->contextId.'/config-type/create',
            ],
            [
                'pattern' => 'configuration-type-article/<id:([^/]+)>/editer',
                'route' => $this->contextId.'/config-type/update',
            ],
            [
                'pattern' => 'configuration-type-article/<id:([^/]+)>/supprimer',
                'route' => $this->contextId.'/api/config-type/delete',
            ],
            [
                'pattern' => 'articles/liste',
                'route' => $this->contextId.'/content/index',
            ],
            [
                'pattern' => 'articles/creer',
                'route' => $this->contextId.'/content/create',
            ],
            [
                'pattern' => 'articles/<id:([^/]+)>/editer',
                'route' => $this->contextId.'/content/update',
            ],
            [
                'pattern' => 'articles/<id:([^/]+)>/supprimer',
                'route' => $this->contextId.'/api/content/delete',
            ],

            [
                'pattern' => 'menus/liste',
                'route' => $this->contextId.'/menu/index',
            ],
            [
                'pattern' => 'menu/creer',
                'route' => $this->contextId.'/menu/create',
            ],
            [
                'pattern' => 'menu/<id:([^/]+)>/editer',
                'route' => $this->contextId.'/menu/update',
            ],
            [
                'pattern' => 'menu/<id:([^/]+)>/supprimer',
                'route' => $this->contextId.'/api/menu/delete',
            ],
            [
                'pattern' => 'menu/<id:([^/]+)>/manage-menu-items',
                'route' => $this->contextId.'/api/menu/manage-menu-items',
            ],
            [
                'pattern' => 'contents/<targetId:([^/]+)>/manage-items',
                'route' => $this->contextId.'/api/content/manage-items',
            ],

            [
                'pattern' => 'tags/<targetId:([^/]+)>/manage-items',
                'route' => $this->contextId.'/api/tag/manage-items',
            ],
        ];*/
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
