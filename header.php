<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "model.php";

$model = new Model();

$userdata = $model->mod_get_userdata($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>System Tabulation<?= $_SESSION["current_tab"] ?></title>

    <link rel="shortcut icon" href="./dist/img/favicon.ico" type="image/x-icon">

    <link href="./dist/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="./dist/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="./dist/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="./dist/css/style.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="./dist/img/logo-transparent.png" alt="logo" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
                <div class="sidebar-brand-text mx-3">System Tabulation</div>
            </a>
            <hr class="sidebar-divider my-0">
            <?php if ($_SESSION["user_type"] == "admin") : ?>
                <li class="nav-item <?= $_SESSION["current_tab"] == " - Dashboard" ? "active" : null ?>">
                    <a class="nav-link" href="javascript:void(0)" id="btn_dashboard">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item <?= $_SESSION["current_tab"] == " - List of Judges Scores" ? "active" : null ?>">
                    <a class="nav-link" href="javascript:void(0)" id="btn_judges_scores">
                        <i class="fas fa-chart-bar"></i>
                        <span>Judges Scores</span>
                    </a>
                </li>
            <?php endif ?>
            <?php if ($_SESSION["user_type"] == "judge") : ?>
                <li class="nav-item <?= $_SESSION["current_tab"] == " - List of Scores" ? "active" : null ?>">
                    <a class="nav-link" href="javascript:void(0)" id="btn_scores">
                        <i class="fas fa-chart-bar"></i>
                        <span>Scores</span>
                    </a>
                </li>
            <?php endif ?>
            <?php if ($_SESSION["user_type"] == "admin") : ?>
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Administration
                </div>
                <li class="nav-item <?= $_SESSION["current_tab"] == " - List of Judges" ? "active" : null ?>">
                    <a class="nav-link" href="javascript:void(0)" id="btn_manage_judges">
                        <i class="fas fa-gavel"></i>
                        <span>Judges</span>
                    </a>
                </li>
                <li class="nav-item <?= $_SESSION["current_tab"] == " - List of Candidates" ? "active" : null ?>">
                    <a class="nav-link" href="javascript:void(0)" id="btn_manage_candidates">
                        <i class="fas fa-user-friends"></i>
                        <span>Candidates</span>
                    </a>
                </li>
                <li class="nav-item <?= $_SESSION["current_tab"] == " - List of Categories" ? "active" : null ?>">
                    <a class="nav-link" href="javascript:void(0)" id="btn_manage_categories">
                        <i class="fas fa-list-alt"></i>
                        <span>Categories</span>
                    </a>
                </li>
            <?php endif ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Account
            </div>
            <li class="nav-item">
                <a class="nav-link btn_logout" href="javascript:void(0)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle mr-2" src="./dist/img/default_user.png">
                                <span class="d-none d-lg-inline text-gray-600 small"><?= $userdata[0]->name ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item under_maintenance" href="javascript:void(0)">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item under_maintenance" href="javascript:void(0)">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item under_maintenance" href="javascript:void(0)">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item btn_logout" href="javascript:void(0)">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>