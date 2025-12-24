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
 * @var \fractalCms\content\models\ConfigItem $model
 */

?>
<div class="mt-3 flex items-center justify-center">
    <div class="sm:w-3/5">
        <h2>Mettre à jour une configuration</h2>
    </div>
</div>
<div class="mt-4 flex justify-center">
    <div class="sm:w-3/5">
        <?php
        echo $this->render('_form', [
            'model' => $model,
        ]);
        ?>
    </div>
</div>
