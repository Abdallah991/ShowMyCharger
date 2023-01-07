<?php

use app\core\forms\Form;
use app\models\User;
/** @var $model User **/

$form = new Form();
?>

<h1>Login</h1>

<?php

$form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'password')->passwordField() ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>

<!--if the user had successfuly logged in the system using valid email and password
and clicked the submit button it will be a success.-->