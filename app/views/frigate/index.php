<?php

/* @var $this yii\web\View */

use kartik\form\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;

?>
<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <div class="offset-lg-2 col-lg-10">
            <?php $form = ActiveForm::begin(
                ['id' => 'search', 'method' => 'get', 'action' => 'frigate/index']
            ); ?>
            <div class="row form-group row">
                <label for="smp" class="col-md-4 col-form-label">Наименование СМП</label>
                <div class="col-md-6">
                    <?= $form->field($checklist, 'smpName')->widget(Typeahead::className(), [
                        'name' => 'smp',
                        'options' => ['placeholder' => 'Наименование СМП ...'],
                        'scrollable' => true,
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',

                                'prefetch' => Url::to(['frigate/index']),
                                'remote' => [
                                    'url' => Url::to(['frigate/smp-name']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]
                        ]
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="row form-group row">
                <label for="inspection" class="col-md-4 col-form-label">Контролирующий орган</label>
                <div class="col-md-6">
                    <?= $form->field($checklist, 'inspectionName')->widget(Typeahead::className(), [
                        'name' => 'inspection',
                        'options' => ['placeholder' => 'Контролирующий орган ...'],
                        'scrollable' => true,
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'prefetch' => Url::to(['frigate/index']),
                                'remote' => [
                                    'url' => Url::to(['frigate/inspection-name']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]
                        ]
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="row form-group row">
                <label for="datefrom" class="col-md-4 col-sm-4 col-form-label">Период проверки с</label>
                <div class="col-md-2 col-sm-3">
                    <?= $form->field($checklist, 'datefrom')->widget(Typeahead::className(), [
                        'name' => 'datefrom',
                        'options' => ['placeholder' => "дд.мм.гггг"],
                        'scrollable' => true,
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',

                                'prefetch' => Url::to(['frigate/index']),
                                'remote' => [
                                    'url' => Url::to(['frigate/date-from']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]
                        ]
                    ])->label(false);
                    ?>
                </div>
                <label for="dateto" class="col-md-2 col-sm-2 col-form-label"
                       style="text-align: center">по</label>
                <div class="col-md-2 col-sm-3">
                    <?= $form->field($checklist, 'dateto')->widget(Typeahead::className(), [
                        'name' => 'dateto',
                        'options' => ['placeholder' => "дд.мм.гггг"],
                        'scrollable' => true,
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',

                                'prefetch' => Url::to(['frigate/date-to']),
                                'remote' => [
                                    'url' => Url::to(['frigate/date-to']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]
                        ]
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="row form-group row">
                <div class="offset-xl-4 offset-md-3 offset-sm-2 col-sm-2 col-xl-1 col-form-label">
                    <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary', 'formaction' => Url::to(['frigate/index']), 'value' => 'search']) ?>
                </div>
                <div class="col-sm-2 col-xl-3 col-form-label">
                    <?= Html::resetButton('Очистить', ['class' => 'btn btn-secondary']) ?>
                </div>
                <div class="col-sm-2 col-form-label">
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Дополнительные действия
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item badge-success"
                           href="<?= Url::to(['frigate/get-csv?' . Yii::$app->request->getQueryString()]) ?>">Экспортировать
                            найденное в CSV</a>
                        <?= Html::input('submit', '', 'Удалить отмеченное', ['class' => 'dropdown-item badge-danger', 'formaction' => Url::to(['frigate/delete-row'])]) ?>
                        <?= Html::input('submit', '', 'Редактировать отмеченное', ['class' => 'dropdown-item alert-secondary', 'formaction' => Url::to(['frigate/edit-data'])]) ?>
                        <a class="dropdown-item badge-info"
                           href="<?= yii\helpers\Url::to('frigate/addrow') ?>">Добавить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-1 offset-lg-2 col-md-11 col-lg-10">
            <div class="row">
                <div class="col-md-10">
                    <h5 style="text-align: center; background: <?php
                    switch ($message) {
                        case 'Успешно удалено!' :
                            echo 'lightgreen';
                            break;
                        case 'Выберете строку для удаления!' || 'Выберете строку для редактирования!' :
                            echo '#ff9da4';
                            break;
                    }
                    ?>; padding: 15px;"><?= $message ?></h5>
                    <table class="table table-bordered table-responsive-lg" style="text-align: center">
                        <?php if (!empty($mydata)){ ?>
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
                        <?php
                        foreach ($mydata as $data): ?>
                            <tr>
                                <th scope="row">
                                    <?= $form->field($checklist, 'id', ['addClass' => 'form'])->input('radio', ['id' => $data->id, 'value' => $data->id, 'name' => $checklist['id']])->label(false) ?>
                                </th>
                                <td><?= $data->smpName->name; ?></td>
                                <td><?= $data->inspectionName->name; ?></td>
                                <td><?= Yii::$app->formatter->asDate($data->datefrom[0]); ?></td>
                                <td><?= Yii::$app->formatter->asDate($data->dateto[0]); ?></td>
                                <td><?= $data->duration; ?></td>
                            </tr>
                        <?php endforeach;

                        } else { ?>
                            <h5 style="text-align: center">Ничего не найдено</h5>
                            <?php
                        } ?>
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
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>