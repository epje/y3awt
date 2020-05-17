<?php
$session = \Config\Services::session();
$title = getenv('app.name') . ' - ' . $title;


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title; ?></title>
    <meta name="author" content="<?= $author; ?>">
    <meta name="description" content="<?= $description; ?>">
    <meta name="keywords" content="<?= implode(", ", $keywords); ?>"/>
    <meta name="url" content="<?= base_url(); ?>">
    <!--    <meta name="theme-color" content="#4285f4">-->
    <!--    <meta name="subject" content="website's subject">-->
    <!--    <meta name="copyright" content="company name">-->
    <meta name="language" content="EN">
    <meta name="copyright" content="<?= $copyright; ?>">
    <!--    <meta name="category" content="">-->
    <!--    <meta name="distribution" content="Global">-->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e9d80d28ad.js" crossorigin="anonymous"></script>
    <style>
        body {
            /*background: linear-gradient(to right, #f96f5d, #fa897a);*/
            /*background: linear-gradient(to right, #E27D60, #fa897a);*/
        }

        .navbar {
            min-height: 80px;
            background-color: gold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url(); ?>">
            <i class="fas fa-store fa-lg"></i>&nbsp;&nbsp;<?= getenv('app.name') ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a href="/catalog" class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fas fa-book-open fa-lg"></i>&nbsp;&nbsp;Catalog</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/catalog/bathroom"><i class="fas fa-toilet"></i> Bathroom</a>
                        <a class="dropdown-item" href="/catalog/bedroom"><i class="fas fa-bed"></i> Bedroom</a>
                        <a class="dropdown-item" href="/catalog/dining"><i class="fas fa-utensils"></i> Dining</a>
                        <a class="dropdown-item" href="/catalog/kitchen"><i class="fas fa-faucet"></i> Kitchen</a>
                        <a class="dropdown-item" href="/catalog/living"><i class="fas fa-tv"></i> Living</a>
                        <a class="dropdown-item" href="/catalog/office"><i class="fas fa-pen"></i> Office</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/catalog"><i class="fas fa-globe-europe"></i> All</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle fa-lg"></i>&nbsp;&nbsp;Account
                    </a>
                    <?php if ($session->get('loggedIn')): ?>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/client/profile"><i class="fas fa-user-cog"></i>&nbsp;Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/client/logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Log
                                Out</a>
                        </div>
                    <?php else: ?>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/client/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <?php if (filter_var(getenv('app.registrationEnabled'), FILTER_VALIDATE_BOOLEAN)): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/client/register"><i class="fas fa-user-edit"></i>
                                    Register</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </li>
                <?php if ($session->get('loggedIn')): ?>
                    <li class="nav-item">
                        <a class="nav-link"><i class="fas fa-shopping-cart"></i>&nbsp;Cart
                            <span class="badge badge-pill badge-primary">$num</span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

