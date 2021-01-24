<?php


namespace app\models;


use yii\db\ActiveRecord;

class Smp extends ActiveRecord
{
    public static function tableName()
    {
        return 'smp';
    }
    public function rules()
    {
        $smpLenghtMessage = 'Значение должно содержать минимум 4 и максимум 24 символов';
        return [
            [['name'], 'required', 'message' => 'Это поле обязательно'],
            [['name'], 'string', 'length' => [4, 24], 'message' => 'Введите строковое значение', 'tooShort' => $smpLenghtMessage, 'tooLong' => $smpLenghtMessage],
        ];
    }
}