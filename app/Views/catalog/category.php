<?php
$session = Config\Services::session();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.7/holder.js"></script>
<style>
    .coloured {
        color: goldenrod;
    }

    .card {
        /* Added */
        float: none; /* Added */
        /* Added */
        margin: 0 auto 10px;
    }

    @media (min-width: 34em) {
        .card-columns {
            -webkit-column-count: 1;
            -moz-column-count: 1;
            column-count: 1;
        }
    }

    @media (min-width: 48em) {
        .card-columns {
            -webkit-column-count: 2;
            -moz-column-count: 2;
            column-count: 2;
        }
    }

    @media (min-width: 62em) {
        .card-columns {
            -webkit-column-count: 2;
            -moz-column-count: 2;
            column-count: 2;
        }
    }

    @media (min-width: 75em) {
        .card-columns {
            -webkit-column-count: 3;
            -moz-column-count: 3;
            column-count: 3;
        }
    }
</style>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center my-lg-1 my-5">
                <div>
                    <h1>Catalog<?= ' - ' . ucfirst($category); ?></h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card-columns">
                    <!-- Loop Start -->
                    <?php foreach (@$products as $product): ?>
                        <div class="card border-secondary bg-light mb-4 shadow-sm">
                            <h5 class="card-header"><?= $product->name; ?>
                                <span class="badge badge-light text-muted float-right">
                                    <a href="/catalog/<?= $product->category; ?>">
                                        <?= ucfirst($product->category); ?>
                                    </a>
                                </span>
                            </h5>
                            <div class="card-body">
                                <h7 class="card-subtitle mb-2 text-muted">Rating -
                                    <?php $goldStars = 0; ?>
                                    <?php for ($goldStars; $goldStars < $product->rating; $goldStars++): ?>
                                        <span class="fas fa-star coloured"></span>
                                    <?php endfor; ?>
                                    <?php for ($emptyStars = 0; $emptyStars < (5 - $goldStars); $emptyStars++): ?>
                                        <span class="far fa-star"></span>
                                    <?php endfor; ?>
                                </h7>
                                <?php if ($product->img): ?>
                                    <hr/>
                                    <a href="/catalog/<?= $product->id; ?>">
                                        <img class="card-img-top"
                                             src="/images/<?= $product->img; ?>"
                                             alt="Product Image">
                                    </a>
                                <?php else: ?>
                                    <hr/>
                                    <a href="/catalog/<?= $product->id; ?>">
                                        <img class="card-img-top"
                                             data-src="holder.js/300x250?auto=yes&text=<?= $product->name; ?>"
                                             alt="<?= $product->name; ?>">
                                    </a>
                                <?php endif; ?>
                                <hr/>
                                <p class="card-text"><?= $product->description; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn btn-outline-secondary" href="/catalog/<?= $product->id; ?>"><i
                                                    class="fas fa-eye"></i> View</a>
                                        <?php if ($session->get('loggedIn')): ?>
                                            <button type="button" class="btn btn-outline-success"
                                                    id="addButton-<?= $product->id; ?>"
                                                    onclick="addToCart(<?= $product->id; ?>);"><i
                                                        class="fas fa-cart-plus"></i> Add
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <h4 class="text-success"><kbd>&pound;<?= $product->price; ?></kbd></h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Loop End -->
                </div>
                <!--                <nav aria-label="Page navigation example">-->
                <!--                    <ul class="pagination justify-content-center">-->
                <!--                        <li class="page-item disabled">-->
                <!--                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>-->
                <!--                        </li>-->
                <!--                        <li class="page-item"><a class="page-link" href="?page=1">1</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="?page=2">2</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="?page=3">3</a></li>-->
                <!--                        <li class="page-item">-->
                <!--                            <a class="page-link" href="">Next</a>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                </nav>-->
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
<script>
    function addToCart(productID) {
        quantity = 1;
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
    }
</script>
