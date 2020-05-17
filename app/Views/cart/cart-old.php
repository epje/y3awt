<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm card-login my-5">
                <div class="card-body card-login">
                    <h2 class="card-title text-center">Your Cart</h2>
                    <h5 class="card-subtitle text-center font-weight-light">Subtotal: &pound;<?= $subtotal; ?></h5>
                    <br/>
                    <?= $table; ?>
                    <div class="row">
                        <div class="col-5">
                            <ul class="list-group">
                                <li class="list-group-item">Subtotal:<kbd class="float-right">&pound;<?= $subtotal; ?></kbd></li>
                                <li class="list-group-item">Tax&nbsp;(<?= 100 * $tax_rate; ?>&percnt;):&nbsp;<kbd class="float-right">&pound;<?= $tax_value; ?></kbd></li>
                                <li class="list-group-item">Grand Total:&nbsp;<kbd class="float-right">&pound;<?= $grand_total; ?></kbd></li>
                            </ul>
                        </div>
                        <div class="col-7">
                            <form action="/cart/checkout" method="post">
                                <div class="form-row">
                                    <button type="submit" class="btn btn-primary">Checkout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

