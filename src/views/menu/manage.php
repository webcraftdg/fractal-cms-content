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
use fractalCms\content\models\Menu;
?>

<div class="mt-3 flex  justify-center">
    <div class="w-3/5">
        <h2>Création d'un menu</h2>
    </div>
</div>
<div class="mt-4 flex justify-center">
    <div class="w-3/5">
        <?php
        echo $this->render('_form', [
            'model' => $model,
            'menuItemHtml' => $menuItemHtml
        ]);
        ?>
    </div>
</div>
