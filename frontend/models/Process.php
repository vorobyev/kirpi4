<?php

namespace app\models;

use Yii;
use app\models\Ingredient;
use app\models\Measure;
use app\models\Task;
/**
 * This is the model class for table "process".
 *
 * @property integer $id
 * @property integer $id_task
 * @property integer $id_ingredient
 * @property integer $id_measure
 * @property double $count
 * @property double $count_fact
 */
class Process extends \yii\db\ActiveRecord
{
    public $count_add;
    public $all;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_task', 'id_ingredient', 'id_measure', 'count'], 'required'],
            [['id_task', 'id_ingredient', 'id_measure'], 'integer'],
            [['count', 'count_fact','count_add'], 'number','message'=>'Введите корректное число'],
            [['order','all'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_task' => 'Задача',
            'id_ingredient' => 'Ингредиент',
            'id_measure' => 'Единица измерения',
            'count' => 'Количество',
            'count_fact' => 'Количество факт.',
        ];
    }
    
    public function getIngredient() {
        return $this->hasOne(Ingredient::className(), ['id' => 'id_ingredient']);
    }
    
    public function getMeasure() {
        return $this->hasOne(Measure::className(), ['id' => 'id_measure']);
    }
    
    public function getTask() {
        return $this->hasOne(Task::className(), ['id' => 'id_task']);
    }
}
