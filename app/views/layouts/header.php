<nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top justify-content-end">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <h5>
                    <a href="<?= yii\helpers\Url::to('/') ?>"
                       class="nav-link <?= Yii::$app->request->pathInfo == '' || '/page' ? 'active' : ''; ?>">
                        <i class="fas fa-clipboard-list fa-lg" style="margin-right: 7px;">
                        </i>Перечень плановых проверок
                    </a>
                </h5>
            </li>
            <li class="nav-item">
                <h5>
                    <a href="<?= yii\helpers\Url::to('frigate/addrow') ?>"
                       class="nav-link  <?= Yii::$app->request->pathInfo == 'frigate/addrow' ? 'active' : ''; ?>">
                        <i class="fas fa-plus fa-lg" style="margin-right: 5px;"></i>Добавление проверки
                    </a>
                </h5>
            </li>
            <li class="nav-item">
                <h5>
                    <a href="<?= yii\helpers\Url::to('frigate/info') ?>"
                       class="nav-link <?= Yii::$app->request->pathInfo == 'frigate/info' ? 'active' : ''; ?>">
                        <i class="fas fa-info fa-lg" style="margin-right: 5px;"></i>Справка
                    </a>
                </h5>
            </li>
        </ul>
    </div>

</nav>
