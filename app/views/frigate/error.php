<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;

?>
<div class="container-fluid" style="margin-top: 50px; text-align: center;">
    <h5 style="text-align: center; background: #ff9da4; padding: 15px;">При добалении данных возникли ошибки!</h5>
    <p>Строка <?= '"' . $data[0] . ';' . $data[1] . ';' . $data[2] . ';' . $data[3] . ';' . $data[4] . '"'?></p>
    <p>Содержит некорректные данные</p>
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
                        Попробовать ещё раз!
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
