<?php

use CodeIgniter\I18n\Time;

?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm card-login my-5">
                <div class="card-body card-login">
                    <h2 class="card-title text-center">Your Purchases</h2>
                    <hr/>
                    <?php foreach ($purchases as $purchase): ?>
                        <div class="list-group list-group-flush">
                            <a href="/purchase/<?= $purchase->id; ?>"
                               class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Purchase #<?= $purchase->id; ?></h5>
                                    <small><?= Time::parse($purchase->created_at)->humanize();; ?></small>
                                </div>
                                <p class="mb-1">Product Quantity:&nbsp;<?= $purchase->prodQuantity; ?></p>
                                <small class="float-right">Status:&nbsp;<?= ucfirst($purchase->status); ?></small>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
