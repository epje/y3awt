<?php
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
                                <label for="inputEmail4">Title</label>
                                <input disabled type="text" class="form-control" value="<?= $client->title; ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputEmail4">First Name</label>
                                <input disabled type="text" class="form-control" value="<?= $client->first_name; ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputPassword4">Last Name</label>
                                <input disabled type="text" class="form-control" value="<?= $client->last_name; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" disabled class="form-control" value="<?= $client->email; ?>">
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
                            <label for="inputAddress">Account Created:</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
