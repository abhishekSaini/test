<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            [
                'label' => 'Admin Users', 'url' => ['/admin-users'],
                'items' => [
                      ['label' => 'Manage', 'url' => '/admin-users'], //'url' => '/admin-users'
                      ['label' => 'Create New', 'url' => '/user/create-admin'], //'url' => '/user/create-admin'
                 ],
                'visible' => Yii::$app->user->identity->type == 'admin'
            ],
            [
                'label' => 'Operators', 'url' => ['/operators'],
                'items' => [
                      ['label' => 'Manage', 'url' => '/operators'],
                      ['label' => 'Create New', 'url' => '/user/create-operator'],
                 ],
                'visible' => Yii::$app->user->identity->type == 'admin'
            ],
            [
                'label' => 'Channels', 'url' => ['/channels'],
                'items' => [
                      ['label' => 'Manage', 'url' => '/channels'],
                      ['label' => 'Create New', 'url' => '/channels/create'],
                 ],
            ],
            [
                'label' => 'Meetings', 'url' => ['/meetings'],
                'items' => [
                      ['label' => 'Manage', 'url' => '/meetings'],
                      ['label' => 'Create New', 'url' => '/meetings/create'],
                 ],
            ],
            //['label' => 'Contact', 'url' => ['/site/contact']],
            
            [
                'label' => 'Logout (' . Yii::$app->user->identity->first_name . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ]
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
