<?php


namespace app\models;
use yii\db\ActiveRecord;

class Checklist extends ActiveRecord
{
    public static function tableName()
    {
        return 'checklist';
    }

    public function getSmpName()
    {
        return $this->hasOne(Smp::class, ['id' => 'smp']);
    }
    public function getInspectionName()
    {
        return $this->hasOne(Inspection::class, ['id' => 'inspection']);
    }
}