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
echo Html::tag('fractal-cms-content-manage-alerts', '');
?>
<div class="mt-3 flex  justify-center">
    <div class="w-full sm:w-1/2">
        <h2>Création d'une étiquette (Tag)</h2>
        <?php
        echo Html::a('Prévisualisation', Url::toRoute([$model->getRoute()]), [
            'class' => 'fc-btn fc-btn-primary',
            'target' => '_blank'
        ]);
        ?>
    </div>
</div>
<div class="mt-4 flex justify-center">
    <div class="w-full sm:w-1/2">
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
</div>
