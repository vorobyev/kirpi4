<?php

namespace app\models;

use Yii;
use app\models\RecipeCompose;
use app\models\Product;
use app\models\Measure;

/**
 * This is the model class for table "recipe".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_product
 * @property integer $id_measure
 * @property integer $count
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_product', 'id_measure', 'count'], 'required','message'=>'Поле необходимо заполнить'],
            [['id_product', 'id_measure'], 'integer'],
            [['name'], 'string', 'max' => 200],
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
            'name' => 'Наименование',
            'id_product' => 'Конечный продукт',
            'id_measure' => 'Единица измерения',
            'count' => 'Количество выходного продукта'
        ];
    }
    
    public function save($runValidation = false, $attributeNames = NULL)
    {
        if ((int)$this->id_product == 0) {
            $this->addError("id_product", "Поле 'Конечный продукт' обязательно для заполнения!");
            return false;
        }
        if ((int)$this->id_measure == 0) {
            $this->addError("id_measure", "Поле 'Единица измерения' обязательно для заполнения!");
            return false;
        }
        return parent::save($runValidation);
    }  
 
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            RecipeCompose::deleteAll(['id_recipe'=>$this->id]);
            return true;
        } else {
            return false;
        }
    }
    
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }
    
    public function getMeasure() {
        return $this->hasOne(Measure::className(), ['id' => 'id_measure']);
    }
}
