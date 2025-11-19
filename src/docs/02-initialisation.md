# Initialisation

## Init FractalCMS

### Create Rbac (create role and permission)

``
php yii.php fractalCms:rbac/index
``

### Create Admin (create first admin)
``
php yii.php fractalCms:admin/create
``
### INIT content (create initial content)

``
php yii.php fractalCmsContent:init/index
``

## Config application

### Add module fractal-cms in config file

````php 
    'bootstrap' => [
        'fractal-cms',
        'fractal-cms-content',
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