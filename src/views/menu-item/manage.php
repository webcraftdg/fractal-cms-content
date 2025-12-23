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
 * @var array $routes
 */

use fractalCms\content\models\MenuItem;
?>

<div class="mt-3 flex  justify-center">
    <div class="w-full sm:w-1/2">
        <h2>Création d'un élément du menu</h2>
    </div>
</div>
<div class="mt-4 flex justify-center">
    <div class="w-full sm:w-1/2">
        <?php
        echo $this->render('_form', [
            'model' => $model,
            'menusItems' => $menusItems,
            'contents' => $contents,
            'routes' => $routes,
        ]);
        ?>
    </div>
</div>

