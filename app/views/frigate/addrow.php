<?php

/* @var $this yii\web\View */


use kartik\form\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;

?>
<?php print_r($_POST) ?>
<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(
                ['id' => 'add']
            ); ?>
                <div class="row form-group row">
                    <label for="inputSMP" class="col-md-4 col-form-label">Выбор СМП</label>
                    <div class="col-md-6">
                        <?= Typeahead::widget([
                            'name' => 'smp',
                            'options' => ['placeholder' => 'Наименование СМП ...'],
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
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputOrgan" class="col-md-4 col-form-label">Контролирующий орган</label>
                    <div class="col-md-6">
                        <?= Typeahead::widget([
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
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputDateFrom" class="col-md-4 col-sm-4 col-form-label">Период проверки с</label>
                    <div class="col-md-2 col-sm-3">
                        <?= Html::input('text','datefrom', '' ,['class' => 'form-control']) ?>

                    </div>
                    <label for="inputDateTo" class="col-md-2 col-sm-2 col-form-label" style="text-align: center">по</label>
                    <div class="col-md-2 col-sm-3">
                        <?= Html::input('text','dateto', '' ,['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputDuration" class="col-md-4 col-form-label">Плановая длительность проверки</label>
                    <div class="col-md-6">
                        <?= Html::input('number','duration', '' ,['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="row form-group row">
                    <div class="col-md-4 col-sm-3">

                    </div>
                    <div class="col-sm-2 col-form-label">
                        <!--Кнопка поиска-->
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary',]) ?>
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