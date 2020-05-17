<?php


?>


<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Loop Start -->
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" src="../../../public/images/test.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info" onclick="addToCart();">Add
                                </button>
                            </div>
                            <small class="text-muted">£200</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loop End -->
        </div>
    </div>
</div>

<script>
    function addToCart(productID) {
        quantity = 1;
        $.getJSON("/cart/add/" + productID + "/" + quantity);
    }

    //function addToCart(quantity = 1) {
    //
    //    let productID = <?//= $product_id; ?>
    //    return $.getJSON("/cart/add/productID/" + quantity, function (data) {
    //        console.log(data);
    //    });
    //
    //}

    //$.getJSON("/product/id/<?//= $product_id; ?>//", function (data) {
    //
    //    console.log(data);
    //
    //    var products = [];
    //
    //    $.each(data, function (key, val) {
    //        products.push("<li id='" + key + "'>" + val + "</li>");
    //    });
    //
    //    $("<ul/>", {
    //        "class": "my-new-list",
    //        html: products.join("")
    //    }).appendTo("body");
    //});
</script>
