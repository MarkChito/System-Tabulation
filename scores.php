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

if ($_SESSION["user_type"] != "judge") {
    http_response_code(403);
    exit();
}
?>

<?php include_once "header.php" ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List of Scores</h1>
    </div>

    <div class="row">
        <?php $categories = $model->mod_get_category_data() ?>
        <?php if ($categories) : ?>
            <?php foreach ($categories as $category) : ?>
                <?php
                $events = $model->mod_get_event_data($category->id);

                $status = $events[0]->status;

                if ($status == "Pending") {
                    $status_color = "primary";
                }

                if ($status == "Current") {
                    $status_color = "success";
                }

                if ($status == "Done") {
                    $status_color = "danger";
                }
                ?>

                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?= $category->id ?>">
                                            Category Name: <strong><?= $category->name ?></strong>
                                        </button>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <h5 class="float-right text-<?= $status_color ?>"><?= $status ?></h5>
                                </div>
                            </div>
                        </div>
                        <div id="collapse<?= $category->id ?>" class="collapse <?= $status == "Current" ? "show" : null ?>">
                            <div class="card-body">
                                <table class="table table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Candidate Name</th>
                                            <th>Sex</th>
                                            <th>Score</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($category->name == "Finals" && $status != "Pending") {
                                            $candidates = $model->mod_finals();
                                        } else if ($category->name == "Semi-Finals" && $status != "Pending") {
                                            $candidates = $model->mod_semi_finals();
                                        } else {
                                            $candidates = $model->mod_get_candidate_data();
                                        }
                                        ?>
                                        <?php if ($candidates) : ?>
                                            <?php foreach ($candidates as $candidate) : ?>
                                                <?php $scores = $model->mod_get_scores_data($candidate->id, $category->id, $_SESSION["id"]) ?>

                                                <tr>
                                                    <td><?= $candidate->name ?></td>
                                                    <td><?= $candidate->sex ?></td>
                                                    <td><?= $scores ? number_format((float)$scores[0]->score, 8, '.', '') : "0" ?></td>
                                                    <td class="text-center">
                                                        <?php if (!$scores && $status == "Current") : ?>
                                                            <button class="btn btn-success btn-sm btn_set_score" candidate_id="<?= $candidate->id ?>" candidate_name="<?= $candidate->name ?>" category_id="<?= $category->id ?>" judge_id="<?= $_SESSION["id"] ?>">
                                                                <i class="fas fa-edit"></i>
                                                                Set Score
                                                            </button>
                                                        <?php else : ?>
                                                            <?= $status == "Current" ? "Scored" : $status ?>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<?php include_once "footer.php" ?>