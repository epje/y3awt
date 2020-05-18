<?php
use CodeIgniter\I18n\Time;
?>

<style>
    #product-row {
        vertical-align: middle;
    }

    input {
        padding: 0.1em;
        max-width: 4em;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm card-register my-5">
                <div class="card-body card-register">
                    <a href="/client/purchases" class="btn btn-secondary"><i class="fas fa-backward"></i>&nbsp;Back</a>
                    <h2 class="card-title text-center">Purchase - <?= Time::parse($purchase_date)->toLocalizedString('yyyy-MM-dd'); ?></h2>
                    <br/>
                    <table class="table table-striped">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td id="product-row"><?= $product->name; ?></td>
                                <td id="product-row"><?= $product->price; ?></td>
                                <td id="product-row"><?= $product->quantity; ?></td>
                                <td id="product-row"><?= number_format($product->price * $product->quantity, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="row">
                        <div class="col">
                            <ul class="list-group float-right">
                                <li class="list-group-item">Subtotal:
                                    <kbd class="float-right">&pound;<?= $subtotal; ?></kbd></li>
                                <li class="list-group-item">Tax&nbsp;(<?= 100 * $tax_rate; ?>&percnt;):&nbsp;
                                    <kbd class="float-right">&pound;<?= $tax_value; ?></kbd></li>
                                <li class="list-group-item">Grand Total:&nbsp;
                                    <kbd class="float-right">&pound;<?= $grand_total; ?></kbd></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>