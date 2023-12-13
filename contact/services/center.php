<?php
include_once '../composant/com_table/table.php';
include_once '../composant/com_security/security.php';
if (isset($_GET["task"])) {
    $task = $_GET["task"];
}


switch ($task) {
    case 'showLoginForm':
        if (isset($_SESSION['str_USER_ID'])) {
            header("location:index.php");
        } else {
            header('location:login.php');
        }
        break;
    case 'showTable':
        echo showTable();
    break;
    case 'showHomeAdminPage':
        echo showTable();
        break;
}

function showHomeAdminPage(){
    //Dashbord::showHomeAdminPage();
    echo 'DashBord';
}

function showTable(){
    Table::showAllTable();
}