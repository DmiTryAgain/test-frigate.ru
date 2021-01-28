<?php

/* @var $this yii\web\View */


$this->title = Yii::$app->name;

?>
<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-10">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Справка</h1>
                    <h5>Здравствуйте! Пожалуйста, ознакомьтесь с данной справкой, и следуйте этим рекомендациям по
                        использованию данного WEB приложения! Спасибо!</h5>
                    <ul>
                        <li class="lead">Чтобы поспользоваться поиском, необходимо ввести в соответствующие поля
                            информацию, которую хотите найти. При использовании поиска не обязательно заполнять все
                            поля. Дату необходимо вводить в формате дд.мм.гггг (дата.месяц.год). Затем нажмите на кнопку
                            "Поиск", в таблице увидете результаты поиска.
                        </li>
                        <li class="lead">Чтобы добавить одну запись в таблицу, перейдите на вкладку "Добавление
                            проверки" или нажмите на кнопку "Дополнительные действия" -> "Добавить". Откроется страница
                            с полями для ввода данных в таблицу. Необходимо заполнить все поля и нажать на кнопку
                            "Добавить". Дату следует вводить в том же формате, о котором было сказано выше. Если СМП
                            и/или контролирующий орган был занеён в таблицу ранее, из выпадающего списка Вам будет
                            предложено выбрать внесённые ранее данные. Выберете нужное значение, или введите новое.
                            После добавления новые данные будут доступны для выбора. Если все данные введены корректно,
                            нажмите на кнопку "Добавить", и Вы увидете сообщение об успешном добавлении записи. Если
                            данные введены некорректно, рядом с полями, где произошла ошибка, выведется текст ошибки.
                        </li>
                        <li class="lead">Чтобы добавить много записей сразу, можно выполнить импорт данных из CSV файла.
                            Этот файл неоходимо заблаговременно создать и заполнить данными следующим образом:
                        </li>
                        <li class="lead">в первом столбце должны быть записаны наименования СМП, во втором -
                            контролирующие органы, в третьем - дата начала проверки в формате, о котором сказано выше, в
                            четвёртом - дата окончания проверки, в пятом - плановая длительность проверки. <b>Заголовок
                                добавлять НЕ НУЖНО!</b></li>
                        <li class="lead">Чтобы создать такой файл, необходимо открыть Microsoft Excell, ввести данные,
                            как было сказано выше, сохранить как CSV (разделители - запятые). После того, как файл будет
                            сохранён, закройте его и перейдите на вкладку "Добавление проверки". В правой нижней части
                            Вы увидете поле для загрузки файла. Нажмите на него, и загрузите файл, который Вы сохранили.
                            После этого нажмите на кнопку "Импорт из CSV". Если в файле все данные были указаны
                            корректно, Вы увидете сообщение об успехе. В противном случае, выведется ошибка с данными из
                            строки, где эти данные не соответствуют нужному формату. Данные, которые находились выше,
                            успешно запишутся в таблицу, а данные с ошибкой и всё, что ниже - нет. Вы можете исправить
                            файл, указав корректные данные, стереть всё, что было выше строки, которая вызвала ошибку,
                            сохранить, закрыть и попробовать ещё раз.
                        </li>
                        <li class="lead">Чтобы сделать экспорт данных из таблицы, необходимо на главной странице нажать
                            на кнопку "Дополнительные действия" -> "Экспортировать найденное в CSV". Если до экспорта
                            был выполнен поиск, то экспортируются только результаты поиска. Если поиск не использовался,
                            то таблица будет экспортирована целиком.
                        </li>
                        <li class="lead">Чтобы удалить отдельную запись из таблицы, отметьте её, нажав на поле выбора в
                            первом столбце таблицы, а затем нажмите на кнопку "Дополнительные действия" -> "Удалить
                            отмеченное". После этого запись из таблицы будет удалена.
                        </li>
                        <li class="lead">Чтобы редактировать отдельную запись из таблицы, отметьте её, нажав на поле
                            выбора в первом столбце таблицы, а затем нажмите на кнопку "Дополнительные действия" ->
                            "Редактировать отмеченное". После этого откроется страница с полями, заполненными записью,
                            которую Вы хотите отредактировать. После редактирования нажмите на кнопку "Сохранить". Если
                            введены корректные данные, эта запись в таблице будет отредактирована, и Вы получите
                            сообщение об успешном редактировании.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
