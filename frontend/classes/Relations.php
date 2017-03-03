<?php

namespace app\classes;

use app\models\Rel;
use yii\helpers\ArrayHelper;

class Relations {
    
    public static function getRelations($className, $idGeneral){
        $className = self::get_class_name($className);
        $rels = Rel::find()->where(['class_general'=>$className])->all();
        $arr = [];
        foreach ($rels as $rel) {
            $Class = "app\\models\\".$rel->class_spec;
            $items = $Class::find()->where(['id_'. strtolower($rel->class_general)=>$idGeneral])->all();
            if ($items == NULL) {
                continue;
            }
            foreach ($items as $item){
                if (empty($rel->class_ref)) {
                    $result_obj = $item;
                    $rel_class_name = self::translate($rel->class_spec);
                } else {
                    $Class_result = "app\\models\\".$rel->class_ref;
                    $element = "id_".strtolower($rel->class_ref);
                    $result_obj = $Class_result::findOne($item->$element);
                    $rel_class_name = self::translate($rel->class_spec);
                }
                if (isset($result_obj->name)){
                    $column_name = 'name';
                } else {
                    $column_name = 'id';
                }
                $arr[] = "<i>".$rel_class_name . " <b>" . $result_obj->$column_name."</i></b>";
            }
        }
        if (!$arr) {
            return false;
        } else {
            return array_unique($arr);
        }
    }
    
    private static function get_class_name($classname)
    {
        $classname = str_replace("Controller", "", $classname);
        if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
        return $pos;
    }
    
    private static function translate($classname)
    {
        $arr = [
            'Recipe'=>'Рецептура',
            'Task'=>'Задача',
            'RecipeCompose'=>'Состав рецептуры',
            'Process'=>'Состав задачи',
            'Ingredient'=>'Ингредиент',
            'Recipe'=>'Рецептура',
            'Recipe'=>'Рецептура',
            ];
        return $arr[$classname];
    }
}
