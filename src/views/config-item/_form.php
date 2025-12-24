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
 * @var ConfigItem $model
 * @var array $routes
 */

use yii\helpers\Html;
use fractalCms\content\models\ConfigItem;
?>
<div class="fc-row">
    <?php if (empty($model->errors) === false): ?>
            <?php foreach ($model->errors as $error):?>
            <div class="fc-row">
                    <?php echo Html::tag('p', $error['0'], ['class' => ' fc-error']);?>
            </div>
            <?php endforeach;?>
    <?php endif; ?>


    <?php echo Html::beginForm(); ?>

    <div class="fc-form-group">
        <?php
        echo Html::activeLabel($model, 'name', ['label' => 'Nom', 'class' => 'fc-form-label']);
        echo Html::activeTextInput($model, 'name', ['placeholder' => 'Nom', 'class' => 'fc-form-input']);
        ?>
    </div>
    <div class="fc-form-group">
        <div fractal-cms-content-json-editor="" class="mt-3">
            <?php
            echo Html::activeHiddenInput($model, 'config', ['class' => 'jsonInput']);
            ?>
            <div class="jsonEditor"></div>
        </div>
    </div>
    <div class="fc-form-button-container">
        <button type="submit" class="fc-form-button">Valider</button>
    </div>
    <?php  echo Html::endForm(); ?>
</div>
