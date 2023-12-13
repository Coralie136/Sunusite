<?php
/**
CONTIENT TOUTES LES FONCTIONS DE MON APPLICATIONS
*/
    error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('display_errors', FALSE);
    ini_set('display_startup_errors', FALSE);
    ini_set('session.gc_maxlifetime', 36000);
    //header('Access-Control-Allow-Origin: * ');
date_default_timezone_set('UTC');
    include_once('classes/PHPExcel.php');
    include_once('classes/PHPExcel/Reader/Excel2007.php');

    //require_once 'lib.class.php';
    if (!isset($_SESSION)) {
	  session_start();
	}
    function DoConnexion($host, $SECURITY, $pass, $dbname) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        try {
            $db = new PDO($dsn, $SECURITY, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $db;
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
    }
    function DoDeconnexion() {
        session_destroy();
        header("location:../../login.php");
    }
    function generatePassword($algo, $pwd) {
        $data = array();
        $data["ALGO"] = $algo;
        $data["DATE"] = $pwd;
        ksort($data);
        $message = http_build_query($data);
        $cle_bin = pack("a", KEY_PASSWORD);
        return strtoupper(hash_hmac(strtolower($data["ALGO"]), $message, $cle_bin));
    }
    function RandomString() {
        $characters = "0123456789abcdefghijklmnopqrstxwz";
        $randstring = '';
        for ($i = 0; $i < 5; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters))];
        }
        $unique = uniqid($randstring, "");
        return $unique;
    }

    function connexion($str_LOGIN, $str_PASSWORD, $str_ADRESSE_IP, $str_DETAILS, $db) {
        sleep(2);
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "3";
        $intResult = 0;
        $str_LOGIN = $db -> quote(htmlentities(trim($str_LOGIN)));
        $str_PASSWORD = generatePassword(ALGO, $str_PASSWORD);
        $str_PASSWORD = $db -> quote(htmlentities(trim($str_PASSWORD)));
        //var_dump($arrayJson);
        $sql = "SELECT * FROM user JOIN contact ON contact.id_user = user.id_user WHERE email_user LIKE " . $str_LOGIN . " AND pwd_user LIKE " . $str_PASSWORD . " AND statut_user != '" . $str_STATUT . "'";
        try{
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e){
            die($e->getMessage());
        }

        if (count($result) > 0) {
            foreach ($result as $item_result) {
                $arraySql[] = $item_result;
                $intResult++;
                $code_statut = "1";
                $_SESSION['login'] = $item_result['email_user'];
                $_SESSION['str_SECURITY_ID'] = $item_result['email_user'];
                $_SESSION['str_PRIV_ID'] = $item_result['id_level'];
                $_SESSION['lg_CONTACT_ID'] = $item_result['id_contact'];
                $_SESSION['statut_user'] = $item_result['statut_user'];
            }

            $arrayJson["results"] = "success";
            $arrayJson["total"] = $intResult;
            $arrayJson["desc_statut"] = "Connexion reussie";
            $arrayJson["code_statut"] = $code_statut;
        } else {
            $arrayJson["results"] = "Le nom d'utilisateur ou le mot de passe est incorrect !";
            $arrayJson["total"] = $intResult;
            $arrayJson["desc_statut"] = "Une erreur c'est produite !";
            $arrayJson["code_statut"] = $code_statut;
        }

        echo "[" . json_encode($arrayJson) . "]";
    }

    function getData($lg_TABLE_ID, $dt_date_debut, $dt_date_fin, $id_assurable, $lg_AGE_ID, $lg_SOUSCRIPTION_ID, $lg_CATEGORIE_ID, $index, $db)
    {
        $data_assurable = "";
        $arrayJson = array();
        $arraySql = array();
        $arraySqlAssurable = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;


        $aujourdhui = date("d/m/Y");
        $dt_date_debuts = $dt_date_debut;
        $dt_date_fins = $dt_date_fin;


        if ($lg_TABLE_ID == "" || $lg_TABLE_ID == null) {
            $lg_TABLE_ID = "%%";
        }
        $lg_CONTACT_ID = $db->quote($_SESSION['lg_CONTACT_ID']);

        //###########################################################################################
        $where = "";
        //var_dump(sizeof($id_assurable));
        if(!empty($id_assurable))
        {
            $list = explode(',', $id_assurable);
            $p = sizeof($list);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){
                    if($j==0)
                    {
                        $where = " AND ( assurables LIKE '%".$id_assurable[$j]."%'";
                    }
                    else{
                        $where .= " OR assurables LIKE '%".$id_assurable[$j]."%'";
                    }
                }
            }
            $where .= ")";
        }

        if(!empty($lg_AGE_ID)){
            $where .= "  AND age.id_age LIKE ".$lg_AGE_ID." ";
        }
        if(!empty($lg_SOUSCRIPTION_ID)){
            $where .= "  AND souscription.id_souscription LIKE ".$lg_SOUSCRIPTION_ID." ";
        }
        if(!empty($lg_CATEGORIE_ID)){
            $where .= "  AND categorie.id_categorie LIKE ".$lg_CATEGORIE_ID." ";
        }

        //date

        if($dt_date_fins>$aujourdhui) $dt_date_fins = $aujourdhui;
        if($dt_date_debuts>$aujourdhui) $dt_date_debuts = $aujourdhui;

        if($dt_date_debuts>$dt_date_fins AND !empty($dt_date_fin))
        {
            $interm = $dt_date_fins;
            $dt_date_fins = $dt_date_debuts;
            $dt_date_debuts = $interm;
        }
        if(!empty($dt_date_debut) AND !empty($dt_date_fin) ){
            //if(!empty($where) && $where != "WHERE") $where .= " AND ";
            if($dt_date_debuts==$dt_date_fins)
            {
                $where .= " AND dates_inscription LIKE '".date("Y-m-d")."%'";
            }
            else{
                $arr        =   explode('/',$dt_date_debuts);
                $dt_date_debuts    =   $arr[2].'-'.$arr[1].'-'.$arr[0];
                //echo $dt_date_fins; die();
                $arr2        =   explode('/',$dt_date_fins);
                $dt_date_fins    =   $arr2[2].'-'.$arr2[1].'-'.$arr2[0];

                $where .= " AND dates_inscription BETWEEN '".$dt_date_debuts."' AND '".$dt_date_fins."' ";
                //$where .= " AND DATE_FORMAT(dates_inscription, '%d/%m/%Y') BETWEEN '".$dt_date_debuts."' AND '".$dt_date_fins."' ";
                //var_dump($where); die();
            }
        }
        elseif(!empty($dt_date_debut)){
            //if(!empty($where) && $where != "WHERE") $where .= " AND ";
            $where .= " AND DATE_FORMAT(dates_inscription, '%d/%m/%Y') LIKE '".$dt_date_debuts."'";
        }
        /*
        if(!empty($dt_date_debut) AND !empty($dt_date_fin)){
            $where .= "  AND dates_inscription BETWEEN '".$dt_date_debut."' AND '".$dt_date_fin."' ";
        }
        elseif($dt_date_debut) {
            $where .= "  AND dates_inscription LIKE '" . $dt_date_debut . "'";
        }*/

        /*
        $sql = "SELECT * FROM clients "
            ."JOIN pays ON pays.id_pays = clients.id_pays "
            ."JOIN souscription ON souscription.id_souscription = clients.id_souscription "
            ."JOIN categorie ON categorie.id_categorie = clients.id_categorie "
            ."JOIN client_contact ON client_contact.id_clients = clients.id_client "
            ."JOIN contact ON contact.id_contact = client_contact.id_contact "
            ."JOIN age ON age.id_age = clients.id_age ".$where." AND bl_display LIKE 1 AND contact.id_contact LIKE " . $lg_CONTACT_ID;

**/
        $sql = "SELECT * FROM contact "
            ."JOIN client_contact ON client_contact.id_contact = contact.id_contact "
            ."JOIN clients ON client_contact.id_clients = clients.id_client "
            ."JOIN pays ON contact.id_pays = pays.id_pays "
            ."JOIN souscription ON souscription.id_souscription = clients.id_souscription "
            ."JOIN categorie ON categorie.id_categorie = clients.id_categorie "
            ."JOIN age ON age.id_age = clients.id_age "
            . " WHERE contact.id_contact LIKE " . $lg_CONTACT_ID . " AND bl_display LIKE 1 ".$where." LIMIT $index,10";

        //echo $sql; die();
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item_result) {
            //$arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
            $list = explode('|', $item_result['assurables']);
            $p = sizeof($list);

            //var_dump($item_result['id_assurable']);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){
                    $sql2 = " SELECT * FROM assurable WHERE id_assurable LIKE '$list[$j]'";
                    //die();
                    $stmt2 = $db->query($sql2);
                    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result2 as $item_result2) {
                        $data_assurable .= $item_result2['nom_assurable'].'<br/>';
                    }
                }
            }

            $date_gmt = date("d/m/Y à h:m:s",strtotime($item_result['dates_inscription']));
            $item_result+= ["assurable" => $data_assurable];
            $data_assurable = "";
            $item_result+=["date_gmt" => $date_gmt];
            $arraySql[] = $item_result;
        }
        //$arrayJson["resultsAssurable"] = $arraySqlAssurable;
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function countData($lg_TABLE_ID, $dt_date_debut, $dt_date_fin, $id_assurable, $lg_AGE_ID, $lg_SOUSCRIPTION_ID, $lg_CATEGORIE_ID, $db)
    {
        $data_assurable = "";
        $arrayJson = array();
        $arraySql = array();
        $arraySqlAssurable = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;

        $aujourdhui = date("d/m/Y");
        $dt_date_debuts = $dt_date_debut;
        $dt_date_fins = $dt_date_fin;


        if ($lg_TABLE_ID == "" || $lg_TABLE_ID == null) {
            $lg_TABLE_ID = "%%";
        }
        $lg_CONTACT_ID = $db->quote($_SESSION['lg_CONTACT_ID']);

        //###########################################################################################
        $where = "";
        //var_dump(sizeof($id_assurable));
        if(!empty($id_assurable))
        {
            $list = explode(',', $id_assurable);
            $p = sizeof($list);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){
                    if($j==0)
                    {
                        $where = " AND ( assurables LIKE '%".$id_assurable[$j]."%'";
                    }
                    else{
                        $where .= " OR assurables LIKE '%".$id_assurable[$j]."%'";
                    }
                }
            }
            $where .= ")";
        }

        if(!empty($lg_AGE_ID)){
            $where .= "  AND age.id_age LIKE ".$lg_AGE_ID." ";
        }
        if(!empty($lg_SOUSCRIPTION_ID)){
            $where .= "  AND souscription.id_souscription LIKE ".$lg_SOUSCRIPTION_ID." ";
        }
        if(!empty($lg_CATEGORIE_ID)){
            $where .= "  AND categorie.id_categorie LIKE ".$lg_CATEGORIE_ID." ";
        }

        //date
        if($dt_date_fins>$aujourdhui) $dt_date_fins = $aujourdhui;
        if($dt_date_debuts>$aujourdhui) $dt_date_debuts = $aujourdhui;

        if($dt_date_debuts>$dt_date_fins AND !empty($dt_date_fin))
        {
            $interm = $dt_date_fins;
            $dt_date_fins = $dt_date_debuts;
            $dt_date_debuts = $interm;
        }
        if(!empty($dt_date_debut) AND !empty($dt_date_fin) ){
            //if(!empty($where) && $where != "WHERE") $where .= " AND ";
            if($dt_date_debuts==$dt_date_fins)
            {
                $where .= " AND dates_inscription LIKE '".date("Y-m-d")."%'";
            }
            else{
                $arr        =   explode('/',$dt_date_debuts);
                $dt_date_debuts    =   $arr[2].'-'.$arr[1].'-'.$arr[0];
                //echo $dt_date_fins; die();
                $arr2        =   explode('/',$dt_date_fins);
                $dt_date_fins    =   $arr2[2].'-'.$arr2[1].'-'.$arr2[0];

                $where .= " AND dates_inscription BETWEEN '".$dt_date_debuts."' AND '".$dt_date_fins."' ";
            }
        }
        elseif(!empty($dt_date_debut)){
            //if(!empty($where) && $where != "WHERE") $where .= " AND ";
            $where .= " AND DATE_FORMAT(dates_inscription, '%d/%m/%Y') LIKE '".$dt_date_debuts."'";
        }

        $sql = "SELECT count(*) AS numberData FROM contact "
            ."JOIN client_contact ON client_contact.id_contact = contact.id_contact "
            ."JOIN clients ON client_contact.id_clients = clients.id_client "
            ."JOIN pays ON contact.id_pays = pays.id_pays "
            ."JOIN souscription ON souscription.id_souscription = clients.id_souscription "
            ."JOIN categorie ON categorie.id_categorie = clients.id_categorie "
            ."JOIN age ON age.id_age = clients.id_age "
            . " WHERE contact.id_contact LIKE " . $lg_CONTACT_ID . " AND bl_display LIKE 1 ".$where;
        //echo $sql; die();
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        echo  json_encode($arraySql) ;
    }
    function deleteTable($lg_TABLE_ID, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = 0;
        $lg_TABLE_ID = $db->quote($lg_TABLE_ID);
        $sql = "UPDATE client_contact "
            . "SET bl_display = $str_STATUT "
            . "WHERE id_client_contact = $lg_TABLE_ID";
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Suppression effectuée avec succès";
                $code_statut = "1";
            } else {
                $message = "Erreur lors de la modification";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function editPassword($str_PASSWORD, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = 0;
        $str_PASSWORD = generatePassword(ALGO, $str_PASSWORD);
        $str_PASSWORD = $db -> quote(htmlentities(trim($str_PASSWORD)));
        $str_EMAIL = $db -> quote($_SESSION['str_SECURITY_ID']);
        $sql = "UPDATE user "
            . "SET pwd_user = $str_PASSWORD, statut_user = 1 "
            . "WHERE email_user = $str_EMAIL ";
        //ECHO $sql; die();
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Mot de passe modifié avec succès !";
                $_SESSION['statut_user'] = 1;
                $code_statut = "1";
            } else {
                $message = "Erreur lors de la modification | vous avez saisie le même mot de passe.";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getCountry($db){

        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;

        $lg_CONTACT_ID = $db->quote($_SESSION['lg_CONTACT_ID']);

        $sql = "SELECT * FROM contact "
            ."JOIN pays ON contact.id_pays = pays.id_pays "
            . " WHERE contact.id_contact LIKE " . $lg_CONTACT_ID ;

        //echo $sql; die();
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllAssurable($lg_ASSURABLE_ID, $db)
    {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_ASSURABLE_ID == "" || $lg_ASSURABLE_ID == null) {
            $lg_ASSURABLE_ID = "%%";
        }
        $lg_ASSURABLE_ID = $db->quote($lg_ASSURABLE_ID);

        $sql = "SELECT * FROM assurable "
            . " WHERE id_assurable LIKE " . $lg_ASSURABLE_ID . "  ";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllAge($lg_AGE_ID, $db)
    {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_AGE_ID == "" || $lg_AGE_ID == null) {
            $lg_AGE_ID = "%%";
        }
        $lg_AGE_ID = $db->quote($lg_AGE_ID);

        $sql = "SELECT * FROM age "
            . " WHERE id_age LIKE " . $lg_AGE_ID . "  ";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllSouscription($lg_SOUSCRIPTION_ID, $db)
    {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_SOUSCRIPTION_ID == "" || $lg_SOUSCRIPTION_ID == null) {
            $lg_SOUSCRIPTION_ID = "%%";
        }
        $lg_SOUSCRIPTION_ID = $db->quote($lg_SOUSCRIPTION_ID);

        $sql = "SELECT * FROM souscription "
            . " WHERE id_souscription LIKE " . $lg_SOUSCRIPTION_ID . "  ";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllCategorie($lg_CATEGORIE_ID, $db)
    {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_CATEGORIE_ID == "" || $lg_CATEGORIE_ID == null) {
            $lg_CATEGORIE_ID = "%%";
        }
        $lg_CATEGORIE_ID = $db->quote($lg_CATEGORIE_ID);

        $sql = "SELECT * FROM categorie "
            . " WHERE id_categorie LIKE " . $lg_CATEGORIE_ID . "  ";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }

function extractXSLData($fileName, $lg_TABLE_ID, $dt_date_debut, $dt_date_fin, $id_assurable, $lg_AGE_ID, $lg_SOUSCRIPTION_ID, $lg_CATEGORIE_ID,$db)
{
    set_time_limit(0);
    //date_default_timezone_get('Europe/London');
    define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br/>');
    $data_assurable = "";
    $arrayJson = array();
    $arraySql = array();
    $arraySqlAssurable = array();
    $data = array();
    $code_statut = "0";
    $str_STATUT = "enable";
    $intResult = 0;
    //Include PHPEXCEL
    require_once dirname(__FILE__) . '/classes/PHPExcel.php';

    $dt_date_debuts = $dt_date_debut;
    $dt_date_fins = $dt_date_fin;
    $aujourdhui = date("d/m/Y");


    if ($lg_TABLE_ID == "" || $lg_TABLE_ID == null) {
        $lg_TABLE_ID = "%%";
    }
    $lg_CONTACT_ID = $db->quote($_SESSION['lg_CONTACT_ID']);

    //###########################################################################################
    $where = "";
    //var_dump(sizeof($id_assurable));
    if(!empty($id_assurable))
    {
        $list = explode(',', $id_assurable);
        $p = sizeof($list);
        for ($j=0; $j < $p; $j++) {
            if($list[$j] != ''){
                if($j==0)
                {
                    $where = " AND ( assurables LIKE '%".$id_assurable[$j]."%'";
                }
                else{
                    $where .= " OR assurables LIKE '%".$id_assurable[$j]."%'";
                }
            }
        }
        $where .= ")";
    }

    if(!empty($lg_AGE_ID)){
        $where .= "  AND age.id_age LIKE ".$lg_AGE_ID." ";
    }
    if(!empty($lg_SOUSCRIPTION_ID)){
        $where .= "  AND souscription.id_souscription LIKE ".$lg_SOUSCRIPTION_ID." ";
    }
    if(!empty($lg_CATEGORIE_ID)){
        $where .= "  AND categorie.id_categorie LIKE ".$lg_CATEGORIE_ID." ";
    }

    //date
    if($dt_date_fins>$aujourdhui) $dt_date_fins = $aujourdhui;
    if($dt_date_debuts>$aujourdhui) $dt_date_debuts = $aujourdhui;

    if($dt_date_debuts>$dt_date_fins AND !empty($dt_date_fin))
    {
        $interm = $dt_date_fins;
        $dt_date_fins = $dt_date_debuts;
        $dt_date_debuts = $interm;
    }
    if(!empty($dt_date_debut) AND !empty($dt_date_fin) ){
        //if(!empty($where) && $where != "WHERE") $where .= " AND ";
        if($dt_date_debuts==$dt_date_fins)
        {
            $where .= " AND dates_inscription LIKE '".date("Y-m-d")."%'";
        }
        else{
            $arr        =   explode('/',$dt_date_debuts);
            $dt_date_debuts    =   $arr[2].'-'.$arr[1].'-'.$arr[0];
            //echo $dt_date_fins; die();
            $arr2        =   explode('/',$dt_date_fins);
            $dt_date_fins    =   $arr2[2].'-'.$arr2[1].'-'.$arr2[0];

            $where .= " AND dates_inscription BETWEEN '".$dt_date_debuts."' AND '".$dt_date_fins."' ";
        }
    }
    elseif(!empty($dt_date_debut)){
        //if(!empty($where) && $where != "WHERE") $where .= " AND ";
        $where .= " AND DATE_FORMAT(dates_inscription, '%d/%m/%Y') LIKE '".$dt_date_debuts."'";
    }

    /*$sql = "SELECT * FROM contact "
        ."JOIN client_contact ON client_contact.id_contact = contact.id_contact "
        ."JOIN clients ON client_contact.id_clients = clients.id_client "
        ."JOIN pays ON contact.id_pays = pays.id_pays "
        ."JOIN souscription ON souscription.id_souscription = clients.id_souscription "
        ."JOIN categorie ON categorie.id_categorie = clients.id_categorie "
        ."JOIN age ON age.id_age = clients.id_age "
        . " WHERE contact.id_contact LIKE " . $lg_CONTACT_ID . " AND bl_display LIKE 1 ".$where;*/
    $sql = "SELECT * FROM contact "
        ."JOIN client_contact ON client_contact.id_contact = contact.id_contact "
        ."JOIN clients ON client_contact.id_clients = clients.id_client "
        ."JOIN pays ON contact.id_pays = pays.id_pays "
        ."JOIN souscription ON souscription.id_souscription = clients.id_souscription "
        ."JOIN categorie ON categorie.id_categorie = clients.id_categorie "
        ."JOIN age ON age.id_age = clients.id_age "
        . " WHERE contact.id_contact LIKE " . $lg_CONTACT_ID . " AND bl_display LIKE 1 ".$where;

    //echo $sql; die();
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $objPHPExcel = new PHPExcel();
// Propriétés du document
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Moroko Jean-Romaric Leby")
        ->setTitle("Document")
        ->setSubject("Document")
        ->setDescription("Document généré par l'application backoffice sunu.")
        ->setKeywords("office PHPExcel php")
        ->setCategory("Test result file");

    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')
        ->setSize(9);

    //var_dump($objPHPExcel->getActiveSheet()->getHighestColumn()); die();

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1", "Nom et prénom(s)")
            ->setCellValue("B1", "E-mail")
            ->setCellValue("C1", "Téléphone")
            ->setCellValue("D1", "Date d'inscription")
            ->setCellValue("E1", "Pays")
            ->setCellValue("F1", "Catégorie socio-pro.")
            ->setCellValue("G1", "Tranches d'âge")
            ->setCellValue("H1", "Montant")
            ->setCellValue("I1", "Assurables");
    $colonne = array("A","B","C","D","E","F","G","H", "I");

    //permet au cellule de concerver la taille du contenue
    for ($i = 'A'; $i !=  $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
    }

    $i = 1;

    foreach ($result as $item_result) {
        //$arraySql[] = $item_result;
        $intResult++;
        $code_statut = "1";
        $list = explode('|', $item_result['assurables']);
        $p = sizeof($list);

        //var_dump($item_result['id_assurable']);
        for ($e=0; $e < $p; $e++) {
            if($list[$e] != ''){
                $sql2 = " SELECT * FROM assurable WHERE id_assurable LIKE '$list[$e]'";
                //die();
                $stmt2 = $db->query($sql2);
                $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result2 as $item_result2) {
                    $data_assurable .= $item_result2['nom_assurable'].'<br/>';
                }
            }
        }

        //$date_gmt = date("d/m/Y à h:m:s",strtotime($item_result['dates_inscription']));

        $date=date_create($item_result['dates_inscription']);
        $date_gmt= date_format($date,"d/m/Y à h:m:s");
        //echo $date_gmt; die();
        $item_result+= ["assurable" => $data_assurable];
        $data_assurable = "";
        $item_result+=["date_gmt" => $date_gmt];

        //var_dump($item_result);
        $arraySql[] = $item_result;
        $intResult++;
        $code_statut = "1";
        $rows = 0;
        $i++;
        try{
            $objPHPExcel->getActiveSheet()
                ->setCellValue($colonne[$rows++].$i, trim($item_result['nom'].' '.$item_result['prenoms']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['email']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['telephone']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['date_gmt']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['nom_pays']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['nom_categorie']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['nom_age'].' ans'))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['nom_souscription']))
                ->setCellValue($colonne[$rows++].$i, trim($item_result['assurable']));

        }
        catch (Exception $e) {
            echo "CALCULATION ENGINE ERROR: ".$e->getMessage()."<br />\n";

            echo '<h3>Evaluation Log:</h3><pre>';
            print_r(PHPExcel_Calculation::getInstance()->debugLog);
            echo '</pre>';
        }
    }

    $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            )
        )
    );


    //echo "jusque la tout vas bien";die();
    // Renommer la feuille active
    $objPHPExcel->getActiveSheet()->setTitle(($fileName==''?'Liste des clients':$fileName));


