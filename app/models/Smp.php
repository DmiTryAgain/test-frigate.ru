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
        return [
            [['name'], 'required'],
            [['name'], 'string', 'length' => [4, 24]],
        ];
    }
}