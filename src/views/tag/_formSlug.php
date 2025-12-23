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
 * @var Slug $slug;
 */

use fractalCms\content\helpers\Html;
use fractalCms\content\models\Slug;
?>
<div class="border rounded-md">
    <div class="px-3 py-2 border-b">
        <h3>Url</h3>
    </div>
    <div class="p-3 space-y-2">
        <div class="flex items-center justify-between">
            <div class="fc-row">
                <div class="fc-form-group">
                    <?php
                    echo Html::activeLabel($slug, 'path', ['label' => 'Url de cet article', 'class' => 'fc-form-label']);
                    echo Html::activeTextInput($slug, 'path', ['placeholder' => 'Path', 'class' => 'fc-form-input']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
