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
        <h1 class="h3 mb-0 text-gray-800">List of Candidates</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm px-3" data-toggle="modal" data-target="#new_candidate_modal">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i>
            New Candidate
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
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $candidates = $model->mod_get_candidate_data() ?>
                            <?php if ($candidates) : ?>
                                <?php foreach ($candidates as $candidate) : ?>
                                    <tr>
                                        <td><?= $candidate->name ?></td>
                                        <td><?= $candidate->mobile_number ?></td>
                                        <td><?= date("F j, Y", strtotime($candidate->birthday)) ?></td>
                                        <td><?= $candidate->sex ?></td>
                                        <td><?= $candidate->address ?></td>
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