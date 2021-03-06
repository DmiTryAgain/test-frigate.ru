<?php


namespace app\controllers;

use app\models\Checklist;
use app\models\Inspection;
use app\models\Smp;
use app\models\UploadForm;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\validators\DateValidator;
use yii\web\Controller;
use yii\web\UploadedFile;

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
        $validator = new DateValidator();

        $checklist = Checklist::find()->joinWith(['smpName', 'inspectionName']);

        if (!empty(Yii::$app->request->get('Checklist')['datefrom']) && $validator->validate(Yii::$app->request->get('Checklist')['datefrom'], $error)) {
            $checklist->andWhere(['=', 'datefrom', '{' . Yii::$app->formatter->asDate(Yii::$app->request->get('Checklist')['datefrom'], 'yyyy-MM-dd') . '}']);
        }
        if (!empty(Yii::$app->request->get('Checklist')['dateto']) && $validator->validate(Yii::$app->request->get('Checklist')['dateto'], $error)) {
            $checklist->andWhere(['=', 'dateto', '{' . Yii::$app->formatter->asDate(Yii::$app->request->get('Checklist')['dateto'], 'yyyy-MM-dd') . '}']);
        }
        if (!empty(Yii::$app->request->get('Checklist')['smpName'])) {
            $checklist->andWhere(['ilike', 'smp.name', Yii::$app->request->get('Checklist')['smpName']])->distinct();
        }
        if (!empty(Yii::$app->request->get('Checklist')['inspectionName'])) {
            $checklist->andWhere(['ilike', 'inspection.name', Yii::$app->request->get('Checklist')['inspectionName']])->distinct();
        }
        return $checklist->orderBy(['smp' => SORT_DESC]);
    }

    public function getPages($checklist)
    {
        $pages = new Pagination([
            'totalCount' => $checklist->count(),
            'pageSize' => 5,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        return $pages;
    }

    public function getData()
    {
        $checklist = $this->getQuery();
        $pages = $this->getPages($checklist);
        $mydata = $checklist->offset($pages->offset)->limit($pages->limit)->all();
        return [$mydata, $pages, $checklist];
    }

    public function actionIndex($message = null)
    {
        $checklist = new Checklist();
        $arr = $this->getData();
        $mydata = $arr[0];
        $pages = $arr[1];
        return $this->render('index', compact('mydata', 'pages', 'checklist', 'message'));
    }

    public function actionAddrow()
    {
        $model = new UploadForm();
        $checklist = new Checklist();
        $smp = new Smp();
        $inspection = new Inspection();
        return $this->render('addrow', compact('checklist', 'smp', 'inspection', 'model'));
    }

    public function actionInfo()
    {
        return $this->render('info');
    }

    public function actionError($data)
    {
        return $this->render('error', compact('data'));
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

    public function actionDeleteRow()
    {
        $checklist = new Checklist();
        $message = 'Выберете строку для удаления!';
        if (!empty(Yii::$app->request->get('Checklist')['id'])) {
            $deleteRow = Checklist::findOne(Yii::$app->request->get('Checklist')['id']);
            if ($deleteRow) {
                $deleteRow->delete();
                $message = 'Успешно удалено!';
            }
        }
        return $this->actionIndex($message);
    }

    public function actionEditData()
    {

        if (!empty(Yii::$app->request->get('Checklist')['id'])) {
            $checklist = Checklist::find()->joinWith(['smpName', 'inspectionName'])->where(['=', 'checklist.id', Yii::$app->request->get('Checklist')['id']])->one();
            $checklist->datefrom = Yii::$app->formatter->asDate($checklist->datefrom[0]);
            $checklist->dateto = Yii::$app->formatter->asDate($checklist->dateto[0]);
            return $this->render('editrow', compact('checklist'));
        } else {
            $message = 'Выберете строку для редактирования!';
            return $this->actionIndex($message);
        }
    }

    public function actionSaveEditData()
    {
        $checklist = Checklist::find()->joinWith(['smpName', 'inspectionName'])->where(['=', 'checklist.id', Yii::$app->request->get('Checklist')['id']])->one();
        if ($checklist->load(Yii::$app->request->get()) && $checklist->validate()) {
            $smp = new Smp();
            $inspection = new Inspection();

            $smpId = Smp::find()->where(['=', 'smp.name', Yii::$app->request->get('Smp')['name']])->one();
            if (empty($smpId->id)) {
                $smp->name = Yii::$app->request->get('Smp')['name'];
                $smp->save();
                $smpId = Smp::find()->where(['name' => Yii::$app->request->get('Smp')['name']])->one();
            }
            $checklist->smp = $smpId->id;

            $inspectionId = Inspection::find()->where(['=', 'inspection.name', Yii::$app->request->get('Inspection')['name']])->one();
            if (empty($inspectionId->id)) {
                $inspection->name = Yii::$app->request->get('Inspection')['name'];
                $inspection->save();
                $inspectionId = Inspection::find()->where(['name' => Yii::$app->request->get('Inspection')['name']])->one();
            }
            $checklist->inspection = $inspectionId->id;

            $checklist->datefrom = new \yii\db\Expression("ARRAY['" . Yii::$app->formatter->asDate($checklist->datefrom, 'yyyy-MM-dd') . "']::timestamp[]");

            $checklist->dateto = new \yii\db\Expression("ARRAY['" . Yii::$app->formatter->asDate($checklist->dateto, 'yyyy-MM-dd') . "']::timestamp[]");

            $checklist->save(false);
            return $this->render('successEdit');
        }
        return $this->render('editrow', compact('checklist'));
    }

    public function saveRows($smp, $inspection, $checklist)
    {
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

    }


    public function actionSaveData($data = null)
    {
        $model = new UploadForm();
        $checklist = new Checklist();
        $smp = new Smp();
        $inspection = new Inspection();
        if (
            $smp->load(Yii::$app->request->get()) &&
            $inspection->load(Yii::$app->request->get()) &&
            $checklist->load(Yii::$app->request->get()) &&
            $smp->validate() &&
            $inspection->validate() &&
            $checklist->validate()
        ) {
            $this->saveRows($smp, $inspection, $checklist);
            return $this->render('success');
        } elseif (!empty($data)) {
            $smp->name = $data[0];
            $inspection->name = $data[1];
            $checklist->datefrom = $data[2];
            $checklist->dateto = $data[3];
            $checklist->duration = $data[4];
            if ($smp->validate() &&
                $inspection->validate() &&
                $checklist->validate()) {
                $this->saveRows($smp, $inspection, $checklist);
            } else {
                return false;
            }
        } else return $this->render('addrow', compact('checklist', 'smp', 'inspection', 'model'));
    }

    public function actionImportCsv()
    {
        $model = new UploadForm();
        $checklist = new Checklist();
        $smp = new Smp();
        $inspection = new Inspection();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $path = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                $model->file->saveAs($path);
                ini_set("auto_detect_line_endings", true);
                $handle = fopen($path, "r");
                while (($csvArray = fgetcsv($handle, 10000, ';')) !== false) {
                    $data = mb_convert_encoding($csvArray, 'utf-8', 'windows-1251');
                    if ($this->actionSaveData($data) === false) {
                        fclose($handle);
                        unlink($path);
                        return $this->actionError($data);
                    }
                }
                fclose($handle);
                unlink($path);
                return $this->render('success');
            } else {
                return $this->render('addrow', compact('checklist', 'smp', 'inspection', 'model'));
            }
        }
    }
}