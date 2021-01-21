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
        $data = Checklist::find()->select('smp')->distinct()->orderBy('smp')->all();
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
        foreach ($_POST as $key => $value)
        {
            if (!empty($value)  && $key !== '_csrf' && $key !== 'gridradio'){
                if ($key !== 'datefrom' && $key !== 'dateto'){
                    $query->andWhere(['like', $key . '.name', $value]);
                } elseif ($key == 'datefrom' || $key == 'dateto'){
                    $query->andWhere(['=', $key, '{'.Yii::$app->formatter->asDate($value, 'yyyy-MM-dd').'}']);
                }
            }
        }
        return $query->orderBy(['datefrom' => SORT_ASC]);
    }

    public function getPages()
    {
        $query = $this->getQuery();
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
        $pages = $this->getPages();
        $mydata = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $mydata;
    }

    public function actionIndex()
    {
        $pages = $this->getPages();
        $mydata = $this->getData();
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

        /*$query = Checklist::find()->joinWith(['smpName', 'inspectionName']);

        $output = fopen('export-data.csv', 'w');
        foreach ($query as $value) {
            fputcsv($output, $value['dateto'], ';');
        }
        fclose($output);
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=export-data.csv");
        header("Content-Transfer-Encoding: Binary");
        return $output;*/

    }
}