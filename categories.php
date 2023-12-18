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
        <h1 class="h3 mb-0 text-gray-800">List of Categories</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm px-3" data-toggle="modal" data-target="#new_category_modal">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i>
            New Category
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
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $categories = $model->mod_get_category_data() ?>
                            <?php if ($categories) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <td><?= $category->name ?></td>
                                        <td><?= $category->description ?></td>
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