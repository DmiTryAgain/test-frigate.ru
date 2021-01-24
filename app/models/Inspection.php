<?php


namespace app\models;


use yii\db\ActiveRecord;

class Inspection extends ActiveRecord
{
    public static function tableName()
    {
        return 'inspection';
    }
    public function rules()
    {
        $inspectionLenghtMessage = 'Значение должно содержать минимум 4 и максимум 24 символов';
        return [
            [['name'], 'required', 'message' => 'Это поле обязательно'],
            [['name'], 'string', 'length' => [4, 24], 'message' => 'Введите строковое значение', 'tooShort' => $inspectionLenghtMessage, 'tooLong' => $inspectionLenghtMessage],
        ];
    }
}