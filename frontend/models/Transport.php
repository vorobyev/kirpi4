<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $name
 * @property integer $id
 */
class Transport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required','message'=>'Поле необходимо заполнить'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Наименование и гос. номер',
            'id' => 'ID',
        ];
    }
}
