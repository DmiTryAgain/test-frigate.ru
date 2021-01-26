<?php

/* @var $this yii\web\View */


use kartik\form\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;

?>
<?php //var_dump($checklist->datefrom); ?>
<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <div class="offset-lg-2 col-lg-10">
            <?php $form = ActiveForm::begin(
                ['id' => 'edit', 'method' => 'get', 'action' => 'frigate/save-edit-data']
            ); ?>
            <div class="row form-group row">
                <label for="smp" class="col-md-4 col-form-label">Выбор СМП</label>
                <div class="col-md-6">
                    <?= $form->field($checklist->smpName, 'name')->widget(Typeahead::className(),[
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
                <label for="inputOrgan" class="col-md-4 col-form-label">Контролирующий орган</label>
                <div class="col-md-6">
                    <?= $form->field($checklist->inspectionName, 'name')->widget(Typeahead::className(),[
                        'name' => 'inspection',
                        'options' => ['placeholder' => 'Контролирующий орган ...'],
                        'scrollable' => true,
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
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
                <label for="inputDateFrom" class="col-md-4 col-sm-4 col-form-label">Период проверки с</label>
                <div class="col-md-2 col-sm-3">
                    <?= $form->field($checklist, 'datefrom')->input('text', ['placeholder' => "дд.мм.гггг"])->label(false) ?>
                </div>
                <label for="inputDateTo" class="col-md-2 col-sm-2 col-form-label" style="text-align: center">по</label>
                <div class="col-md-2 col-sm-3">
                    <?= $form->field($checklist, 'dateto')->input('text', ['placeholder' => "дд.мм.гггг"])->label(false) ?>
                </div>
            </div>
            <div class="row form-group row">
                <label for="inputDuration" class="col-md-4 col-form-label">Плановая длительность проверки</label>
                <div class="col-md-6">
                    <?= $form->field($checklist, 'duration')->input('number')->label(false) ?>
                    <?= $form->field($checklist, 'id')->input('hidden')->label(false) ?>
                </div>
            </div>
            <div class="row form-group row">
                <div class="offset-md-4 offset-sm-3 col-sm-2 col-form-label">
                    <!--Кнопка поиска-->
                    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary',]) ?>
                    <!--Конец кнопки поиска-->
                </div>
                <div class="col-sm-4 col-form-label">
                    <!--Кнопка с выпадающим списком-->
                    <button type="button" class="btn btn-primary">
                        Импорт из Excell
                    </button>
                </div>
            </div>
            <!--Конец кнопки с выпадающим списком-->
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>