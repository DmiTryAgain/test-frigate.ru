<?php


namespace app\controllers;

use app\models\Checklist;
use app\models\Inspection;
use app\models\Smp;
use Yii;
use yii\data\Pagination;
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
        $data = Checklist::find()->select('inspection')->joinWith(['smpName', 'inspectionName'])->where(['ilike', 'inspection.name', $q])->distinct()->orderBy('inspection')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d->inspectionName->name];
        }
        return Json::encode($out);
    }

    public function actionDateFrom()
    {
        $data = Checklist::find()->select('datefrom')->distinct()->orderBy('datefrom')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => Yii::$app->formatter->asDate($d->datefrom[0])];
        }
        return Json::encode($out);
    }

    public function actionDateTo()
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
        if (isset($_GET)) {
            foreach ($_GET as $key => $value) {
                if (!empty($value) && $key !== 'gridradio' && $key !== 'page' && $key !== '_csrf' && $key !== 'search' && $key !== 'csv' && $key !== 'r') {
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
        return $this->render('addrow');
    }

    public function actionInfo()
    {
        return $this->render('info');
    }

    public function actionSaveData()
    {
        $checklist = new Checklist();
        $smp = new Smp();
        $inspection = new Inspection();
        if (!empty($_GET['smp'] && $_GET['inspection'] && $_GET['datefrom'] && $_GET['dateto'] && $_GET['duration'])) {
            $smpId = Smp::find()->where(['name' => $_GET['smp']])->one();

            if (empty($smpId)) {
                $smp->name = $_GET['smp'];
                $smp->save();
                $smpId = Smp::find()->where(['name' => $_GET['smp']])->one();
            }
            $checklist->smp = $smpId->id;

            $inspectionId = Inspection::find()->where(['name' => $_GET['inspection']])->one();
            if (empty($inspectionId)) {
                $inspection->name = $_GET['inspection'];
                $inspection->save();
                $inspectionId = Inspection::find()->where(['name' => $_GET['inspection']])->one();
            }
            $checklist->inspection = $inspectionId->id;

            $checklist->datefrom = new \yii\db\Expression("ARRAY['" . Yii::$app->formatter->asDate($_GET['datefrom'], 'yyyy-MM-dd') . "']::timestamp[]");

            $checklist->dateto = new \yii\db\Expression("ARRAY['" . Yii::$app->formatter->asDate($_GET['dateto'], 'yyyy-MM-dd') . "']::timestamp[]");

            $checklist->duration = $_GET['duration'];
            var_dump($checklist->datefrom);

            $checklist->save();

            var_dump($checklist->errors);

            return true;
        } else {
            return 'пустой гет';
        }


    }

    public function actionGetCsv()
    {
        $query = $this->getQuery()->all();
        $titles = ['Проверяемый СМП', 'Контролирующий орган', 'Период проверки с', 'Период проверки по', 'Плановая длительность'];
        $output = fopen('export-data.csv', 'a+w');
        fwrite($output, iconv('UTF-8', 'Windows-1251', implode(';', $titles) . "\r\n"));
        foreach ($query as $key => $value) {
            $arr = [
                $value->smpName->name,
                $value->inspectionName->name,
                Yii::$app->formatter->asDate($value->datefrom[0]),
                Yii::$app->formatter->asDate($value->dateto[0]),
                $value->duration,
            ];
            fwrite($output, iconv('UTF-8', 'Windows-1251', implode(';', $arr) . "\r\n"));
        }
        header("Content-Type: application/x-force-csv");
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Disposition: attachment;filename=export-data.csv");
        readfile('export-data.csv');
        fclose($output);
        unlink('export-data.csv');
    }
}