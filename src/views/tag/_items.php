<?php
/**
 * _items.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package views
 *
 * @var \yii\web\View $this
 * @var \yii\db\ActiveQuery $itemsQuery
 * @var Tag $target
 * @var array $configItems
 */

use fractalCms\content\models\Tag;
use fractalCms\content\helpers\Html;
use fractalCms\content\models\Item;
use yii\helpers\ArrayHelper;

$model = Yii::createObject(Item::class);
?>

<?php if ($itemsQuery !== null):?>
    <?php
        foreach ($itemsQuery->each() as $index => $item) {
            echo $this->render('@fractalCms/content/views/templates/template-item',
            [
                'model' => $item,
                'index' => $index,
                'target' => $target,
                'total' => $itemsQuery->count()
            ]);
        }
    ?>
<?php endif;?>
<div class="fc-row mt-1">
    <div class="w-48">
        <div class="fc-input-group">
            <?php
            echo Html::activeDropDownList($model,
                'configItemId',
                ArrayHelper::map($configItems, 'id' , 'name'),
            [
                'class' => 'fc-form-input',
            ]);
            ?>
            <button type="button" class="fc-btn fc-btn-primary" name="addItem">
                <svg width="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12H15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 9L12 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#fff" stroke-width="2"/>
                </svg>
            </button>
        </div>
    </div>
</div>
