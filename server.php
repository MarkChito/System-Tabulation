<?php
require_once "model.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Manila');

class Server
{
    function __construct()
    {
        $this->model = new Model();

        if (isset($_POST["dashboard"])) {
            $this->dashboard();
        }

        if (isset($_POST["judges_scores"])) {
            $this->judges_scores();
        }

        if (isset($_POST["manage_judges"])) {
            $this->manage_judges();
        }

        if (isset($_POST["manage_candidates"])) {
            $this->manage_candidates();
        }

        if (isset($_POST["manage_categories"])) {
            $this->manage_categories();
        }

        if (isset($_POST["login"])) {
            $this->login();
        }

        if (isset($_POST["new_judge"])) {
            $this->new_judge();
        }

        if (isset($_POST["new_candidate"])) {
            $this->new_candidate();
        }

        if (isset($_POST["new_category"])) {
            $this->new_category();
        }

        if (isset($_POST["set_score"])) {
            $this->set_score();
        }

        if (isset($_POST["get_next_event"])) {
            $this->get_next_event();
        }

        if (isset($_POST["start_event"])) {
            $this->start_event();
        }
        
        if (isset($_POST["stop_event"])) {
            $this->stop_event();
        }
        
        if (isset($_POST["change_event"])) {
            $this->change_event();
        }

        if (isset($_POST["logout"])) {
            $this->logout();
        }
    }

    private function dashboard()
    {
        $_SESSION["current_tab"] =  " - Dashboard";

        echo json_encode(true);
    }

    private function judges_scores()
    {
        $_SESSION["current_tab"] =  " - List of Judges Scores";

        echo json_encode(true);
    }

    private function manage_judges()
    {
        $_SESSION["current_tab"] =  " - List of Judges";

        echo json_encode(true);
    }

    private function manage_candidates()
    {
        $_SESSION["current_tab"] =  " - List of Candidates";

        echo json_encode(true);
    }

    private function manage_categories()
    {
        $_SESSION["current_tab"] =  " - List of Categories";

        echo json_encode(true);
    }

    private function login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user_data = $this->model->mod_login($username, $password);

        if ($user_data) {
            $id = $user_data[0]->id;
            $user_type = $user_data[0]->user_type;

            $_SESSION["id"] = $id;
            $_SESSION["user_type"] = $user_type;

            $_SESSION["alert"] =  array(
                "title" => "Success!",
                "message" => "Login Successful!",
                "type" => "success"
            );
        } else {
            $_SESSION["alert"] =  array(
                "title" => "Oops...",
                "message" => "Invalid Username or Password",
                "type" => "error"
            );
        }

        echo json_encode(true);
    }

    private function new_judge()
    {
        $name = $_POST["name"];
        $mobile_number = $_POST["mobile_number"];
        $birthday = $_POST["birthday"];
        $sex = $_POST["sex"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $username_exists = $this->model->mod_check_username($username);

        if ($username_exists) {
            echo json_encode(false);
        } else {
            $this->model->mod_insert_user($name, $username, $password);

            $user_account = $this->model->mod_check_username($username);

            $user_id = $user_account[0]->id;

            $this->model->mod_insert_judge($user_id, $name, $mobile_number, $birthday, $sex);

            $_SESSION["alert"] =  array(
                "title" => "Success!",
                "message" => "A judge is successfully added!",
                "type" => "success"
            );

            echo json_encode(true);
        }
    }

    private function new_candidate()
    {
        $name = $_POST["name"];
        $mobile_number = $_POST["mobile_number"];
        $birthday = $_POST["birthday"];
        $sex = $_POST["sex"];
        $address = $_POST["address"];

        $this->model->mod_insert_candidate($name, $mobile_number, $birthday, $sex, $address);

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "A candidate is successfully added!",
            "type" => "success"
        );

        echo json_encode(true);
    }

    private function new_category()
    {
        $name = $_POST["name"];
        $description = $_POST["description"];

        $this->model->mod_insert_category($name, $description);

        $latest_category = $this->model->mod_get_latest_category();

        $category_id = $latest_category[0]->id;

        $this->model->mod_insert_event($category_id);

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "A category is successfully added!",
            "type" => "success"
        );

        echo json_encode(true);
    }

    private function set_score()
    {
        $category_id = $_POST["category_id"];
        $candidate_id = $_POST["candidate_id"];
        $judge_id = $_POST["judge_id"];
        $score = $_POST["score"];

        $this->model->mod_set_score($judge_id, $candidate_id, $category_id, $score);

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "A candidate has been scored successfully!",
            "type" => "success"
        );

        echo json_encode(true);
    }

    private function get_next_event()
    {
        $pending_events = $_POST["pending_events"];

        $next_events = $this->model->mod_get_next_events($pending_events);

        echo json_encode($next_events);
    }

    private function change_event()
    {
        $category_id = $_POST["category_id"];

        $this->model->mod_change_done_event();
        $this->model->mod_change_current_event($category_id);

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "The current event has been updated!",
            "type" => "success"
        );

        echo json_encode(true);
    }

    private function start_event()
    {
        $this->model->mod_reset_events();
        $this->model->mod_reset_scores();
        $this->model->mod_start_event();

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "The current event has been updated!",
            "type" => "success"
        );

        echo json_encode(true);
    }
    
    private function stop_event()
    {
        $this->model->mod_change_done_event();

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "The current event has been updated!",
            "type" => "success"
        );

        echo json_encode(true);
    }

    private function logout()
    {
        unset($_SESSION["id"]);

        $_SESSION["alert"] =  array(
            "title" => "Success!",
            "message" => "You have successfully logged out.",
            "type" => "success"
        );

        echo json_encode(true);
    }
}

$server = new Server();
