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
        /*$data = Smp::find()->select('name')->where(['like', 'name', $q])->distinct()->orderBy('name')->all();*/
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

    /*public function getQuery()
    {
        $query = Checklist::find()->joinWith(['smpName', 'inspectionName']);
        if (isset($_GET)) {
            foreach ($_GET as $key => $value) {
                if (!empty($value) && $key !== 'Checklist' && $key !== 'page' && $key !== '_csrf' && $key !== 'search' && $key !== 'csv' && $key !== 'r') {
                    if ($key !== 'datefrom' && $key !== 'dateto') {
                        $query->andWhere(['like', $key . '.name', $value]);
                    } elseif ($key == 'datefrom' || $key == 'dateto') {
                        $query->andWhere(['=', $key, '{' . Yii::$app->formatter->asDate($value, 'yyyy-MM-dd') . '}']);
                    }
                }
            }
        }
        return $query->orderBy(['datefrom' => SORT_DESC]);
    }*/

    public function getQuery()
    {
        $checklist = Checklist::find()->joinWith(['smpName', 'inspectionName']);

        if (!empty(Yii::$app->request->get('Checklist')['smpName'])) {
            $checklist->andWhere(['ilike', 'smp.name', Yii::$app->request->get('Checklist')['smpName']])->distinct();
        }
        if (!empty(Yii::$app->request->get('Checklist')['inspectionName'])) {
            $checklist->andWhere(['ilike', 'inspection.name', Yii::$app->request->get('Checklist')['inspectionName']])->distinct();
        }
        if (!empty(Yii::$app->request->get('Checklist')['datefrom'])) {
            $checklist->andWhere(['=', 'datefrom', '{' . Yii::$app->formatter->asDate(Yii::$app->request->get('Checklist')['datefrom'], 'yyyy-MM-dd') . '}']);
        }
        if (!empty(Yii::$app->request->get('Checklist')['dateto'])) {
            $checklist->andWhere(['=', 'dateto', '{' . Yii::$app->formatter->asDate(Yii::$app->request->get('Checklist')['dateto'], 'yyyy-MM-dd') . '}']);
        }

        return $checklist->orderBy(['datefrom' => SORT_DESC]);
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

    public function actionIndex($deleteMessage = null)
    {
        $checklist = new Checklist();
        $arr = $this->getData();
        $mydata = $arr[0];
        $pages = $arr[1];
        return $this->render('index', compact('mydata', 'pages', 'checklist', 'deleteMessage'));
    }

    public function actionAddrow()
    {
        $checklist = new Checklist();
        $smp = new Smp();
        $inspection = new Inspection();
        return $this->render('addrow', compact('checklist', 'smp', 'inspection'));
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
        if ($smp->load(Yii::$app->request->get()) && $inspection->load(Yii::$app->request->get()) && $checklist->load(Yii::$app->request->get()) && $smp->validate() && $inspection->validate() && $checklist->validate()) {
            $smpId = Smp::find()->where(['name' => $smp->name])->one();

            if (empty($smpId)) {
                $smp->save();
                $smpId = Smp::find()->where(['name' => $smp->name])->one();
            }
            $checklist->smp = $smpId->id;

            $inspectionId = Inspection::find()->where(['name' => $inspection->name])->one();
            if (empty($inspectionId)) {
                $inspection->save();
                $inspectionId = Inspection::find()->where(['name' => $inspection->name])->one();
            }
            $checklist->inspection = $inspectionId->id;

            $datefrom = $checklist->datefrom;

            $dateto = $checklist->dateto;

            $checklist->datefrom = new \yii\db\Expression("ARRAY['" . Yii::$app->formatter->asDate($checklist->datefrom, 'yyyy-MM-dd') . "']::timestamp[]");

            $checklist->dateto = new \yii\db\Expression("ARRAY['" . Yii::$app->formatter->asDate($checklist->dateto, 'yyyy-MM-dd') . "']::timestamp[]");

            $checklist->save(false);

            $checklist->datefrom = $datefrom;

            $checklist->dateto = $dateto;

            return $this->render('success');
        }
        return $this->render('addrow', compact('checklist', 'smp', 'inspection'));
    }

    public function actionDeleteRow()
    {
        $checklist = new Checklist();
        $deleteMessage = 'Выберете строку для удаления!';
        if ($checklist->load(Yii::$app->request->get())) {
            $deleteRow = Checklist::findOne(Yii::$app->request->get('Checklist')['id']);
            if ($deleteRow) {
                $deleteRow->delete();
                $deleteMessage = 'Успешно удалено!';
            }
        }
        return $this->actionIndex($deleteMessage);
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