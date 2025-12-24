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
 * @var ConfigType $model
 * @var array $routes
 */
use fractalCms\content\models\ConfigType;
?>
<div class="mt-3 flex items-center justify-center">
    <div class="sm:w-3/5">
        <h2>Mettre à jour d'une type d'article</h2>

    </div>
</div>
<div class="mt-4 flex justify-center">
    <div class="sm:w-3/5">
        <?php
        echo $this->render('_form', [
            'model' => $model,
            'routes' => $routes]);
        ?>
    </div>
</div>
