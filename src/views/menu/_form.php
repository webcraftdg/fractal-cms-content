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
 * @var Menu $model
 * @var string $menuItemHtml
 */

use fractalCms\content\helpers\Html;
use fractalCms\content\models\Menu;
?>
<?php echo Html::beginForm('', 'post', []); ?>
<div class="fc-row">
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
    <div class="fc-row">
        <div class="fc-form-group">
                <?php
                echo Html::activeLabel($model, 'name', ['label' => 'Nom', 'class' => 'fc-form-label']);
                echo Html::activeTextInput($model, 'name', ['placeholder' => 'Nom', 'class' => 'fc-form-input']);
                ?>
        </div>
    </div>
    <?php if ($model->isNewRecord === false):?>
    <div class="fc-row mt-3">
        <div class="border rounded-md">
            <div class="px-3 py-2 border-b">
                <h3>Gestion des éléments du menu</h3>
            </div>
            <?php
                echo Html::beginTag(
                        'div',
                    [
                        'class' => 'p-3 space-y-2',
                    ]);
                echo $this->render('_items',
                    [
                        'menuItemHtml' => $menuItemHtml,
                        'menu' => $model
                    ]);
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
</div>
<?php  echo Html::endForm(); ?>
