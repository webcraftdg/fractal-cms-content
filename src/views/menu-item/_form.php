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
 * @var MenuItem $model
 * @var MenuItem[] $menusItems
 * @var array $contents
 * @var  array $routes
 */

use fractalCms\content\helpers\Html;
use fractalCms\content\models\MenuItem;
use yii\helpers\ArrayHelper;
?>
<?php echo Html::beginForm('', 'post'); ?>
<div class="fc-row">
    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'name', ['label' => 'Nom', 'class' => 'fc-form-label']);
        echo Html::activeTextInput($model, 'name', ['placeholder' => 'Nom', 'class' => 'fc-form-input']);
        ?>
    </div>
    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'contentId', ['label' => 'Route CMS', 'class' => 'fc-form-label']);
        echo Html::activeDropDownList($model, 'contentId', ArrayHelper::map($contents, 'id', 'name'), [
            'prompt' => 'Sélectionner une route interne au CMS', 'class' => 'fc-form-input',
        ]);
        ?>
    </div>
    <?php if (empty($routes) === false):?>
    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'route', ['label' => 'Route Locale', 'class' => 'fc-form-label']);
        echo Html::activeDropDownList($model, 'route', ArrayHelper::map($routes, 'id', 'name'), [
            'prompt' => 'Sélectionner une route interne à l\'application', 'class' => 'fc-form-input',
        ]);
        ?>
    </div>
    <?php endif;?>
    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'menuItemId', ['label' => 'Parent', 'class' => 'fc-form-label']);
        echo Html::activeDropDownList($model, 'menuItemId', ArrayHelper::map($menusItems, 'id', 'name'), [
            'prompt' => 'Sélectionner un Parent', 'class' => 'fc-form-input',
        ]);
        ?>
    </div>
    <div class="fc-row mt-3">
        <div class="fc-form-button-container">
            <button type="submit" class="fc-form-button">Valider</button>
        </div>
    </div>
</div>
<?php  echo Html::endForm(); ?>
