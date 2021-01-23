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
        return [
            [['name'], 'required'],
            [['name'], 'string', 'length' => [4, 24]],
        ];
    }
}