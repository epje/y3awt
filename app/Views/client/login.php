<?php

$session = Config\Services::session();

helper('form');

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

if ($session->getFlashdata('phone')) $phoneInputOptions['class'] .= ' is-invalid';
if ($session->getFlashdata('password')) $passwordInputOptions['class'] .= ' is-invalid';

?>
<style>
    .card-login {
        -webkit-border-radius: 1.5em;
        -moz-border-radius: 1.5em;
        border-radius: 1.5em;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
            <div class="card shadow-sm card-login my-5">
                <div class="card-body card-login">
                    <h2 class="card-title text-center"><?= getenv('app.name'); ?></h2>
                    <h5 class="card-subtitle text-center font-weight-light">Login</h5>
                    <!-- TODO: Fix form validation stuff. -->
                    <?= form_open(base_url('/client/login'), ['class' => 'needs-validation', 'id' => 'login_form']); ?>
                    <div class="form-group" style="position: relative">
                        <?= form_label('Phone Number', '', ['class' => '', 'for' => 'validationTooltipPhone']) ?>
                        <? //old input, now with span. //= form_input('phone', old('phone') ?? '', $phoneInputOptions); ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+44</span>
                            </div>
                            <input type="number" name="phone" value="<?= old('phone') ?? ''; ?>"
                                   class="<?= $phoneInputOptions['class']; ?>" id="validationTooltipPhone"
                                   placeholder="7700123456" required="required"/>
                            <div class="invalid-feedback">
                                <?= $session->getFlashdata('phone') . '<br/>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="position: relative">
                        <?= form_label('Password', '', ['class' => '', 'for' => 'validationTooltipPhone']) ?>
                        <?= form_password('password', '', $passwordInputOptions); ?>
                        <div class="invalid-feedback">
                            <?= $session->getFlashdata('password') . '<br/>'; ?>
                        </div>
                    </div>
                    <?= form_submit('submit', 'Login', 'class="btn btn-block btn-primary"'); ?>
                    <?= form_close(); ?>
                    <?php if (filter_var(getenv('app.registrationEnabled'), FILTER_VALIDATE_BOOLEAN)): ?>
                        <hr>
                        <p class="text-center">Don't have an
                            account? <?= anchor('client/register', 'Register!',); ?></p>
                    <?php endif; ?>
                    <?php if ($session->has('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Woo!</strong> <?= $session->getFlashdata('message'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
