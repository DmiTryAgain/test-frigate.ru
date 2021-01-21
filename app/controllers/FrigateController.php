<?php


namespace app\controllers;

use app\models\Checklist;
use app\models\Inspection;
use app\models\Smp;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;

class FrigateController extends Controller
{

    public function actionSmpName($q = null)
    {
        $data = Checklist::find()->select('smp')->joinWith(['smpName', 'inspectionName'])->where(['ilike', 'smp.name', $q])->distinct()->orderBy('smp')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d->smpName->name];
        }
        return Json::encode($out);
    }

    public function actionInspectionName($q = null)
    {
        $data = Checklist::find()->select('inspection')->distinct()->orderBy('inspection')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d->inspectionName->name];
        }
        return Json::encode($out);
    }

    public function actionDateFrom($q = null)
    {
        $data = Checklist::find()->select('datefrom')->distinct()->orderBy('datefrom')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => Yii::$app->formatter->asDate($d->datefrom[0])];
        }
        return Json::encode($out);
    }

    public function actionDateTo($q = null)
    {
        $data = Checklist::find()->select('dateto')->distinct()->orderBy('dateto')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => Yii::$app->formatter->asDate($d->dateto[0])];
        }
        return Json::encode($out);
    }

    public function getQuery()
    {

        $query = Checklist::find()->joinWith(['smpName', 'inspectionName']);
        if (isset($_GET)){
            foreach ($_GET as $key => $value) {
                if (!empty($value) && $key !== 'gridradio' && $key !== 'page') {
                    if ($key !== 'datefrom' && $key !== 'dateto') {
                        $query->andWhere(['like', $key . '.name', $value]);
                    } elseif ($key == 'datefrom' || $key == 'dateto') {
                        $query->andWhere(['=', $key, '{' . Yii::$app->formatter->asDate($value, 'yyyy-MM-dd') . '}']);
                    }
                }
            }
        }
        return $query->orderBy(['datefrom' => SORT_DESC]);
    }

    public function getPages($query)
    {
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 2,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        return $pages;
    }

    public function getData()
    {
        $query = $this->getQuery();
        $pages = $this->getPages($query);
        $mydata = $query->offset($pages->offset)->limit($pages->limit)->all();
        return [$mydata, $pages];
    }

    public function actionIndex()
    {
        $arr = $this->getData();
        $mydata = $arr[0];
        $pages = $arr[1];
        return $this->render('index', compact('mydata', 'pages'));
    }

    public function actionAddrow()
    {
        $model = new Checklist();
        return $this->render('addrow', compact('model'));
    }

    public function actionInfo()
    {
        return $this->render('info');
    }

    /*public function actionSaveData()
    {

            $query = new Checklist();
            if (!empty($value)  && $key !== '_csrf'){
                if ($key !== 'datefrom' && $key !== 'dateto'){
                    $query->with(['smpName', 'inspectionName']);
                } elseif ($key == 'datefrom'){
                    $query->andWhere(['=', $key, '{'.Yii::$app->formatter->asDate($value, 'yyyy-MM-dd').'}']);
                }
            }

        return $query->orderBy(['datefrom' => SORT_ASC]);
    }*/

    public function actionGetCsv()
    {
        var_dump($_GET);
        $query = $this->getQuery()->all();
        $titles = ['Проверяемый СМП', 'Контролирующий орган', 'Период проверки с', 'Период проверки по', 'Плановая длительность'];
        $output = fopen('export-data.csv', 'a+w');
        fwrite($output,  iconv('UTF-8', 'Windows-1251',implode(';', $titles) . "\r\n"));
        foreach ($query as $value) {
            $arr = [
                $value->smpName->name,
                $value->inspectionName->name,
                Yii::$app->formatter->asDate($value->datefrom[0]),
                Yii::$app->formatter->asDate($value->dateto[0]),
                $value->duration,
            ];
            fwrite($output,  iconv('UTF-8', 'Windows-1251',implode(';', $arr) . "\r\n"));
        }
        header("Content-Type: application/x-force-csv");
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Disposition: attachment;filename=export-data.csv");
        readfile('export-data.csv');
        fclose($output);
        unlink('export-data.csv');
    }
}