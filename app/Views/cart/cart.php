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
                    <h2 class="card-title text-center">Your Cart</h2>
                    <h5 class="card-subtitle text-center font-weight-light">Subtotal: &pound;<?= $subtotal; ?></h5>
                    <br/>
                    <table class="table table-striped">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td id="product-row"><?= $product->name; ?></td>
                                <td id="product-row"><?= $product->price; ?></td>
                                <td id="product-row">
                                    <div class="input-group">
                                        <input type="number" id="quantity-<?= $product->id; ?>" class="form-control"
                                               min="0" value="<?= $product->quantity; ?>">
                                    </div>
                                </td>
                                <td id="product-row"><?= number_format($product->price * $product->quantity, 2); ?></td>
                                <td id="product-row">
                                    <button type="button" class="btn btn-outline-primary"
                                            onclick="updateProduct(<?= $product->id; ?>)">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="removeProduct(<?= $product->id; ?>)"><i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="row">
                        <div class="col-5">
                            <ul class="list-group">
                                <li class="list-group-item">Subtotal:
                                    <kbd class="float-right">&pound;<?= $subtotal; ?></kbd></li>
                                <li class="list-group-item">Tax&nbsp;(<?= 100 * $tax_rate; ?>&percnt;):&nbsp;
                                    <kbd class="float-right">&pound;<?= $tax_value; ?></kbd></li>
                                <li class="list-group-item">Grand Total:&nbsp;
                                    <kbd class="float-right">&pound;<?= $grand_total; ?></kbd></li>
                            </ul>
                        </div>
                        <div class="col-7">
                            <button class="btn btn-warning " onclick="deleteCart()">Empty&nbsp;<i class="fas fa-cart-arrow-down"></i></button>
                            <form action="/cart/checkout" method="post">
                                <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                                <div class="form-row float-right align-bottom">
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
<script>
    function updateProduct(productID) {
        quantity = $("#quantity-" + productID).val();
        $.getJSON("/cart/update/" + productID + "/" + quantity, function (data) {
            console.log(data);
            switch (data.status) {
                case 200:
                    location.reload();
                    break;
                default:
                    alert("Received Status: " + data.status);
                    break;
            }
        });
    }

    function removeProduct(productID) {
        $.getJSON("/cart/remove/" + productID, function (data) {
            console.log(data);
            switch (data.status) {
                case 200:
                    location.reload();
                    break;
                case 404:
                    alert("Product not found in cart!");
                    break;
                default:
                    alert("An error occurred removing product from cart!");
                    break;
            }
        });
    }

    function deleteCart() {
        $.getJSON("/cart/delete/", function (data) {
            switch (data) {
                case true:
                    location.reload();
                    break;
                case 404:
                    alert("Cart is already empty!");
                    break;
                default:
                    alert("Cart deletion error!");
                    break;
            }
        });
    }
</script>
