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

require_once "model.php";

$model = new Model();

$current_event = $model->mod_get_current_event();

$category_name = "None";

if ($current_event) {
    $categories = $model->mod_get_category_data_by_id($current_event[0]->id);

    $category_name = $categories[0]->name;
}

$pending_events = $model->mod_get_pending_events();

$pending_events_id = [];

if ($pending_events) {
    foreach ($pending_events as $pending_event) {
        array_push($pending_events_id, $pending_event->id);
    }
}

$pending_events_id_string = implode(', ', $pending_events_id);

$candidates = $model->mod_get_candidate_data();
$leading_male_candidate = $model->mod_leading_candidate("Male");
$leading_female_candidate = $model->mod_leading_candidate("Female");

$ave_scores = $model->mod_get_ave_scores();

$maleCandidates = [];
$femaleCandidates = [];

if ($ave_scores) {
    foreach ($ave_scores as $ave_score) {
        $candidates_by_id = $model->mod_get_candidate_data_by_id($ave_score->candidate_id);

        foreach ($candidates_by_id as $candidate_by_id) {
            $candidate_name = $candidate_by_id->name;
            $candidate_sex = $candidate_by_id->sex;
        }

        if ($candidate_sex === "Male") {
            $maleCandidates[] = [
                'name' => $candidate_name,
                'total_score' => number_format($ave_score->total_score, 8),
                'weighted_score' => number_format($ave_score->total_score * 0.3, 8),
            ];
        } elseif ($candidate_sex === "Female") {
            $femaleCandidates[] = [
                'name' => $candidate_name,
                'total_score' => number_format($ave_score->total_score, 8),
                'weighted_score' => number_format($ave_score->total_score * 0.3, 8),
            ];
        }
    }
}
?>

<?php include_once "header.php" ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <?php if ($current_event) : ?>
            <?php if ($category_name != "Finals") : ?>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm px-3" id="btn_change_event" pending_events="<?= $pending_events_id_string ?>" category_name="<?= $category_name ?>" data-toggle="modal" data-target="#change_event_modal">
                    <i class="fas fa-sync fa-sm text-white-50 mr-1"></i>
                    Change Event
                </a>
            <?php else : ?>
                <a href="javascript:void(0)" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm px-3" id="btn_stop_event">
                    <i class="fas fa-stop-circle fa-sm text-white-50 mr-1"></i>
                    Stop Event
                </a>
            <?php endif ?>
        <?php else : ?>
            <a href="javascript:void(0)" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm px-3" id="btn_start_event">
                <i class="fas fa-play-circle fa-sm text-white-50 mr-1"></i>
                Start Event
            </a>
        <?php endif ?>
    </div>

    <div class="row">
        <!-- Current Event -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Current Event
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $category_name ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Leading Male Candidate -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Leading Male Candidate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $leading_male_candidate ? $leading_male_candidate[0]->name : "None" ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-mars fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Leading Female Candidate -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Leading Female Candidate
                            </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                <?= $leading_female_candidate ? $leading_female_candidate[0]->name : "None" ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-venus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Number of Contestants -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Number of Candidates
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $candidates ? count($candidates) : "0" ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Male Candidates -->
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-mars-stroke text-primary mr-1"></i>
                        Male Candidates
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Candidate Name</th>
                                <th>Total Score</th>
                                <th>Rank</th>
                                <th>Total of 30%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $maleRank = 1;
                            foreach ($maleCandidates as $maleCandidate) :
                            ?>
                                <tr>
                                    <td><?= $maleCandidate['name'] ?></td>
                                    <td><?= $maleCandidate['total_score'] ?></td>
                                    <td><?= $maleRank ?></td>
                                    <td><?= $maleCandidate['weighted_score'] ?></td>
                                </tr>
                                <?php $maleRank++ ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Female Candidates -->
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-venus text-danger mr-1"></i>
                        Female Candidates
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Candidate Name</th>
                                <th>Total Score</th>
                                <th>Rank</th>
                                <th>Total of 30%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $femaleRank = 1;
                            foreach ($femaleCandidates as $femaleCandidate) :
                            ?>
                                <tr>
                                    <td><?= $femaleCandidate['name'] ?></td>
                                    <td><?= $femaleCandidate['total_score'] ?></td>
                                    <td><?= $femaleRank ?></td>
                                    <td><?= $femaleCandidate['weighted_score'] ?></td>
                                </tr>
                                <?php $femaleRank++ ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php" ?>