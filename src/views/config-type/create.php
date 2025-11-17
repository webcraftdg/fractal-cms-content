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
 * @var $routes
 */
use fractalCms\content\models\ConfigType;
?>

<div class="row mt-3 align-items-center">
    <div class="col-sm-6">
        <h2>Création d'une config</h2>
    </div>
</div>
<div class="row m-3">
    <?php
        echo $this->render('_form', [
                'model' => $model,
            'routes' => $routes]);
    ?>
</div>
