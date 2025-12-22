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
 * @var ConfigType $model
 * @var array $routes
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use fractalCms\content\models\ConfigType;
?>
<div class="fc-row">
        <?php if (empty($model->errors) === false): ?>
                <?php foreach ($model->errors as $error):?>
                <div class="fc-row">
                        <?php echo Html::tag('p', $error['0'], ['class' => 'fc-error']);?>
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
                <?php
                echo Html::activeLabel($model, 'config', ['label' => 'Route', 'class' => 'fc-form-label']);
                echo Html::activeDropDownList($model, 'config', ArrayHelper::map($routes, 'id', 'name', 'group'), [
                        'prompt' => 'Sélectionner un route', 'class' => 'fc-form-input'
                ]);
                ?>
        </div>
        <div class="fc-form-button-container">
            <button type="submit" class="fc-form-button">Valider</button>
        </div>
        <?php  echo Html::endForm(); ?>
</div>
