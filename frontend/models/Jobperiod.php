<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $name
 * @property integer $id
 */
class Jobperiod extends \yii\db\ActiveRecord
{
    public $datebegin;
    public $dateend;
    public $operator;
    public $withTransport = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datebegin', 'dateend', 'operator'], 'required','message'=>'Поле необходимо заполнить'],
            [['datebegin', 'dateend','withTransport'], 'safe'],
        ];
    }

}
