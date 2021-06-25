<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard

* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title><?=((isset($ui_title))? $ui_title : '')?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?=site_url('LPNU LOGO XS.png')?>" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="<?=site_url('lib/fontawesome-free-5.14.0-web/css/all.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?=site_url('lib/argon-dashboard')?>/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="<?=site_url('lib/argon-dashboard')?>/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?=site_url('lib/argon-dashboard')?>/css/argon.css?v=1.2.0" type="text/css">
</head>

<body class="bg-default">
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-success py-4 py-lg-5 pt-lg-6">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <img src="<?=site_url($konfigurasi['APP_LOGO']['value_text'])?>" style="height: 150px">
                            <h1 class="bg-dark text-white mt-4 pt-2 mb-0">Selamat Datang Admin!</h1>
                            <p class="bg-dark text-lead text-white pb-2">Silahkan masuk untuk mengelola sistem.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="<?=site_url('login')?>" method="post">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control text-dark" placeholder="Username" name="username" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input class="form-control text-dark" placeholder="Password" name="password" type="password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Sign in</button>
                                </div>
                                <?php 
                                    if (session()->getFlashdata('admin_message')) {
                                ?>
                                <div class="text-center text-xs font-weight-bold text-danger">
                                    <?=session()->getFlashdata('admin_message')?>
                                </div>
                                <?php 
                                    }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="pb-5" id="footer-main">
        <div class="container">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <img src="<?=site_url($konfigurasi['APP_LOGO_FOOTER']['value_text'])?>" alt="" class="img-thumbnail">
                        </div>
                        <div class="col pl-0" style="line-height: 20px;">
                            <div class="copyright text-center text-xl-left text-white" style="font-family: 'Montserrat', sans-serif; font-size: 14pt; line-height: 21px;">
                                <?=$konfigurasi['APP_FOOTER_JUDUL']['value']?>
                            </div>
                            <span class="text-white font-weight-bold" style="color: #adadad !important; font-size: 11pt;">
                                <?=$konfigurasi['APP_FOOTER_SUBJUDUL']['value']?>
                            </span><br/>
                             <span class="text-white" style="color: #adadad !important; font-size: 9pt;">
                                <?=$konfigurasi['APP_FOOTER_COPYRIGHT']['value_text']?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                        <?php 
                        if (empty($ui_navbar)) {
                            $ui_navbar = [
                                "Menu #1|fas fa-home|#",
                                "Menu #2|fas fa-list|#",
                                "Dropdown #3" => [
                                    "Sub #1|fab fa-facebook|https://www.facebook.com/",
                                    "Sub #2|fab fa-twitter|https://www.twitter.com/",
                                    "Sub #3|fab fa-instagram|https://www.instagram.com/"
                                ],
                                "Menu #4|fas fa-chart-line|#",
                            ];
                        }
                        else {
                            if (!is_array($ui_navbar)) {
                                $ui_navbar = [
                                    "Menu #1|fas fa-home|#",
                                    "Menu #2|fas fa-list|#",
                                    "Dropdown #3" => [
                                        "Sub #1|fab fa-facebook|https://www.facebook.com/",
                                        "Sub #2|fab fa-twitter|https://www.twitter.com/",
                                        "Sub #3|fab fa-instagram|https://www.instagram.com/"
                                    ],
                                    "Menu #4|fas fa-chart-line|#",
                                ];
                            }
                        }

                        foreach ($ui_navbar as $navbar => $child) {
                            if (is_numeric($navbar)) {
                                $navbar = explode('|', $child);
                                $navbar_text = $navbar[0];
                                $navbar_icon = $navbar[1];
                                $navbar_link = $navbar[2];

                                if ($navbar_text == '-') {
                                    $padding = 'pr-0 text-center text-lg-left';
                                    $navbar_text = '';
                                }
                                else {
                                    $padding = '';
                                }
                    ?>
                    <li class="nav-item">
                        <a href="<?=$navbar_link?>" class="nav-link text-white <?=$padding?>"><i style="position: relative; top: 0px" class="mr-2 <?=$navbar_icon?>" style="position: relative; top: 2px"></i> <?=$navbar_text?></a>
                    </li>
                    <?php 
                            }
                            else {
                                $navbar_toggle = explode('|', $navbar);
                                $navbar_toggle_text = $navbar_toggle[0];
                                $navbar_toggle_icon = $navbar_toggle[1];
                    ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link text-white" data-toggle='dropdown'><i style="position: relative; top: 0px" class="mr-2 <?=$navbar_toggle_icon?>"></i> <?=$navbar_toggle_text?></a>
                        <ul class="dropdown-menu">
                            <?php
                                foreach ($child as $navbar) {
                                    $navbar = explode('|', $navbar);
                                    $navbar_text = $navbar[0];
                                    $navbar_icon = $navbar[1];
                                    $navbar_link = $navbar[2];
                            ?>
                            <li class="dropdown-item">
                                <a class="dropdown-link" href="<?=$navbar_link?>">
                                    <i style="position: relative; top: 0px" class="mr-2 <?=$navbar_icon?>"></i>
                                    <?=$navbar_text?>
                                </a>
                            </li>
                            <?php 
                                }
                            ?>
                        </ul>
                    </li>
                    <?php 
                            }
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?=site_url('lib/argon-dashboard')?>/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?=site_url('lib/argon-dashboard')?>/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=site_url('lib/argon-dashboard')?>/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?=site_url('lib/argon-dashboard')?>/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?=site_url('lib/argon-dashboard')?>/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Argon JS -->
    <script src="<?=site_url('lib/argon-dashboard')?>/js/argon.js?v=1.2.0"></script>
</body>

</html>