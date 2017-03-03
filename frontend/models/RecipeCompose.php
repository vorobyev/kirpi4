<?php

namespace app\models;

use Yii;
use app\models\Ingredient;
use app\models\Measure;
use app\models\Recipe;

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
class RecipeCompose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipe_compose';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_recipe', 'id_ingredient', 'order_pos', 'count', 'id_measure'], 'required','message'=>'Поле необходимо заполнить'],
            [['id_recipe', 'id_ingredient', 'order_pos', 'id_measure'], 'integer'],
            [['count'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_recipe' => 'Рецептура',
            'id_ingredient' => 'Ингредиент',
            'order_pos' => 'Порядок',
            'count' => 'Количество',
            'id_measure' => 'Единица измерения',
        ];
    }
    
    public function save($runValidation = false, $attributeNames = NULL, $id_recipe = 1)
    {
        $this->id_recipe = $id_recipe;
        return parent::save($runValidation);
    }  
    
    public function getRecipe() {
        return $this->hasOne(Recipe::className(), ['id' => 'id_recipe']);
    }
    
    public function getIngredient() {
        return $this->hasOne(Ingredient::className(), ['id' => 'id_ingredient']);
    }
    
    public function getMeasure() {
        return $this->hasOne(Measure::className(), ['id' => 'id_measure']);
    }
}
