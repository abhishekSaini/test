<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Operator', ['create-operator'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
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
                    return '/user/update-operator?id='.$model->id;
                  else if($action == 'view')
                    return '/user/view-operator?id='.$model->id;
                  else
                    return '/user/'.$action.'?id='.$model->id.'&type=operators';
                }
            ],
        ],
    ]); ?>

</div>
