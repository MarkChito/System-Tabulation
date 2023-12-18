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
        <h1 class="h3 mb-0 text-gray-800">List of Judges Scores</h1>
    </div>

    <?php $judges = $model->mod_get_judge_data() ?>

    <?php if ($judges) : ?>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="sticky-top">
                            <?php foreach ($judges as $key => $judge) : ?>
                                <button class="btn btn-link judge-btn <?= $key === 0 ? 'font-weight-bold' : null ?>" type="button" data-toggle="collapse" data-target="#judge<?= $judge->id ?>" aria-expanded="<?= $key === 0 ? 'true' : 'false' ?>" aria-controls="judge<?= $judge->id ?>">
                                    <?= $judge->name ?>
                                </button>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php $judges = $model->mod_get_judge_data() ?>
                                <?php if ($judges) : ?>
                                    <?php foreach ($judges as $key => $judge) : ?>
                                        <div class="collapse <?= $key === 0 ? 'show' : '' ?>" id="judge<?= $judge->id ?>">
                                            <table class="table table-hover datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Candidate Name</th>
                                                        <?php $categories = $model->mod_get_category_data() ?>
                                                        <?php $event_done = $model->mod_get_event_done_data() ?>
                                                        <?php if ($categories) : ?>
                                                            <?php foreach ($categories as $category) : ?>
                                                                <th class="text-center"><?= $category->name ?></th>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                        <th class="text-center">Total Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $candidates = $model->mod_get_candidate_data() ?>
                                                    <?php if ($candidates) : ?>
                                                        <?php foreach ($candidates as $candidate) : ?>
                                                            <tr>
                                                                <td><?= $candidate->name ?></td>
                                                                <?php if ($categories) : ?>
                                                                    <?php $total_score = 0 ?>
                                                                    <?php foreach ($categories as $category) : ?>
                                                                        <?php $scores = $model->mod_get_candidate_scores($judge->user_id, $candidate->id, $category->id) ?>

                                                                        <td class="text-center"><?= $scores ? number_format((float)$scores[0]->score, 8, '.', '') : "----------" ?></td>

                                                                        <?php $total_score += $scores ? $scores[0]->score : 0 ?>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                                <td class="text-center"><?= number_format((float)($total_score / count($event_done)), 8, '.', '') ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row">
            <div class="col-12">
                <h1>No Data Available</h1>
            </div>
        </div>
    <?php endif ?>
</div>

<?php include_once "footer.php" ?>