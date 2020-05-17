<?php

$session = Config\Services::session();

helper('form');

$message = $session->getFlashdata('message');
$error = $session->getFlashdata('error');

//$errors = $validation->getErrors() ?? [];
// Check if there are any validation errors
$errors = isset($validation) ? $validation->getErrors() : [];

// For dev, show what errors were found.
print_r($errors);

$phoneInputOptions = [
    'class' => 'form-control',
    'id' => 'validationTooltipPhone',
    'placeholder' => 'Enter Phone Number',
    'required' => 'required'
];

$passwordInputOptions = [
    'class' => 'form-control',
    'id' => 'validationTooltipPassword',
    'placeholder' => 'Enter Password',
    'required' => 'required'
];

if (@$errors['phone']) $phoneInputOptions['class'] .= ' is-invalid';
if (@$errors['password']) $passwordInputOptions['class'] .= ' is-invalid';

?>
<style>
    .card-login {
        border-radius: 2rem;
        box-shadow: 0 2rem 2rem 0 rgba(0, 0, 0, 0.1);
    }

    .form-control {
        -webkit-border-radius: 0.5rem;
        -moz-border-radius: 0.5rem;
        border-radius: 0.5rem;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
            <div class="card card-login my-5">
                <div class="card-body card-login">
                    <h2 class="card-title text-center"><?= getenv('app.name'); ?></h2>
                    <h5 class="card-subtitle text-center font-weight-light">Login</h5>
                    <!-- TODO: Fix form validation stuff. -->
                    <?= form_open(base_url('/client/login'), ['class' => 'needs-validation', 'id' => 'login_form'], ['novalidate' => 'novalidate']); ?>
                    <div class="form-group" style="position: relative">
                        <?= form_label('Phone Number', '', ['class' => '', 'for' => 'validationTooltipPhone']) ?>
                        <?= form_input('phone', old('phone') ?? '', $phoneInputOptions); ?>
                        <div class="invalid-tooltip">
                            <?= @$errors['phone'] . '<br/>'; ?>
                        </div>
                        <!-- TODO: Correct validation messages -->
                    </div>
                    <div class="form-group" style="position: relative">
                        <?= form_label('Password', '', ['class' => '', 'for' => 'validationTooltipPhone']) ?>
                        <?= form_password('password', '', $passwordInputOptions); ?>
                        <div class="invalid-tooltip">
                            <?= @$errors['password'] . '<br/>'; ?>
                        </div>
                    </div>
                    <div class="form-group" style="position: relative">
                        <?= form_label('Confirm Password', '', ['class' => '', 'for' => 'validationTooltipPhone']) ?>
                        <?= form_password('password', '', $passwordInputOptions); ?>
                        <div class="invalid-tooltip">
                            <?= @$errors['password'] . '<br/>'; ?>
                        </div>
                    </div>
                    <?= form_submit('submit', 'Login', 'class="btn btn-block btn-primary"'); ?>
                    <?= form_close(); ?>
                    <?php if (filter_var(getenv('app.registrationEnabled'), FILTER_VALIDATE_BOOLEAN)): ?>
                        <hr>
                        <p class="text-center">Don't have an
                            account? <?= anchor('client/register', 'Register!',); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>