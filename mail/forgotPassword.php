<?php 

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div>
  Hi <?php echo $user->first_name; ?>, <br/><br/>
  
  We have received a request to reset your password. Please click the link below to reset your password.<br/>
  
  <?php echo Html::a('Reset Password', Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password/'.$user->authKey])); ?><br/><br/>
  
  Best Regards,
  
</div>