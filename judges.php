<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    $_SESSION["alert"] =  array(
        "title" => "Oops...",
        "message" => "You must login first!",
        "type" => "error"
    );

    header("location: ./");
    exit();
}

if ($_SESSION["user_type"] != "admin") {
    http_response_code(403);
    exit();
}
?>

<?php include_once "header.php" ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List of Judges</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm px-3" data-toggle="modal" data-target="#new_judge_modal">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i>
            New Judge
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Birthday</th>
                                <th>Sex</th>
                                <th>Username</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $judges = $model->mod_get_judge_data() ?>
                            <?php if ($judges) : ?>
                                <?php foreach ($judges as $judge) : ?>
                                    <tr>
                                        <td><?= $judge->name ?></td>
                                        <td><?= $judge->mobile_number ?></td>
                                        <td><?= date("F j, Y", strtotime($judge->birthday)) ?></td>
                                        <td><?= $judge->sex ?></td>
                                        <td>
                                            <?php $user_accounts = $model->mod_get_userdata($judge->user_id) ?>
                                            <?= $user_accounts[0]->username ?>
                                        </td>
                                        <td class="text-muted">********************</td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php" ?>