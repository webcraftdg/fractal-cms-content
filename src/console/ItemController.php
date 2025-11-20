<?php
/**
 * ItemController.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\console
 */
namespace fractalCms\content\console;

use yii\base\Exception;
use fractalCms\content\models\Item;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;

class ItemController extends Controller
{
    public $itemId;
    public $findRegex;
    public $findStr;
    public $replace;
    public $configItemId;
    public $attribute;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ['itemId', 'findRegex', 'findStr', 'replace', 'configItemId', 'attribute'];
    }

    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return [
            'itemId' => 'itemId',
            'findRegex' => 'findRegex',
            'findStr' => 'findStr',
            'replace' => 'replace',
            'configItemId' => 'configItemId',
            'attribute' => 'attribute',
        ];
    }

    /**
     * Replace value in JSON Data
     *
     * php yii.php fractalCmsContent:item/replace-value -findREgex="/^\/cms\//" -replace='/fractal-cms-content/' -configItemId=3 -attribute=target
     * @return int
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function actionReplaceValue() : int
    {
        try {
            $this->stdout('Mise à jour donnees JSON'."\n");
            if (empty($this->attribute) === true) {
                throw new Exception('Un attribut à modifier est obligatoire');
            }
            $attribute = $this->attribute;
            $itemQuery = Item::find();
            if (empty($this->configItemId) === false) {
                $itemQuery->andWhere(['configItemId' => $this->configItemId]);
            }
            if (empty($this->itemId) === false) {
                $itemQuery->andWhere(['id' => $this->itemId]);
            }
            /** @var Item $item */
            foreach ($itemQuery->each() as $item) {
                $update = false;
                if($item->hasAttribute($attribute) === true) {
                    if (empty($this->findRegex) === false && preg_match($this->findRegex, $item->$attribute) == 1) {
                        $item->$attribute = preg_replace($this->findRegex, $this->replace, $item->$attribute);
                        $update = true;
                    } elseif (empty($this->findStr) === false) {
                        $item->$attribute = str_replace($this->findStr, $this->replace, $item->$attribute);
                        $update = true;
                    }
                }
                if ($update === true) {
                    $item->data = $item->elasticModel->toJson();
                    $success = $item->save(false, ['data']);
                    if ($success === true) {
                        $this->stdout('Save  ITem '.$item->configItem?->name."\n");
                    }  else {
                        $this->stdout('Home section is invalid : '.Json::encode($item->errors)."\n");
                    }
                } else {
                    $this->stdout('L\'attribute n\'est pas présent : '.$attribute.' Ou la donnee est invalide'."\n");
                }
            }
            return ExitCode::OK;
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
