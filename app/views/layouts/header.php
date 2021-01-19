<nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top justify-content-end">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?= Yii::$app->request->pathInfo == '' ? 'active' : ''; ?>">
                <a href="<?= yii\helpers\Url::to('/') ?>" class="nav-link ">
                    <h5>
                        <i class="fas fa-clipboard-list fa-lg" style="margin-right: 7px;">
                        </i>Перечень плановых проверок
                    </h5>
                </a>
            </li>
            <li class="nav-item  <?= Yii::$app->request->pathInfo == 'frigate/addrow' ? 'active' : ''; ?>">
                <a href="<?= yii\helpers\Url::to('frigate/addrow') ?>" class="nav-link">
                    <h5>
                        <i class="fas fa-plus fa-lg" style="margin-right: 5px;"></i>Добавление проверки
                    </h5>
                </a>
            </li>
            <li class="nav-item <?= Yii::$app->request->pathInfo == 'frigate/info' ? 'active' : ''; ?>">
                <a href="<?= yii\helpers\Url::to('frigate/info') ?>" class="nav-link">
                    <h5>
                        <i class="fas fa-info fa-lg" style="margin-right: 5px;"></i>Справка
                    </h5>
                </a>
            </li>
        </ul>
    </div>

</nav>
