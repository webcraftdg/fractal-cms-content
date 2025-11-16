# Initialisation

## Init FractalCMS

### Create Rbac (create role and permission)

``
php yii.php fractalCms\content:rbac/index
``

### Create Admin (create first admin)
``
php yii.php fractalCms\content:admin/create
``
### INIT content (create initial content)

``
php yii.php fractalCms\content:init/index
``

## Config application

### Add module fractal-cms in config file

````php 
    'bootstrap' => [
        'fractal-cms',
        //../..
    ],
    'modules' => [
        'fractal-cms' => [
            'class' => FractalCmsCoreModule::class
        ],
       'fractal-cms-content' => [
            'class' => FractalCmsContentModule::class
        ],
        //../..
    ],
````

[<- Précédent](01-installation.md) | [Suivant ->](03-configuration.md)