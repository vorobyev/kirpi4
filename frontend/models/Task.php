<?php

namespace app\models;

use Yii;
use app\models\Recipe;
use app\models\Process;
use app\models\RecipeCompose;
use common\models\User;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $datetask
 * @property string $dateredline
 * @property integer $id_recipe
 * @property integer $count
 * @property integer $status
 * @property integer $id_user
 * @property string $mail
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetask', 'dateredline', 'id_recipe', 'count', 'status', 'id_user'], 'required','message'=>'Поле необходимо заполнить'],
            [['datetask', 'dateredline'], 'safe'],
            [['id_recipe', 'status', 'id_user'], 'integer'],
            [['mail'], 'string'],
            [['count'], 'number','message'=>'Введите корректное число'],
        ];
    }

    public function save($runValidation = false, $attributeNames = NULL, $onlystatus = false, $update = false)
    {
        if (!$onlystatus) {
            date_default_timezone_set( 'Europe/Moscow' );//установка часового пояса для кооректности текущей даты
            $this->datetask=date("Y-m-d H:i:s");
            if ((int)$this->status > 1) {
                $this->addError('mail','Не удалось изменить эту задачу. Эта задача еще выполняется, либо уже выполнена.');
                return false;
            }
            if ((int)$this->id_recipe == 0) {
                $this->addError("id_recipe", "Поле 'Рецепт' обязательно для заполнения!");
                return false;
            }
            if ((int)$this->id_user == 0) {
                $this->addError("id_user", "Поле 'Для пользователя' обязательно для заполнения!");
                return false;
            }
            $this->status = 0;
            
            $this->dateredline = date_format(date_create_from_format('d.m.Y H:i', $this->dateredline),"Y-m-d H:i:s");
            if ((int)strtotime($this->datetask)>(int)strtotime($this->dateredline)){
                $this->addError('dateredline','Не удалось создать эту задачу. Срок выполнения должен быть больше текущей даты.');
                return false;       
            }
        }
        return parent::save($runValidation);
    }
    
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if ($this->status <= 1) {
            Process::deleteAll(['id_task'=>$this->id]);
            $rc = RecipeCompose::find()->where(['id_recipe'=>$this->recipe->id])->orderBy('order_pos')->all();
            foreach ($rc as $item){
                $process = new Process();
                $process->id_task = $this->id;
                $process->id_ingredient = $item->id_ingredient;
                $process->count = (float)$item->count * (float)$this->count;
                $process->count_fact = 0;
                $process->id_measure = $item->id_measure;
                $process->order = $item->order_pos;
                $process->save();
            }
        }
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Process::deleteAll(['id_task'=>$this->id]);
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetask' => 'Дата создания задачи',
            'dateredline' => 'Дата выполнения задачи (срок)',
            'id_recipe' => 'Рецептура',
            'count' => 'Количество',
            'status' => 'Статус',
            'id_user' => 'Для пользователя',
            'mail' => 'Сообщение',
        ];
    }
    
    public function getRecipe() {
        return $this->hasOne(Recipe::className(), ['id' => 'id_recipe']);
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
