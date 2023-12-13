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
    else if ($task == "getAllExtraction"){
        $str_EXTRACTION_ID = "";
        if(isset($_GET['id']))
        {
            $str_EXTRACTION_ID = htmlentities($_GET['id']);
        }
        if(isset($_GET['nbre']))
        {
            $nbre = htmlentities($_GET['nbre']);
        }
        if(isset($_GET['params']))
        {
            $params = htmlentities($_GET['params']);
        }
        if(isset($_GET['libelle']))
        {
            $libelle = htmlentities($_GET['libelle']);
        }
        $index = $_GET["index"];
        getAllExtraction( $libelle, $params, $nbre, $str_EXTRACTION_ID, $db, $index);
    }
    else if ($task == "countData"){
        if(isset($_GET['id']))
        {
            $str_EXTRACTION_ID = htmlentities($_GET['id']);
        }
        if(isset($_GET['nbre']))
        {
            $nbre = htmlentities($_GET['nbre']);
        }
        if(isset($_GET['params']))
        {
            $params = htmlentities($_GET['params']);
        }
        if(isset($_GET['libelle']))
        {
            $libelle = htmlentities($_GET['libelle']);
        }
        countData($db, $str_EXTRACTION_ID, $libelle, $nbre, $params);
    }

}