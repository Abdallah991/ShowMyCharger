<h1>Register</h1>
<?php  $form = \app\core\forms\Form::begin('','post') ?>
    <?php echo $form->field($model,'firstName')?>
    <?php echo $form->field($model,'lastName')?>
    <?php echo $form->field($model,'email')?>
    <?php echo $form->field($model,'password')->passwordField()?>
    <?php echo $form->field($model,'confirmPassword')->passwordField()?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php  \app\core\forms\Form::end();?>

<!--<form action="" method="post">-->
<!--    <div class="mb-3">-->
<!--        <label  class="form-label">First name</label>-->
<!--        <input type="text" name="firstName" class="form-control" >-->
<!--        <div class="invalid-feedback">-->
<!--            --><?php //echo $model->getFirstError('firstName') ?>
<!--        </div>-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label for="exampleInputEmail1" class="form-label">Last name</label>-->
<!--        <input type="text" name="lastName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->
<!--        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label for="exampleInputEmail1" class="form-label">Email address</label>-->
<!--        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->
<!--        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label for="exampleInputPassword1" class="form-label">Password</label>-->
<!--        <input type="password" name="password" class="form-control" id="exampleInputPassword1">-->
<!--    </div>-->
<!--    <div class="mb-3">-->
<!--        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>-->
<!--        <input type="password" name="confirmPassword" class="form-control" id="exampleInputPassword1">-->
<!--    </div>-->
<!--    <div class="mb-3 form-check">-->
<!--        <input type="checkbox" class="form-check-input" id="exampleCheck1">-->
<!--        <label class="form-check-label" for="exampleCheck1">Check me out</label>-->
<!--    </div>-->
<!--</form>-->