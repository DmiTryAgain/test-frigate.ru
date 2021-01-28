<?php


namespace app\models;

use yii\db\ActiveRecord;

class  Checklist extends ActiveRecord
{

    public static function tableName()
    {
        return '{{checklist}}';
    }

    public function getSmpName()
    {
        return $this->hasOne(Smp::class, ['id' => 'smp']);
    }

    public function getInspectionName()
    {
        return $this->hasOne(Inspection::class, ['id' => 'inspection']);
    }

    public function rules()
    {
        $durationLenghtMessage = 'Плановая длительность не может быть меньше 0';
        return [
            [['dateto', 'datefrom', 'duration'], 'required', 'message' => 'Это поле обязательно'],
            [['datefrom', 'dateto'], 'date', 'format' => 'dd.MM.yyyy', 'message' => 'Введён некорректный формат даты'],
            ['duration', 'integer', 'min' => 0, 'message' => 'Введите целочисленное значение', 'tooSmall' => $durationLenghtMessage],
        ];
    }

}