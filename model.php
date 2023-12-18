<?php

class Model
{
    function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "system_tabulation";

        $mysqli = new mysqli($servername, $username, $password, $database);

        if ($mysqli->connect_error) {
            die("Database Error: " . $mysqli->connect_error);
        }

        $this->mysqli = $mysqli;
    }

    function mod_login($username, $password)
    {
        $query = "SELECT * FROM `tbl_info_users` WHERE `username` = '" . $username . "' AND `password` = '" . $password . "' ";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_userdata($id)
    {
        $query = "SELECT * FROM `tbl_info_users` WHERE `id` = '" . $id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_judge_data()
    {
        $query = "SELECT * FROM `tbl_info_judges`";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_candidate_data()
    {
        $query = "SELECT * FROM `tbl_info_candidates`";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_candidate_data_by_id($candidate_id)
    {
        $query = "SELECT * FROM `tbl_info_candidates` WHERE `id` = '" . $candidate_id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_leading_candidate($sex)
    {
        $query = "SELECT c.*, SUM(s.score) AS `total_score` FROM `tbl_info_candidates` c INNER JOIN `tbl_info_scores` s ON c.id = s.candidate_id WHERE c.sex = '" . $sex . "' GROUP BY c.id, c.name, c.sex ORDER BY `total_score` DESC LIMIT 1";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_category_data()
    {
        $query = "SELECT * FROM `tbl_info_categories`";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_event_done_data()
    {
        $query = "SELECT * FROM `tbl_info_event` WHERE `status` != 'Pending'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_semi_finals()
    {
        $query = "(SELECT c.* FROM tbl_info_candidates c JOIN ( SELECT candidate_id, SUM(score) AS total_score FROM tbl_info_scores GROUP BY candidate_id ) s ON c.id = s.candidate_id WHERE c.sex = 'Male' ORDER BY s.total_score DESC LIMIT 3) UNION (SELECT c.* FROM tbl_info_candidates c JOIN ( SELECT candidate_id, SUM(score) AS total_score FROM tbl_info_scores GROUP BY candidate_id ) s ON c.id = s.candidate_id WHERE c.sex = 'Female' ORDER BY s.total_score DESC LIMIT 3)";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_finals()
    {
        $query = "(SELECT c.* FROM tbl_info_candidates c JOIN ( SELECT candidate_id, SUM(score) AS total_score FROM tbl_info_scores GROUP BY candidate_id ) s ON c.id = s.candidate_id WHERE c.sex = 'Male' ORDER BY s.total_score DESC LIMIT 2) UNION (SELECT c.* FROM tbl_info_candidates c JOIN ( SELECT candidate_id, SUM(score) AS total_score FROM tbl_info_scores GROUP BY candidate_id ) s ON c.id = s.candidate_id WHERE c.sex = 'Female' ORDER BY s.total_score DESC LIMIT 2)";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_category_data_preliminary()
    {
        $query = "SELECT * FROM `tbl_info_categories` WHERE `name` != 'Semi-Finals' AND `name` != 'Finals'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_category_data_by_id($id)
    {
        $query = "SELECT * FROM `tbl_info_categories` WHERE `id` = '" . $id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_latest_category()
    {
        $query = "SELECT * FROM `tbl_info_categories` ORDER BY `id` DESC LIMIT 1";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_current_event()
    {
        $query = "SELECT * FROM `tbl_info_event` WHERE `status` = 'Current'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_pending_events()
    {
        $query = "SELECT * FROM `tbl_info_event` WHERE `status` = 'Pending'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_ave_scores()
    {
        $query = "SELECT `candidate_id`, AVG(`score`) AS `total_score` FROM `tbl_info_scores` GROUP BY `candidate_id` ORDER BY `total_score` DESC";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_next_events($pending_events)
    {
        $query = "SELECT * FROM `tbl_info_categories` WHERE `id` IN (" . $pending_events . ")";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_event_data($category_id)
    {
        $query = "SELECT * FROM `tbl_info_event` WHERE `category_id` = '" . $category_id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_scores_data($candidate_id, $category_id, $judge_id)
    {
        $query = "SELECT * FROM `tbl_info_scores` WHERE `candidate_id` = '" . $candidate_id . "' AND `category_id` = '" . $category_id . "' AND `judge_id` = '" . $judge_id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_check_username($username)
    {
        $query = "SELECT * FROM `tbl_info_users` WHERE `username` = '" . $username . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_get_candidate_scores($judge_id, $candidate_id, $category_id)
    {
        $query = "SELECT * FROM `tbl_info_scores` WHERE `judge_id` = '" . $judge_id . "' AND `candidate_id` = '" . $candidate_id . "' AND `category_id` = '" . $category_id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result) {
            $results = array();

            while ($row = $query_result->fetch_assoc()) {
                $results[] = (object) $row;
            }

            $query_result->close();

            return $results;
        } else {
            return null;
        }
    }

    function mod_insert_user($name, $username, $password)
    {
        $query = "INSERT INTO `tbl_info_users` (`id`, `name`, `username`, `password`, `user_type`) VALUES (NULL, '" . $name . "', '" . $username . "', '" . $password . "', 'judge')";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_insert_judge($user_id, $name, $mobile_number, $birthday, $sex)
    {
        $query = "INSERT INTO `tbl_info_judges` (`id`, `user_id`, `name`, `mobile_number`, `birthday`, `sex`) VALUES (NULL, '" . $user_id . "', '" . $name . "', '" . $mobile_number . "', '" . $birthday . "', '" . $sex . "')";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_insert_candidate($name, $mobile_number, $birthday, $sex, $address)
    {
        $query = "INSERT INTO `tbl_info_candidates` (`id`, `name`, `mobile_number`, `birthday`, `sex`, `address`) VALUES (NULL, '" . $name . "', '" . $mobile_number . "', '" . $birthday . "', '" . $sex . "', '" . $address . "')";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_insert_category($name, $description)
    {
        $query = "INSERT INTO `tbl_info_categories` (`id`, `name`, `description`) VALUES (NULL, '" . $name . "', '" . $description . "')";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_insert_event($category_id)
    {
        $query = "INSERT INTO `tbl_info_event` (`id`, `category_id`, `status`) VALUES (NULL, '" . $category_id . "', 'Pending')";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_set_score($judge_id, $candidate_id, $category_id, $score)
    {
        $query = "INSERT INTO `tbl_info_scores` (`id`, `judge_id`, `candidate_id`, `category_id`, `score`) VALUES (NULL, '" . $judge_id . "', '" . $candidate_id . "', '" . $category_id . "', '" . $score . "')";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_start_event()
    {
        $query = "UPDATE `tbl_info_event` SET `status` = 'Current' ORDER BY id LIMIT 1";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_reset_events()
    {
        $query = "UPDATE `tbl_info_event` SET `status` = 'Pending'";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_reset_scores()
    {
        $query = "TRUNCATE TABLE `tbl_info_scores`";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_change_done_event()
    {
        $query = "UPDATE `tbl_info_event` SET `status` = 'Done' WHERE `status` = 'Current'";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mod_change_current_event($category_id)
    {
        $query = "UPDATE `tbl_info_event` SET `status` = 'Current' WHERE `id` = '" . $category_id . "'";
        $query_result = $this->mysqli->query($query);

        if ($query_result && $this->mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
