<?php


namespace app\models;


use yii\db\ActiveRecord;

class Inspection extends ActiveRecord
{
    public static function tableName()
    {
        return 'inspection';
    }
}