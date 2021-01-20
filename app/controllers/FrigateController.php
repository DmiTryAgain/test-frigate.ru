<?php


namespace app\controllers;

use app\models\Checklist;
use app\models\Inspection;
use app\models\Smp;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;

class FrigateController extends Controller
{

    public function actionSmpName($q = null)
    {
        $data = Checklist::find()->select('smp')->orderBy('smp')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d->smpName->name];
        }
        return Json::encode($out);
    }

    public function actionInspectionName($q = null)
    {
        $data = Checklist::find()->select('inspection')->orderBy('inspection')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d->inspectionName->name];
        }
        return Json::encode($out);
    }

    public function actionDateFrom($q = null)
    {
        $data = Checklist::find()->select('datefrom')->orderBy('datefrom')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => Yii::$app->formatter->asDate($d->datefrom[0])];
        }
        return Json::encode($out);
    }

    public function actionDateTo($q = null)
    {
        $data = Checklist::find()->select('dateto')->orderBy('dateto')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => Yii::$app->formatter->asDate($d->dateto[0])];
        }
        return Json::encode($out);
    }

    public function search()
    {

    }

    public static function getQuery()
    {
        $query = Checklist::find()->with('smpName', 'inspectionName')->orderBy(['smp' => SORT_ASC]);

        if(isset($_POST['smp']))
        {
            $a = $_POST['smp'];
            $query = Checklist::find()->leftJoin('smp','checklist.smp = smp.id')->where(['like','smp.name', $a])->orderBy(['smp' => SORT_ASC]);
        }
        return $query;

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
        return $this->render('addrow');
    }

    public function actionInfo()
    {
        return $this->render('info');
    }

    public function getCsv($mydata)
    {
        header('Content-Type: text/csv; charset=windows-1251');
        header('Content-Disposition: attachment; filename=export-full-table.csv');
        $output = fopen('php://output', 'w');
        foreach ($mydata as $key => $value) {
            fputcsv($output, $value, ';');
        }
        fclose($output);
    }

    public function actionDownloadExcel()
    {
        $this->getCsv($this->getQuery());
        return $this->render('downloadExcel');
    }


}