// Definir l'index de la feuille active
    $objPHPExcel->setActiveSheetIndex(0);
    $str_FILE_NAME = str_replace(' ', '_', $fileName);
    $date = str_replace(' ', '_', date('Y-m-d H-i-s'));
    //$fileName1 = __DIR__."/document_uploader/".$str_FILE_NAME."-".$date.".xlsx";
    $fileName2 = __DIR__."/document_uploader/".$str_FILE_NAME."-".$date.".xls";
//CODE QUI PERMET DE CREER ET SAUVEGARDER DEUX FICHIER EXCEL

    // Sauvegarde excel 2007
    /*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($fileName1);*/

    // Sauvegarde excel 95
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($fileName2);

    $arrayJson["results"] = "services/document_uploader/".$str_FILE_NAME."-".$date.".xls";
    $arrayJson["total"] = $intResult;
    $arrayJson["desc_statut"] = $db->errorInfo();
    $arrayJson["code_statut"] = $code_statut;

    echo "[" . json_encode(array('file' =>"services/document_uploader/".$str_FILE_NAME."-".$date.".xls", 'code_statut' => 1)) . "]";

}
function generatecsv($datas, $str_FILE_NAME, $directory_name){
    $contenu = "";
    $code_statut = 0;
    $str_FILE_NAME = str_replace(' ', '_', $str_FILE_NAME);
    $date = str_replace(' ', '_', date('Y-m-d H-i-s'));
    $str_SECURITY_ID = $_SESSION['str_SECURITY_ID'];
    $str_SECURITY_ID = str_replace("'", "", $str_SECURITY_ID);
    $file = "composant/".$directory_name."/".$str_FILE_NAME."-".$date."-".$str_SECURITY_ID.".csv";
    if($fp=fopen("../../".$file,"w" ))
    {
        $i = 0;
        foreach($datas as $v){
            if($i==0){
                $contenu .= '"'.implode('";"', array_keys($v)).'"'."\n";
                $contenu = utf8_decode($contenu);
            }
            $contenu .= '"'.implode('";"',$v).'"'."\n";
            $i++;
        }
        $code_statut = 1;
        $i = 1;
        fputs($fp,$contenu);
        fclose($fp);
    }
    return array('file' =>$file, 'code_statut' => 1);
}
?>