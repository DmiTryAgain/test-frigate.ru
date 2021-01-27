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
                ['id' => 'add', 'method' => 'get', 'action' => 'frigate/save-data']
            ); ?>
            <div class="row form-group row">
                <label for="smp" class="col-md-4 col-form-label">Выбор СМП</label>
                <div class="col-md-6">
                    <?= $form->field($smp, 'name')->widget(Typeahead::className(),[
                        'name' => 'smp',
                        'options' => ['placeholder' => 'Наименование СМП ...', 'value' => ''],
                        'scrollable' => true,
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
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
                    <?= $form->field($inspection, 'name')->widget(Typeahead::className(),[
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
                </div>
            </div>
            <div class="row form-group row">
                <div class="offset-md-4 offset-sm-3 col-sm-2 col-form-label">

                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary',]) ?>

                </div>
                <div class="col-sm-4 col-form-label">

                    <?php ActiveForm::end(); ?>
                    <?php $form = ActiveForm::begin(
                        ['id' => 'impotcsv', 'method' => 'post', 'action' => 'frigate/addrow']
                    ); ?>
                    <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                    <?= Html::submitButton('Импорт из CSV', ['class' => 'btn btn-primary', 'formaction' => Url::to(['frigate/import-csv']), 'value' => 'import-csv']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>