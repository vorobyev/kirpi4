<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Идеал Микс',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role == 1)?['label' => '<span class ="glyphicon glyphicon-book" ></span> Справочники', 
            'encodeLabels' => false,
            'items' => [
                    ['label' => 'Готовые продукты', 'url' => ['/product']],
                    ['label' => 'Единицы измерения', 'url' => ['/measure']],
                    ['label' => 'Ингредиенты', 'url' => ['/ingredient']],
                    ['label' => 'Рецептуры', 'url' => ['/recipe']],
                    ['label' => 'Транспорт', 'url' => ['/transport']]
                ]
            ]:"",
        (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role == 1)?['label' => '<span class ="glyphicon glyphicon-stats" ></span> Отчеты', 
            'items' => [
                    ['label' => 'Использованные ингредиенты за период', 'url' => ['/report/job_period']],
                ]
            ]:"",
        (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role == 1)?['label'=>''
                .Html::button(
                    'Задачи',
                    ['class' => 'btn btn-primary btn-outline','name'=>'task']
                ),
                'url'=>['/task'],
                'encode'=>false,
                'options'=>[
                    'class'=>'hidden-xs my-form'
                ]
            ]:"",
    ];
    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '<span class ="glyphicon glyphicon-user" ></span> Войти', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '<span class ="glyphicon glyphicon-log-out"></span> Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink'=>['label'=>'Главная','url'=>Url::to(['/site/index'])]
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ООО «Идеал Микс» <?= date('Y') ?></p>

        <p class="pull-right"><?= Html::a('Наш сайт','http://idealmix.ru')." | ".Html::a('<span class ="glyphicon glyphicon-console" style="sont-size:14pt"></span>',['site/develop'])?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
