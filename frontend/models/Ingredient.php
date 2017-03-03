<?php

namespace app\models;

use Yii;
use app\models\Measure;

/**
 * This is the model class for table "ingredient".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_measure
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_measure'], 'required','message'=>'Поле необходимо заполнить'],
            [['id_measure'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }
    public function save($runValidation = false, $attributeNames = NULL)
    {
        if ((int)$this->id_measure == 0) {
            $this->addError("id_measure", "Поле 'Единица измерения по умолчанию' обязательно для заполнения!");
            return false;
        }
        return parent::save($runValidation);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'id_measure' => 'Единица измерения по умолчанию',
        ];
    }
    
    public function getMeasure() {
        return $this->hasOne(Measure::className(), ['id' => 'id_measure']);
    }
}
