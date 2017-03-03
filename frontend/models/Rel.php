<?php

namespace app\models;

use Yii;
use app\models\Ingredient;

/**
 * This is the model class for table "recipe_compose".
 *
 * @property integer $id
 * @property integer $id_recipe
 * @property integer $id_ingredient
 * @property integer $order_pos
 * @property double $count
 * @property integer $id_measure
 */
class Rel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel';
    }


    
//    public function getRecipe() {
//        return $this->hasOne(Recipe::className(), ['id' => 'id_recipe']);
//    }
    
}
