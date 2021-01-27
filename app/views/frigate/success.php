<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;

?>
<div class="container-fluid" style="margin-top: 50px;">
    <h5 style="text-align: center; background: lightgreen; padding: 15px;">Запись успешно добавлена!</h5>
    <div class="row">
        <div class="offset-lg-2 col-lg-10">
            <div class="row form-group row">
            <div class="offset-sm-2 offset-lg-1 offset-xl-2 col-sm-5 col-xl-3 col-form-label">
                <a type="button" class="btn btn-primary" href="<?= yii\helpers\Url::to('/') ?>">
                    Вернуться на главную
                </a>
            </div>
            <div class="col-sm-4 col-form-label">
                <a type="button" class="btn btn-primary" href="<?= yii\helpers\Url::to('frigate/addrow') ?>">
                    Добавить ещё!
                </a>
            </div>
            </div>
        </div>
    </div>
</div>
