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
 * @var Seo $seo;
 */

use fractalCms\content\helpers\Html;
use fractalCms\content\models\Seo;
?>
<div class="border rounded-md mt-3">
    <?php
    $class = [];
    $class[] = 'px-3 py-2 border-b';
     echo Html::beginTag('div', ['class' => implode(' ', $class)]);
    ?>
        <div class="flex items-center justify-between">
            <div>
                SEO
            </div>
            <div class="flex items-center gap-2">
                <?php
                echo Html::activeCheckbox($seo, 'active', ['label' =>  null, 'class' => 'fc-form-check']);
                echo Html::activeLabel($seo, 'active', ['label' => 'Actif', 'class' => 'fc-form-label']);
                ?>
            </div>
        </div>
    <?php
        echo Html::endTag('div');
    ?>
    <div class="p-3 space-y-2">
        <div class="fc-row">
            <div class="fc-form-group">
                <?php
                echo Html::activeLabel($seo, 'title', ['label' => 'Titre', 'class' => 'fc-form-label']);
                echo Html::activeTextInput($seo, 'title', ['placeholder' => 'Titre Seo', 'class' => 'fc-form-input']);
                ?>
            </div>
            <div class="fc-form-group">
                <?php
                echo Html::activeLabel($seo, 'description', ['label' => 'Description', 'class' => 'fc-form-label']);
                echo Html::activeTextarea($seo, 'description', [
                    'placeholder' => 'Description Seo',
                    'rows' => 6,
                    'cols' => 12,
                    'class' => 'fc-form-input form-textarea']);
                ?>
            </div>
        </div>
        <div class="fc-row">
            <div class="fc-form-group">
                <?php
                echo Html::tag('fractal-cms-content-file-upload', '', [
                    'title' => 'Image dimensions idéale 1200×630px',
                    'name' => Html::getInputName($seo, 'imgPath'),
                    'value' => $seo->imgPath,
                    'upload-file-text' => 'Ajouter une fichier',
                    'file-type' => Seo::$accept
                ]);
                ?>
            </div>
        </div>

        <div class="fc-row">
            <div class="border rounded-md">
                <div class="px-3 py-2 border-b">
                    <h3>Sitemap</h3>
                </div>
                <div class="p-3 space-y-2 mt-3">
                    <div class="fc-row">
                        <div>
                            <?php
                            echo 'Fréquence de modification';
                            ?>
                        </div>
                        <div class="">
                            <?php
                            $index = 0;
                            foreach (Seo::optsFrequence() as $label => $value) {
                                $inputRadioId = Html::getInputId($seo, 'changefreq').'_'.($index + 1);
                                $suffixFreq = Seo::frequenceSuffix();
                                $suffix = ($suffixFreq[$value]) ?? '';
                                echo Html::beginTag('div', ['class' => 'flex items-center gap-2']);
                                echo Html::input('radio', Html::getInputName($seo, 'changefreq'), $value, [
                                    'id' => $inputRadioId,
                                    'class' => 'fc-form-check',
                                    'value' => $value,
                                    'checked' => $seo->changefreq == $value,
                                    'label' => null
                                ]);
                                echo Html::label($value.' ('.$suffix.')', $inputRadioId, ['class' => 'fc-form-label']);
                                echo Html::endTag('div');
                                $index +=1;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="fc-row">
                        <div class="fc-form-group">
                            <?php
                            echo Html::activeLabel($seo, 'priority', ['label' => 'Priorité (valeurs valides : 0 à 1)', 'class' => 'fc-form-label']);
                            echo Html::activeInput('number', $seo, 'priority', ['class' => 'fc-form-input', 'step' => '0.1', 'min' => '0.0', 'max' => '1.0']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fc-row">
            <div class="border rounded-md">
                <div class="px-3 py-2 border-b">
                    <h3>Meta données</h3>
                </div>
                <div class="p-3 space-y-2">
                    <div class="fc-row">
                        <div class="fc-input-group">
                            <?php
                            echo Html::activeCheckbox($seo, 'noFollow', ['label' =>  null, 'class' => 'fc-form-check']);
                            echo Html::activeLabel($seo, 'noFollow', ['label' => 'Ajoute la meta "no-follow no-index"', 'class' => 'fc-form-label']);
                            ?>
                        </div>
                        <div class="fc-input-group">
                            <?php
                            echo Html::activeCheckbox($seo, 'ogMeta', ['label' =>  null, 'class' => 'fc-form-check']);
                            echo Html::activeLabel($seo, 'ogMeta', ['label' => 'Générer les Metas OG:*', 'class' => 'fc-form-label']);
                            ?>
                        </div>
                    </div>
                    <div class="fc-row">
                        <div class="fc-input-group">
                            <?php
                            echo Html::activeCheckbox($seo, 'twitterMeta', ['label' =>  null, 'class' => 'fc-form-check']);
                            echo Html::activeLabel($seo, 'twitterMeta', ['label' => 'Générer les Metas Twitter:*', 'class' => 'fc-form-label']);
                            ?>
                        </div>
                        <div class="fc-input-group">
                            <?php
                            echo Html::activeCheckbox($seo, 'addJsonLd', ['label' =>  null, 'class' => 'fc-form-check']);
                            echo Html::activeLabel($seo, 'addJsonLd', ['label' => 'Générer le Meta JSONLD', 'class' => 'fc-form-label']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
