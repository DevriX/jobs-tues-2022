<?php

include 'header.php';

if ($_POST['action'] == 'approve') {
    $approve_request = 
        "UPDATE jobs SET status = 1 WHERE id = " . $_POST['job'] . "";

    if ($conn->query($approve_request) === FALSE) {
        echo "Error: " . $approve_request . "<br>" . $conn->error;
    }
}

if($_POST['action'] == 'reject'){
    $reject_request = 
        "UPDATE jobs SET status = 0 WHERE id = " . $_POST['job'] . "";
			
    if ($conn->query($reject_request) === FALSE) {
        echo "Error: " . $reject_request . "<br>" . $conn->error;
    }
}

if($_POST['action'] == 'delete'){
    $delete_categories_request = 
        "DELETE FROM jobs_categories
        WHERE job_id=" . $_POST['job'] . " ";
    if ($conn->query($delete_categories_request) === FALSE) {
        echo "Error: " . $delete_categories_request . "<br>" . $conn->error;
    }

    $delete_appliciants_request = 
        "DELETE FROM applications WHERE job_id = " . $_POST['job'] . " ";
    if ($conn->query($delete_appliciants_request) === FALSE) {
        echo "Error: " . $delete_appliciants_request . "<br>" . $conn->error;
    }

    $delete_job_request = 
        "DELETE FROM jobs WHERE jobs.id=" . $_POST['job'] . " ";
    if ($conn->query($delete_job_request) === FALSE) {
        echo "Error: " . $delete_request . "<br>" . $conn->error;
    }
}