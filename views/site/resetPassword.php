<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Forgot Password';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

<?php if(!$success) { ?>    
    
    <?php if($model->hasErrors('id')) { ?>
    <div style="color: red;"><?php echo $model->getErrors('id')[0]; ?></div>
    <?php } ?>
    
    <p>Please enter your new password below:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'reset-password-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'cPassword')->passwordInput() ?>
    
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'reset-password-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

<?php }else { ?>
    
    <div>
      <p>Password reset successfully!</p>
    </div>
    
<?php } ?>
    
</div>
