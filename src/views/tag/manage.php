<?php
/**
 * index.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package views
 *
 * @var \yii\web\View $this
 * @var Tag $model
 * @var ConfigType $configTypes
 * @var array $configItems
 * @var \yii\redis\ActiveQuery $itemsQuery
 * @var Slug $slug
 * @var Seo $seo
 */
use fractalCms\content\helpers\Html;
use fractalCms\content\models\Tag;
use fractalCms\content\models\ConfigType;
use fractalCms\content\models\Slug;
use fractalCms\content\models\Seo;
use yii\helpers\Url;

$configItems = ($configItems) ?? [];
?>
<div class="row mt-3 align-items-center">
    <div class="col-sm-8">
        <h2>Création d'une étiquette (Tag)</h2>
    </div>
    <div class="col-sm-4">
        <div class="row align-items-center">
            <div class="col-sm-4">
                <div class="col form-group p-0">
                    <?php
                    echo Html::a('Prévisualisation', Url::toRoute([$model->getRoute()]), [
                           'class' => 'btn btn-primary',
                        'target' => '_blank'
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row m-3">
    <?php
        echo $this->render('_form', [
            'model' => $model,
            'slug' => $slug,
            'seo' => $seo,
            'configTypes' => $configTypes,
            'configItems' => $configItems,
            'itemsQuery' => $itemsQuery
        ]);
    ?>
</div>
