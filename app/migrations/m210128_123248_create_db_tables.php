<?php

use yii\db\Expression;
use yii\db\Migration;
use yii\db\pgsql\Schema;

/**
 * Class m210128_123248_create_db_tables
 */
class m210128_123248_create_db_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210128_123248_create_db_tables cannot be reverted.\n";

        return false;
    }

    private $smp = ['ООО "Колосок"', 'ИП "Бандурин А.И."', 'ИП "Бандюков Ю.В."', 'ПАО "МТС"', 'ООО "Мишкино"', 'ОАО "Деренжер"'];
    private $inspection = ['Роскомнадзор', 'Налоговая', 'Природнадзор', 'Наркология', 'Пожарная безопаснеость'];
    private $checklist = [
        ['smp' => 1, 'inspection' => 2, 'datefrom' => "ARRAY['2009-06-12']::timestamp[]", 'dateto' => "ARRAY['2009-06-17']::timestamp[]", 'duration' => 5],
        ['smp' => 1, 'inspection' => 3, 'datefrom' => "ARRAY['2009-07-15']::timestamp[]", 'dateto' => "ARRAY['2009-07-19']::timestamp[]", 'duration' => 9],
        ['smp' => 2, 'inspection' => 3, 'datefrom' => "ARRAY['2010-09-06']::timestamp[]", 'dateto' => "ARRAY['2010-09-11']::timestamp[]", 'duration' => 20],
        ['smp' => 3, 'inspection' => 1, 'datefrom' => "ARRAY['2012-02-16']::timestamp[]", 'dateto' => "ARRAY['2012-02-22']::timestamp[]", 'duration' => 11],
        ['smp' => 4, 'inspection' => 5, 'datefrom' => "ARRAY['2012-12-12']::timestamp[]", 'dateto' => "ARRAY['2012-12-14']::timestamp[]", 'duration' => 7],
        ['smp' => 3, 'inspection' => 4, 'datefrom' => "ARRAY['2013-03-01']::timestamp[]", 'dateto' => "ARRAY['2013-03-06']::timestamp[]", 'duration' => 3],
        ['smp' => 1, 'inspection' => 4, 'datefrom' => "ARRAY['2013-01-17']::timestamp[]", 'dateto' => "ARRAY['2013-01-23']::timestamp[]", 'duration' => 9],
        ['smp' => 2, 'inspection' => 2, 'datefrom' => "ARRAY['2013-05-01']::timestamp[]", 'dateto' => "ARRAY['2013-05-05']::timestamp[]", 'duration' => 20],
        ['smp' => 3, 'inspection' => 1, 'datefrom' => "ARRAY['2014-01-14']::timestamp[]", 'dateto' => "ARRAY['2014-01-20']::timestamp[]", 'duration' => 11],
        ['smp' => 6, 'inspection' => 1, 'datefrom' => "ARRAY['2018-12-13']::timestamp[]", 'dateto' => "ARRAY['2018-12-16']::timestamp[]", 'duration' => 7],
        ['smp' => 3, 'inspection' => 4, 'datefrom' => "ARRAY['2018-08-06']::timestamp[]", 'dateto' => "ARRAY['2018-08-17']::timestamp[]", 'duration' => 3],
        ['smp' => 6, 'inspection' => 5, 'datefrom' => "ARRAY['2018-09-24']::timestamp[]", 'dateto' => "ARRAY['2018-09-28']::timestamp[]", 'duration' => 9],
        ['smp' => 2, 'inspection' => 5, 'datefrom' => "ARRAY['2019-09-22']::timestamp[]", 'dateto' => "ARRAY['2019-09-25']::timestamp[]", 'duration' => 20],
        ['smp' => 6, 'inspection' => 1, 'datefrom' => "ARRAY['2020-04-16']::timestamp[]", 'dateto' => "ARRAY['2020-04-18']::timestamp[]", 'duration' => 11],
        ['smp' => 4, 'inspection' => 2, 'datefrom' => "ARRAY['2021-11-11']::timestamp[]", 'dateto' => "ARRAY['2021-11-17']::timestamp[]", 'duration' => 7],
        ['smp' => 3, 'inspection' => 4, 'datefrom' => "ARRAY['2021-06-08']::timestamp[]", 'dateto' => "ARRAY['2021-06-11']::timestamp[]", 'duration' => 3],
    ];

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('smp', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ]);
        $this->createTable('inspection', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ]);
        $this->createTable('checklist', [
            'id' => Schema::TYPE_PK,
            'smp' => $this->integer()->notNull(),
            'inspection' => $this->integer()->notNull(),
            'datefrom' => 'timestamp with time zone [0]',
            'dateto' => 'timestamp with time zone [0]',
            'duration' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey(
            'smp',
            'checklist',
            'smp',
            'smp',
            'id'
        );
        $this->addForeignKey(
            'inspection',
            'checklist',
            'inspection',
            'inspection',
            'id'
        );


        foreach ($this->smp as $value) {
            $this->insert('smp', ['name' => $value]);
        }

        foreach ($this->inspection as $value) {
            $this->insert('inspection', ['name' => $value]);
        }
        foreach ($this->checklist as $value) {
                $this->insert('checklist', [
                    'smp' => $value['smp'],
                    'inspection' => $value['inspection'],
                    'datefrom' => new Expression($value['datefrom']),
                    'dateto' => new Expression($value['dateto']),
                    'duration' => new Expression($value['duration']),]);
        }

    }

    public function down()
    {
        echo "m210128_123248_create_db_tables cannot be reverted.\n";

        return false;
    }

}
