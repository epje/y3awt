<?php
use CodeIgniter\Config\Services;
$session = Services::session();
?>
<style>
    .coloured {
        color: goldenrod;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.7/holder.js"></script>
<div class="container py-5">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="card-body">
                            <?php if ($product->img): ?>
                                <a href="/catalog/<?= $product->id; ?>">
                                    <img class="card-img-top"
                                         src="/images/<?= $product->img; ?>"
                                         alt="Product Image">
                                </a>
                            <?php else: ?>
                                <a href="/catalog/<?= $product->id; ?>">
                                    <img class="card-img-top"
                                         data-src="holder.js/300x300?auto=yes&text=<?= $product->name; ?>"
                                         alt="<?= $product->name; ?>">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="card-body">
                            <h3 class="card-title"><strong><?= $product->name; ?></strong></h3>
                            <hr/>
                            <h5 class="card-subtitle">
                                <strong>Rating:</strong>
                                <?php $goldStars = 0; ?>
                                <?php for ($goldStars; $goldStars < $product->rating; $goldStars++): ?>
                                    <span class="fas fa-star coloured"></span>
                                <?php endfor; ?>
                                <?php for ($emptyStars = 0; $emptyStars < (5 - $goldStars); $emptyStars++): ?>
                                    <span class="far fa-star"></span>
                                <?php endfor; ?>
                            </h5>
                            <br/>
                            <h5 class="card-subtitle">
                                <strong>Price</strong>:&nbsp;<kbd>&pound;<?= $product->price; ?></kbd></h5>
                            <br/>
                            <h5 class="card-subtitle"><strong>Description:</strong></h5>
                            <p class="card-text"><?= $product->description; ?></p>
                            <?php if ($session->get('loggedIn')): ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="number" id="productQuantity" class="form-control"
                                                   min="1" value="1">
                                        </div>
                                        <div class="col-8">
                                            <div class="btn-group">
                                                <button type="button" id="addButton-<?= $product->id; ?>"
                                                        class="btn btn-outline-success"
                                                        onclick="addToCart(<?= $product->id; ?>);">Add <i
                                                            class="fas fa-cart-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
<script>
    function addToCart(productID) {
        quantity = parseInt($('#productQuantity').val());
        if (Number.isInteger(quantity)) {
            $.getJSON("/cart/add/" + productID + "/" + quantity, function (data) {
                console.log(data);
                switch (data.status) {
                    case 200:
                        $("#addButton-" + productID).html("Added").prop("disabled", true);
                        setTimeout(function () {
                            $("#addButton-" + productID).html("<i class=\"fas fa-cart-plus\"></i> Add").prop("disabled", false);
                        }, 1000);
                        break;
                    case 404:
                        alert("Product not found!");
                        break;
                    default:
                        break;
                }
            });
        } else {
            alert("Please only use a number!");
        }

    }
</script>
