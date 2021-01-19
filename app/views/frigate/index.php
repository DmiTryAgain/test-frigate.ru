<?php

/* @var $this yii\web\View */

use kartik\typeahead\Typeahead;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;

?>
<?php //print_r($data) ?>
<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-10">
            <form>
                <div class="row form-group row">
                    <label for="inputSMP" class="col-md-4 col-form-label">Наименование СМП</label>
                    <div class="col-md-6">
                        <?= Typeahead::widget([
                            'name' => 'inputSMP',
                            'options' => ['placeholder' => 'Наименование СМП ...'],
                            'scrollable' => true,
                            'pluginOptions' => ['highlight' => true],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'prefetch' => '@web' . '/samples/smp.json',
                                    'remote' => [
                                        'url' => Url::to(['frigate/smp-name']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputOrgan" class="col-md-4 col-form-label">Контролирующий орган</label>
                    <div class="col-md-6">
                        <?= Typeahead::widget([
                            'name' => 'inputOrgan',
                            'options' => ['placeholder' => 'Контролирующий орган ...'],
                            'scrollable' => true,
                            'pluginOptions' => ['highlight' => true],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'prefetch' => '@web' . '/samples/inspection.json',
                                    'remote' => [
                                        'url' => Url::to(['frigate/inspection-name']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputDateFrom" class="col-md-4 col-sm-4 col-form-label">Период проверки с</label>
                    <div class="col-md-2 col-sm-3">
                        <?= Typeahead::widget([
                            'name' => 'inputDateFrom',
                            'options' => ['placeholder' => '...'],
                            'scrollable' => true,
                            'pluginOptions' => ['highlight' => true],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'prefetch' => '@web' . '/samples/datefrom.json',
                                    'remote' => [
                                        'url' => Url::to(['frigate/date-from']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <label for="inputDateTo" class="col-md-2 col-sm-2 col-form-label"
                           style="text-align: center">по</label>
                    <div class="col-md-2 col-sm-3">
                        <?= Typeahead::widget([
                            'name' => 'inputDateFrom',
                            'options' => ['placeholder' => '...'],
                            'scrollable' => true,
                            'pluginOptions' => ['highlight' => true],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'prefetch' => '@web' . '/samples/dateto.json',
                                    'remote' => [
                                        'url' => Url::to(['frigate/date-to']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <div class="col-md-4 col-sm-3">

                    </div>
                    <div class="col-sm-2 col-form-label">
                        <!--Кнопка поиска-->
                        <button type="button" class="btn btn-primary">Поиск</button>
                        <!--Конец кнопки поиска-->
                    </div>
                    <div class="col-sm-2 col-form-label">
                        <!--Кнопка с выпадающим списком-->

                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Дополнительные действия
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item badge-success"
                               href="<?= yii\helpers\Url::to('frigate/download-excel') ?>">Экспортировать найденное в
                                Excell</a>
                            <a class="dropdown-item badge-danger" href="#">Удалить отмеченное</a>
                            <a class="dropdown-item alert-secondary" href="#">Редактировать отмеченное</a>
                            <a class="dropdown-item badge-info" href="#">Добавить</a>
                        </div>

                    </div>
                </div>
                <!--Конец кнопки с выпадающим списком-->
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1 col-lg-2">
        </div>
        <div class="col-md-11 col-lg-10">
            <div class="row">
                <div class="col-md-10">
                    <table class="table table-bordered table-responsive-lg" style="text-align: center">

                        <tr class="table-primary">
                            <th scope="col" rowspan="2">Отметить выбор</th>
                            <th scope="col" rowspan="2">Проверяемый СМП</th>
                            <th scope="col" rowspan="2">Контролирующий орган</th>
                            <th scope="col" colspan="2">Период проверки</th>
                            <th scope="col" rowspan="2">Плановая длительность</th>
                        </tr>
                        <tr class="table-primary">

                            <th scope="col">С</th>
                            <th scope="col">По</th>
                        </tr>
                        <tbody>
                        <?php foreach ($mydata as $data): ?>
                            <tr>
                                <th scope="row">
                                    <?= Html::radio('gridRadio', false, ['id' => 'gridRadio' . $data->id, 'value' => 'option' . $data->id]) ?>
                                </th>
                                <td><?= $data->smpName->name; ?></td>
                                <td><?= $data->inspectionName->name; ?></td>
                                <td><?= Yii::$app->formatter->asDate($data->datefrom[0]); ?></td>
                                <td><?= Yii::$app->formatter->asDate($data->dateto[0]); ?></td>
                                <td><?= $data->duration; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>


                    <?= yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'maxButtonCount' => 7,
                        'firstPageLabel' => 'Начало',
                        'lastPageLabel' => 'Конец',
                        'options' => [
                            'class' => 'pagination justify-content-center'
                        ],
                        'linkOptions' => [
                            'class' => 'page-link',
                        ],
                        'disabledPageCssClass' => 'page-link disabled',
                        'activePageCssClass' => 'page-item active',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
