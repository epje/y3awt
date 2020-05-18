<?php

use CodeIgniter\I18n\Time;

?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm card-register my-5">
                <div class="card-body card-register">
                    <h2 class="card-title text-center">Your Purchases</h2>
                    <hr/>
                    <?php foreach ($purchases as $purchase): ?>
                        <div class="list-group list-group-flush">
                            <a href="/client/purchases/<?= $purchase->id; ?>"
                               class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><strong><?= Time::parse($purchase->created_at, 'UTC')->toLocalizedString('yyyy-MM-dd'); ?></strong></h5>
                                    <small><?= Time::parse($purchase->created_at)->humanize();; ?></small>
                                </div>
                                <br>
                                <small class="float-right">Status:&nbsp;<?= ucfirst($purchase->status); ?></small>
                                <p>Grand Total: <kbd>&pound;<?= $purchase->grand_total; ?></kbd></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
