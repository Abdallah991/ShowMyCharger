<?php

use app\core\forms\Form;
use app\models\User;

/** @var $model User **/

$form = new Form();
?>

<h1>Register</h1>

<?php

$form = Form::begin('', 'post') ?>
<div class="row">
    <div class="col">
        <?php echo $form->field($model, 'firstName') ?>
    </div>
    <div class="col">
        <?php echo $form->field($model, 'lastName') ?>
    </div>
</div>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'password')->passwordField() ?>
<?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>

<!--if the user had successfully  registered in the system using valid email and password
and clicked the submit button it will be a success.-->