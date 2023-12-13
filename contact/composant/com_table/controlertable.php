<?php
if(!isset($_SESSION))
    session_start();

include '../../services/lib.php';
include_once '../../services/parameters.php';
$db = DoConnexion(HOST, USER, PWD, DBNAME);
if (isset($_GET["task"])) {
    $task = $_GET["task"];
    //echo $task;
    if ($task == "") {
        echo 'Error';
    } 
    else if ($task == "getData"){
        $lg_TABLE_ID = "";
        if(isset($_GET['lg_TABLE_ID']))
        {
            $lg_TABLE_ID = htmlentities($_GET['lg_TABLE_ID']);
        }
        $str_DATE_DEBUT = "";
        if(isset($_GET['str_DATE_DEBUT']) && !empty($_GET['str_DATE_DEBUT']) && $_GET['str_DATE_DEBUT'] <> 'null')
        {
            $str_DATE_DEBUT = htmlentities($_GET['str_DATE_DEBUT']);
        }

        $str_DATE_FIN = "";
        if(isset($_GET['str_DATE_FIN']) && !empty($_GET['str_DATE_FIN']) && $_GET['str_DATE_FIN'] <> 'null')
        {
            $str_DATE_FIN = htmlentities($_GET['str_DATE_FIN']);
        }
        $str_ASSURABLE = "";
        if(isset($_GET['str_ASSURABLE']) && !empty($_GET['str_ASSURABLE']) && $_GET['str_ASSURABLE'] <> 'null')
        {
            $str_ASSURABLE = htmlentities($_GET['str_ASSURABLE']);
        }
        $lg_AGE_ID = "";
        if(isset($_GET['lg_AGE_ID']) && !empty($_GET['lg_AGE_ID']) && $_GET['lg_AGE_ID'] <> 'null')
        {
            $lg_AGE_ID = htmlentities($_GET['lg_AGE_ID']);
        }
        $lg_SOUSCRIPTION_ID = "";
        if(isset($_GET['lg_SOUSCRIPTION_ID']) && !empty($_GET['lg_SOUSCRIPTION_ID']) && $_GET['lg_SOUSCRIPTION_ID'] <> 'null')
        {
            $lg_SOUSCRIPTION_ID = htmlentities($_GET['lg_SOUSCRIPTION_ID']);
        }
        $lg_CATEGORIE_ID = "";
        if(isset($_GET['lg_CATEGORIE_ID']) && !empty($_GET['lg_CATEGORIE_ID']) && $_GET['lg_CATEGORIE_ID'] <> 'null')
        {
            $lg_CATEGORIE_ID = htmlentities($_GET['lg_CATEGORIE_ID']);
        }
        $index = 0;
        if(isset($_GET['index']) && !empty($_GET['index']) && $_GET['index'] <> 'null')
        {
            $index = htmlentities($_GET['index']);
        }
        //var_dump($str_DATE_DEBUT);
        getData($lg_TABLE_ID, $str_DATE_DEBUT, $str_DATE_FIN, $str_ASSURABLE, $lg_AGE_ID, $lg_SOUSCRIPTION_ID, $lg_CATEGORIE_ID, $index, $db);
    }
    else if ($task == "countData"){
        $lg_TABLE_ID = "";
        if(isset($_GET['lg_TABLE_ID']))
        {
            $lg_TABLE_ID = htmlentities($_GET['lg_TABLE_ID']);
        }
        $str_DATE_DEBUT = "";
        if(isset($_GET['str_DATE_DEBUT']) && !empty($_GET['str_DATE_DEBUT']) && $_GET['str_DATE_DEBUT'] <> 'null')
        {
            $str_DATE_DEBUT = htmlentities($_GET['str_DATE_DEBUT']);
        }
        $str_DATE_FIN = "";
        if(isset($_GET['str_DATE_FIN']) && !empty($_GET['str_DATE_FIN']) && $_GET['str_DATE_FIN'] <> 'null')
        {
            $str_DATE_FIN = htmlentities($_GET['str_DATE_FIN']);
        }
        $str_ASSURABLE = "";
        if(isset($_GET['str_ASSURABLE']) && !empty($_GET['str_ASSURABLE']) && $_GET['str_ASSURABLE'] <> 'null')
        {
            $str_ASSURABLE = htmlentities($_GET['str_ASSURABLE']);
        }
        $lg_AGE_ID = "";
        if(isset($_GET['lg_AGE_ID']) && !empty($_GET['lg_AGE_ID']) && $_GET['lg_AGE_ID'] <> 'null')
        {
            $lg_AGE_ID = htmlentities($_GET['lg_AGE_ID']);
        }
        $lg_SOUSCRIPTION_ID = "";
        if(isset($_GET['lg_SOUSCRIPTION_ID']) && !empty($_GET['lg_SOUSCRIPTION_ID']) && $_GET['lg_SOUSCRIPTION_ID'] <> 'null')
        {
            $lg_SOUSCRIPTION_ID = htmlentities($_GET['lg_SOUSCRIPTION_ID']);
        }
        $lg_CATEGORIE_ID = "";
        if(isset($_GET['lg_CATEGORIE_ID']) && !empty($_GET['lg_CATEGORIE_ID']) && $_GET['lg_CATEGORIE_ID'] <> 'null')
        {
            $lg_CATEGORIE_ID = htmlentities($_GET['lg_CATEGORIE_ID']);
        }

        countData($lg_TABLE_ID, $str_DATE_DEBUT, $str_DATE_FIN, $str_ASSURABLE, $lg_AGE_ID, $lg_SOUSCRIPTION_ID, $lg_CATEGORIE_ID, $db);
    }
    else if ($task == "getAllAssurable"){
        $lg_ASSURABLE_ID = "";
        if(isset($_GET['lg_ASSURABLE_ID']))
        {
            $lg_ASSURABLE_ID = htmlentities($_GET['lg_ASSURABLE_ID']);
        }
        getAllAssurable($lg_ASSURABLE_ID, $db);
    }
    else if ($task == "getAllAge"){
        $lg_AGE_ID = "";
        if(isset($_GET['lg_AGE_ID']))
        {
            $lg_AGE_ID = htmlentities($_GET['lg_AGE_ID']);
        }
        getAllAge($lg_AGE_ID, $db);
    }
    else if ($task == "getAllSouscription"){
        $lg_SOUSCRIPTION_ID = "";
        if(isset($_GET['lg_SOUSCRIPTION_ID']))
        {
            $lg_SOUSCRIPTION_ID = htmlentities($_GET['lg_SOUSCRIPTION_ID']);
        }
        getAllSouscription($lg_SOUSCRIPTION_ID, $db);
    }
    else if ($task == "getAllCategorie"){
        $lg_CATEGORIE_ID = "";
        if(isset($_GET['lg_CATEGORIE_ID']))
        {
            $lg_CATEGORIE_ID = htmlentities($_GET['lg_CATEGORIE_ID']);
        }
        getAllCategorie($lg_CATEGORIE_ID, $db);
    }
    else if ($task == "deleteTable"){
        $lg_TABLE_ID = "";
        if(isset($_GET['lg_TABLE_ID']))
        {
            $lg_TABLE_ID = htmlentities($_GET['lg_TABLE_ID']);
        }
        deleteTable($lg_TABLE_ID, $db) ;
    }
    else if ($task == "getCountry"){

        getCountry($db) ;
    }
}
else {
    $task = $_POST["task"];
    if ($task == "extractXSLData") {
        $lg_TABLE_ID = "";
        if (isset($_POST['lg_TABLE_ID'])) {
            $lg_TABLE_ID = htmlentities($_POST['lg_TABLE_ID']);
        }
        $str_DATE_DEBUT = "";
        if (isset($_POST['str_DATE_DEBUT']) && !empty($_POST['str_DATE_DEBUT']) && $_POST['str_DATE_DEBUT'] <> 'null') {
            $str_DATE_DEBUT = htmlentities($_POST['str_DATE_DEBUT']);
        }
        $str_DATE_FIN = "";
        if (isset($_POST['str_DATE_FIN']) && !empty($_POST['str_DATE_FIN']) && $_POST['str_DATE_FIN'] <> 'null') {
            $str_DATE_FIN = htmlentities($_POST['str_DATE_FIN']);
        }
        $str_ASSURABLE = "";
        if (isset($_POST['str_ASSURABLE']) && !empty($_POST['str_ASSURABLE']) && $_POST['str_ASSURABLE'] <> 'null') {
            $str_ASSURABLE = htmlentities($_POST['str_ASSURABLE']);
        }
        $fileName = "";
        if (isset($_POST['str_FILE_NAME']) && !empty($_POST['str_FILE_NAME']) && $_POST['str_FILE_NAME'] <> 'null') {
            $fileName = htmlentities($_POST['str_FILE_NAME']);
        }
        $lg_AGE_ID = "";
        if(isset($_POST['lg_AGE_ID']) && !empty($_POST['lg_AGE_ID']) && $_POST['lg_AGE_ID'] <> 'null')
        {
            $lg_AGE_ID = htmlentities($_POST['lg_AGE_ID']);
        }
        $lg_SOUSCRIPTION_ID = "";
        if(isset($_POST['lg_SOUSCRIPTION_ID']) && !empty($_POST['lg_SOUSCRIPTION_ID']) && $_POST['lg_SOUSCRIPTION_ID'] <> 'null')
        {
            $lg_SOUSCRIPTION_ID = htmlentities($_POST['lg_SOUSCRIPTION_ID']);
        }
        $lg_CATEGORIE_ID = "";
        if(isset($_POST['lg_CATEGORIE_ID']) && !empty($_POST['lg_CATEGORIE_ID']) && $_POST['lg_CATEGORIE_ID'] <> 'null')
        {
            $lg_CATEGORIE_ID = htmlentities($_POST['lg_CATEGORIE_ID']);
        }
        //var_dump($lg_CATEGORIE_ID); die();
        extractXSLData($fileName, $lg_TABLE_ID, $str_DATE_DEBUT, $str_DATE_FIN, $str_ASSURABLE, $lg_AGE_ID, $lg_SOUSCRIPTION_ID, $lg_CATEGORIE_ID,$db);
    }
}