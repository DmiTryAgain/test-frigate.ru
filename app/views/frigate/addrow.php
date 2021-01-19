<?php

/* @var $this yii\web\View */


$this->title = Yii::$app->name;

?>
<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-10">
            <form>
                <div class="row form-group row">
                    <label for="inputSMP" class="col-md-4 col-form-label">Выбор СМП</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Наименование СМП" id="inputSMP">
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputOrgan" class="col-md-4 col-form-label">Контролирующий орган</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Контролирующий орган" id="inputOrgan">
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputDateFrom" class="col-md-4 col-sm-4 col-form-label">Период проверки с</label>
                    <div class="col-md-2 col-sm-3">
                        <input type="text" class="form-control" id="inputDateFrom">
                    </div>
                    <label for="inputDateTo" class="col-md-2 col-sm-2 col-form-label" style="text-align: center">по</label>
                    <div class="col-md-2 col-sm-3">
                        <input type="text" class="form-control" id="inputDateTo">
                    </div>
                </div>
                <div class="row form-group row">
                    <label for="inputDuration" class="col-md-4 col-form-label">Плановая длительность проверки</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="" id="inputDuration">
                    </div>
                </div>
                <div class="row form-group row">
                    <div class="col-md-4 col-sm-3">

                    </div>
                    <div class="col-sm-2 col-form-label">
                        <!--Кнопка поиска-->
                        <button type="button" class="btn btn-primary">Добавить</button>
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
            </form>
        </div>
    </div>
</div>