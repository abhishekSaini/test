<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index table-responsive">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Admin User', ['create-admin'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'password',
            'first_name',
            'last_name',
            'email:email',
            // 'authKey',
            // 'status',
            // 'type',
            // 'data_created',
            // 'date_updated',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                  
                  if($action == 'update')
                    return \Yii::$app->urlManager->createUrl('/user/update-admin?id='.$model->id);
                  else if($action == 'view')
                    return \Yii::$app->urlManager->createUrl('/user/view-admin?id='.$model->id);
                  else
                    return \Yii::$app->urlManager->createUrl('/user/'.$action.'?id='.$model->id.'&type=admin-users');
                }
            ],
        ],
    ]); ?>

</div>
