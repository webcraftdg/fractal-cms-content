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
 * @var array $routes
 * @var ConfigType[] $configTypes
 * @var array $configItems
 * @var \yii\redis\ActiveQuery $itemsQuery
 * @var Slug $slug;
 * @var Seo $seo;
 */

use fractalCms\content\helpers\Html;
use fractalCms\content\models\Tag;
use fractalCms\content\models\ConfigType;
use fractalCms\content\models\Slug;
use fractalCms\content\models\Seo;
use yii\helpers\ArrayHelper;
?>
<?php echo Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']); ?>
<div class="fc-row">
    <div class="flex mb-4">
        <div class="flex items-center gap-2">
            <?php
            echo Html::activeCheckbox($model, 'active', ['label' =>  null, 'class' => 'form-check-input']);
            echo Html::activeLabel($model, 'active', ['label' => 'Actif', 'class' => 'form-check-label']);
            ?>
        </div>
    </div>
</div>
<div class="fc-row">
    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'name', ['label' => 'Nom', 'class' => 'fc-form-label']);
        echo Html::activeTextInput($model, 'name', ['placeholder' => 'Nom', 'class' => 'fc-form-input']);
        ?>
    </div>
    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'configTypeId', ['label' => 'Configuration de l\'étiquette', 'class' => 'fc-form-label']);
        echo Html::activeDropDownList($model, 'configTypeId', ArrayHelper::map($configTypes, 'id', 'name'), [
            'prompt' => 'Sélectionner un type', 'class' => 'fc-form-input',
        ]);
        ?>
    </div>
</div>

<?php if ($model->isNewRecord === false):?>
    <div class="fc-row">
        <?php
            echo $this->render('_formSlug', ['slug' => $slug]);
        ?>
    </div>
    <div class="fc-row">
        <?php
        echo $this->render('_formSeo', ['seo' => $seo]);
        ?>
    </div>
<div class="fc-row mt-3">
    <div class="border rounded-md">
        <div class="px-3 py-2 border-b">
            <h2>Gestion des éléments</h2>
        </div>
        <?php
            echo Html::beginTag(
                    'div',
                [
                    'class' => 'p-3 space-y-2',
                ]);
            echo Html::tag('fractal-cms-content-manage-items', '',
                [
                    'id.bind' => $model->id,
                    'item-api-url' => '/tags/{targetId}/manage-items',
                    'view' => $this->render('_items', [
                        'itemsQuery' => $itemsQuery,
                        'configItems' => $configItems,
                        'target' => $model
                    ])
                ]
            );
        ?>
        <?php
            echo Html::endTag('div');
        ?>
    </div>
</div>
<?php endif;?>
<div class="fc-form-button-container">
    <button type="submit" class="fc-form-button">Valider</button>
</div>
<?php  echo Html::endForm(); ?>
