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
                    <label for="inputSMP" class="col-md-4 col-form-label">Наименование СМП</label>
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
                    <label for="inputDateTo" class="col-md-2 col-sm-2 col-form-label"
                           style="text-align: center">по</label>
                    <div class="col-md-2 col-sm-3">
                        <input type="text" class="form-control" id="inputDateTo">
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
                            <a class="dropdown-item badge-success" href="#">Экспортировать найденное в Excell</a>
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
                        <tr>
                            <th scope="row"><input type="radio" name="gridRadios" id="gridRadios1" value="option1">
                            </th>
                            <td>ООО "Колосок"</td>
                            <td>Роспотребнадзор</td>
                            <td>20.12.2009</td>
                            <td>31.12.2009</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <th scope="row"><input type="radio" name="gridRadios" id="gridRadios2" value="option2">
                            </th>
                            <td>ООО "Колосок"</td>
                            <td>Налоговая</td>
                            <td>01.03.2010</td>
                            <td>01.04.2009</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <th scope="row"><input type="radio" name="gridRadios" id="gridRadios3" value="option3">
                            </th>
                            <td>ООО "Колосок"</td>
                            <td>Природнадзор</td>
                            <td>02.02.2010</td>
                            <td>02.03.2009</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <th scope="row"><input type="radio" name="gridRadios" id="gridRadios4" value="option4">
                            </th>
                            <td>ООО "Васильев и Ко"</td>
                            <td>Роспотребнадзор</td>
                            <td>02.03.2009</td>
                            <td>02.06.2010</td>
                            <td>2</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
