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
 * @var \fractalCms\content\components\Constant $model
 * @var array $routes
 * @var \fractalCms\content\models\ConfigType[] $configTypes
 * @var array $sections
 * @var array $configItems
 * @var \yii\redis\ActiveQuery $itemsQuery
 * @var \yii\redis\ActiveQuery $tagsQuery
 * @var \fractalCms\content\models\Slug $slug;
 * @var \fractalCms\content\models\Seo $seo;
 */

use fractalCms\content\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="fc-row">
        <?php echo Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']); ?>
    <div class="flex mb-4">
        <div class="flex items-center gap-2">
            <?php
            echo Html::activeCheckbox($model, 'active', ['label' =>  null, 'class' => 'fc-form-check']);
            echo Html::activeLabel($model, 'active', ['label' => 'Actif', 'class' => 'fc-form-label']);
            ?>
        </div>
    </div>
</div>
<div class="fc-row">
    <div>
        <div class="fc-form-group">
            <?php
            echo Html::activeLabel($model, 'name', ['label' => 'Nom', 'class' => 'fc-form-label']);
            echo Html::activeTextInput($model, 'name', ['placeholder' => 'Nom', 'class' => 'fc-form-input']);
            ?>
        </div>
        <div class="fc-form-group">
            <?php
            echo Html::activeLabel($model, 'type', ['label' => 'Model', 'class' => 'fc-form-label']);
            echo Html::activeDropDownList($model, 'type', ['article' => 'Article', 'section' => 'Section'], [
                'prompt' => 'Sélectionner un model', 'class' => 'fc-form-input',
                'disabled' => ($model->isNewRecord === false),
            ]);
            ?>
        </div>
    </div>
    <div>
        <div class="fc-form-group">
            <?php
            echo Html::activeLabel($model, 'configTypeId', ['label' => 'Configuration de l\'article', 'class' => 'fc-form-label']);
            echo Html::activeDropDownList($model, 'configTypeId', ArrayHelper::map($configTypes, 'id', 'name'), [
                'prompt' => 'Sélectionner un type', 'class' => 'fc-form-input',
            ]);
            ?>
        </div>
        <div class="fc-form-group">
            <?php
            echo Html::activeLabel($model, 'parentPathKey', ['label' => 'Parent', 'class' => 'fc-form-label']);
            echo Html::activeDropDownList($model, 'parentPathKey', ArrayHelper::map($sections, 'pathKey', 'name'), [
                'prompt' => 'Sélectionner un Parent', 'class' => 'fc-form-input',
                'disabled' => ($model->pathKey === '1'),
            ]);
            ?>
        </div>
    </div>
</div>
<?php if ($tagsQuery->count() > 0):?>
<div class="fc-row">
    <div class="w-full sm:w-1/2">
        <?php
            echo Html::activeLabel($model, 'formTags', ['label' => 'Tag / étiquettes', 'class' => 'fc-form-label'])
        ?>
        <?php
           echo Html::activeDropDownList($model, 'formTags', ArrayHelper::map($tagsQuery->all(), 'id', 'name'), [
                'class' => 'fc-form-input',
               'multiple' => true,
               'prompt' => 'Sélectionner une ou plusieurs Tag / étiquettes',
                'fractalcms-select-beautiful' => '',
            ]);
        ?>
    </div>
</div>
<?php endif;?>
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
            <h2>
            Gestion des éléments
            </h2>
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
                'item-api-url' => '/contents/{targetId}/manage-items',
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
