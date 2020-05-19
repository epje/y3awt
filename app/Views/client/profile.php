<?php

use CodeIgniter\I18n\Time;

$time = Time::parse($client->created_at);

?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-7 mx-auto">
            <div class="card shadow-sm card-register my-5">
                <div class="card-body card-register">
                    <h2 class="card-title text-center"><i class="fas fa-user-circle fa-3x"></i></h2>
                    <h3 class="card-title text-center">Your Profile</h3>
                    <h5 class="card-subtitle text-muted text-center"><?= 'Hi, ' . $client->first_name . '!' ?></h5>
                    <hr/>
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="title">Title</label>
                                <input disabled type="text" class="form-control" id="title" value="<?= $client->title; ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="first_name">First Name</label>
                                <input disabled type="text" class="form-control" id="first_name" value="<?= $client->first_name; ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="last_name">Last Name</label>
                                <input disabled type="text" class="form-control" id="last_name" value="<?= $client->last_name; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input disabled type="email" class="form-control" id="email"
                                       value="<?= $client->email; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phoneField">Phone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">+44</span>
                                    </div>
                                    <input disabled type="text" value="<?= $client->phone; ?>"
                                           class="form-control" id="phoneField"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Account Created:</label>
                            <input disabled type="text" class="form-control" id="created_at"
                                   value="<?= $time->toLocalizedString('dd-MM-yyyy') . ' at ' . $time->toTimeString(); ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
