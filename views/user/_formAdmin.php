<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
  
    <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
  
    <?= $form->field($model, 'cPassword')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'status')->dropDownList(
            User::getStatusList()           // Flat array ('id'=>'label')
            //['prompt'=>'']    // options
        ); ?>

    <!-- operators assigned to this admin -->
    <?php
      $selectedOperators = ArrayHelper::map($model->assignedOperators, 'id', 'operator_id');
      if($model->type == 'admin') {
    ?>
      
      <div class="form-group field-user-status required">
        <label for="user-status" class="control-label">Operators</label>
        
        <select multiple name="User[operators][]" class="form-control">
          <?php foreach(User::getAllOperators() as $id => $name) { ?>
          <option value="<?php echo $id; ?>" <?php echo(in_array($id, $selectedOperators) ? 'selected' : '') ?>><?php echo $name; ?></option>
          <?php } ?>
        </select>
        
        <div class="help-block"></div>
      </div>
    
    <?php
      }
    
    ?>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
