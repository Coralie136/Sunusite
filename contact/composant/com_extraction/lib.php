<?php
/**
CONTIENT TOUTES LES FONCTIONS DE MON APPLICATIONS
*/
    error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('display_errors', FALSE);
    ini_set('display_startup_errors', FALSE);
    ini_set('session.gc_maxlifetime', 36000);
    //header('Access-Control-Allow-Origin: * '); a decommenter lorsque je vais la coupler avec une appli mobile
    //include 'SMSManager.php';

    include_once('classes/PHPExcel.php');
    include_once('classes/PHPExcel/Reader/Excel2007.php');

    if (!isset($_SESSION)) {
	  session_start();
	}
    function DoConnexion($host, $SECURITY, $pass, $dbname) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        try {
            $db = new PDO($dsn, $SECURITY, $pass);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $db;
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
    }
    function DoDeconnexion($db) {
        //echo "deconnexion";
        addActivity($db, "deconnexion");
        session_destroy();
        header("location:../../login.php");
    }
    function DoAutoDeconnexion(){
        $arrayJson["results"] = "Deconnexion auto";
        $arrayJson["total"] = 0;
        $arrayJson["desc_statut"] = "Une erreur c'est produite !";
        $arrayJson["code_statut"] = 0;
        if(empty($_SESSION['str_SECURITY_ID'])){
            //addActivity($db, "AutoDisconnect");
            $arrayJson["results"] = "Deconnexion auto";
            $arrayJson["total"] = 0;
            $arrayJson["desc_statut"] = "Une erreur c'est produite !";
            $arrayJson["code_statut"] = 1;
        }
        echo "[" . json_encode($arrayJson) . "]";
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
    function generateCodeName($algo, $name) {
        $data = array();
        $data["ALGO"] = $algo;
        $data["DATE"] = $name;
        ksort($data);
        $message = http_build_query($data);
        $cle_bin = pack("a", KEY_NAME);
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
    function setUpdatePassword($db)	{
        $str_SECURITY_ID = $_SESSION['str_SECURITY_ID'];
        $str_SECURITY_ID = $db -> quote($str_SECURITY_ID);
        $arrayJson = array();
        $sql = "UPDATE t_security "
                . "SET bl_IS_UPDATE = 0 "
                . "WHERE str_SECURITY_ID = $str_SECURITY_ID;";
    //    echo $sql;
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Modification effectué avec succès.";
                $code_statut = "1";
                $_SESSION['bl_IS_UPDATE'] = 0;
            } else {
                $message = "Erreur lors de la prise en compte de la réclamation.";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        header("location:../../index.php");
    }
    function getCountry($ip) {
        //$ip_data = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);
        /*if($ip_data && $ip_data->geoplugin_countryName != null){
            return $ip_data->geoplugin_countryName.' ('.$ip_data->geoplugin_city.' '.$ip_data->geoplugin_countryCode.')';
        }*/
        return "http://www.geoplugin.net/json.gp?ip=".$ip;
    }

    function connexion($str_LOGIN, $str_PASSWORD, $str_ADRESSE_IP, $str_DETAILS, $db) {
        sleep(2);
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        $str_LOGIN = $db -> quote(htmlentities(trim($str_LOGIN)));
        $str_PASSWORD = generatePassword(ALGO, $str_PASSWORD);
        $str_PASSWORD = $db -> quote(htmlentities(trim($str_PASSWORD)));
        //var_dump($arrayJson);
        $sql = "SELECT * FROM t_security WHERE str_LOGIN LIKE " . $str_LOGIN . " AND str_PASSWORD LIKE " . $str_PASSWORD . " AND str_STATUT LIKE '" . $str_STATUT . "'";
        
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($result) > 0) {
            foreach ($result as $item_result) {
                //$date = gmdate("Y-m-d, H:i:s");
                //setSecuritydtLASTCONNECTIONDATE($item_result['str_SECURITY_ID'], $date, $db);
                $arraySql[] = $item_result;
                $intResult++;
                $code_statut = "1";
                $_SESSION['nom'] = $item_result['str_NOM']. ' ' .$item_result['str_PRENOM'];
                $_SESSION['email'] = $item_result['str_EMAIL'];
                $_SESSION['login'] = $item_result['str_LOGIN'];
                $_SESSION['str_SECURITY_ID'] = $item_result['str_SECURITY_ID'];
                $_SESSION['str_PRIV_ID'] = $item_result['str_PRIVILEGE'];
                $_SESSION['str_ADRESS_IP'] =  $str_ADRESSE_IP;
                $_SESSION['str_NAVIGATEUR'] = $str_DETAILS;
                addActivity($db, "connexion");
            }

            $arrayJson["results"] = "success";
            $arrayJson["total"] = $intResult;
            $arrayJson["desc_statut"] = "Connexion reussie";
            $arrayJson["code_statut"] = $code_statut;
        } else {
            $arrayJson["results"] = "le nom d'utilisateur ou le mot de passe est incorrect";
            $arrayJson["total"] = $intResult;
            $arrayJson["desc_statut"] = "Une erreur c'est produite !";
            $arrayJson["code_statut"] = $code_statut;
        }
        
        echo "[" . json_encode($arrayJson) . "]";
    }
    function addActivity($db, $str_STATUT){
        $str_ACTIVITY_ID = RandomString();
        $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
        $payes = getCountry($_SERVER['REMOTE_ADDR']);

        $sql = "INSERT INTO t_activity(str_ACTIVITY_ID, str_LOGIN, str_NOM, str_PRIV,dt_CREATED, str_STATUT,str_SECURITY_ID, str_ADRESSE_IP,str_NAVIGATEUR,str_PAYS)"
            . "VALUES (:str_ACTIVITY_ID, :str_LOGIN, :str_NOM,:str_PRIV,$dt_CREATED,:str_STATUT,:str_SECURITY_ID,:str_ADRESSE_IP,:str_NAVIGATEUR,:str_PAYS)";
        try {
            $stmt = $db->prepare($sql);
            $stmt->BindParam(':str_ACTIVITY_ID', $str_ACTIVITY_ID);
            $stmt->BindParam(':str_LOGIN', $_SESSION['login']);
            $stmt->BindParam(':str_NOM', $_SESSION['nom']);
            $stmt->BindParam(':str_PRIV', $_SESSION['str_PRIV_ID']);
            $stmt->BindParam(':str_STATUT', $str_STATUT);
            $stmt->BindParam(':str_SECURITY_ID', $_SESSION['str_SECURITY_ID']);
            $stmt->BindParam(':str_ADRESSE_IP', $_SESSION['str_ADRESS_IP']);
            $stmt->BindParam(':str_NAVIGATEUR', $_SESSION['str_NAVIGATEUR']);
            $stmt->BindParam(':str_PAYS', $payes);
            //var_dump($stmt);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
    }
    function getAllSecurity( $str_SECURITY_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;
        if ($str_SECURITY_ID == "" || $str_SECURITY_ID == null) {
            $str_SECURITY_ID = "%%";
        }
        $str_SECURITY_ID = $db -> quote($str_SECURITY_ID);

        $sql = "SELECT * FROM t_security "
                . " WHERE str_SECURITY_ID LIKE " . $str_SECURITY_ID . " AND str_STATUT <> '".$str_STATUT."' "
                . " ORDER BY dt_CREATED DESC;";
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
        echo "[" . json_encode($arrayJson) . "]";
    }
    function isExistCodeSecurity($str_SECURITY_ID, $db) {
        $str_STATUT = 'delete';
        $str_SECURITY_ID = $db->quote($str_SECURITY_ID);
        $sql = "SELECT * FROM t_security WHERE str_SECURITY_ID LIKE " . $str_SECURITY_ID . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_SECURITY_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    function is_existe_use($db, $login, $mode, $str_SECURITY_ID = ""){
        $str_STATUT = 'delete';
        $login = $db->quote($login);
        if($mode === "insert"){
            $sql = "SELECT * FROM t_security WHERE str_login LIKE " . $login . " AND str_STATUT <> '" . $str_STATUT . "'";
        }
        else{
            $sql = "SELECT * FROM t_security WHERE str_login LIKE " . $login . " AND str_STATUT <> '" . $str_STATUT . "' AND str_SECURITY_ID <> '".$str_SECURITY_ID."'";
        }

        try {
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) >= 1) {
                return false;
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
            return false;
        }
        return true;
    }
    function addSecurity($str_NAME, $str_LASTNAME, $str_EMAIL, $str_LOGIN, $str_PASSWORD, $str_PASSWORD_CONF, $str_PRIVILEGE, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";

        if(is_existe_use($db, $str_LOGIN, "insert")){
            if($str_PASSWORD == $str_PASSWORD_CONF) {
                $str_SECURITY_ID = RandomString();
                $str_PASSWORD = generatePassword(ALGO, $str_PASSWORD);
                //$str_PASSWORD = $db->quote($str_PASSWORD);
                $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
                $sql = "INSERT INTO t_security(str_SECURITY_ID, str_LOGIN, str_PASSWORD, str_NOM, str_PRENOM,str_EMAIL, str_PRIVILEGE, str_STATUT, dt_CREATED, str_CREATED_BY)"
                    . "VALUES (:str_SECURITY_ID,:str_LOGIN,:str_PASSWORD,:str_NOM,:str_PRENOM,:str_EMAIL,:str_PRIVILEGE, :str_STATUT,$dt_CREATED,:str_CREATED_BY)";
                try {
                    if (!isExistCodeSecurity($str_SECURITY_ID, $db)) {

                        $stmt = $db->prepare($sql);
                        $str_STATUT = "enable";
                        $stmt->BindParam(':str_SECURITY_ID', $str_SECURITY_ID);
                        $stmt->BindParam(':str_LOGIN', $str_LOGIN);
                        $stmt->BindParam(':str_PASSWORD', $str_PASSWORD);
                        $stmt->BindParam(':str_NOM', $str_NAME);
                        $stmt->BindParam(':str_PRENOM', $str_LASTNAME);
                        $stmt->BindParam(':str_EMAIL', $str_EMAIL);
                        $stmt->BindParam(':str_PRIVILEGE', $str_PRIVILEGE);
                        $stmt->BindParam(':str_STATUT', $str_STATUT);
                        $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_SECURITY_ID']);
                        //var_dump($stmt);
                        if ($stmt->execute()) {
                            $message = "Insertion effectué avec succès";
                            $code_statut = "1";
                        } else {
                            $message = "Erreur lors de l'insertion";
                            $code_statut = "0";
                        }
                    } else {
                        $message = "Ce Code  : \" " . $str_SECURITY_ID . " \" de table existe déja! \r\n";
                        $code_statut = "0";
                    }
                } catch (PDOException $e) {
                    die("Erreur ! : " . $e->getMessage());
                }
            } else {
                $message = "Les mots de passe sont identique.";
                $code_statut = "0";
            }
        }
        else{
            $message = "Ce nom d'utilisateur est déjà utilisé.";
            $code_statut = "0";
        }

        $arrayJson["results"] = $message;
        $arrayJson["code_statut"] = $code_statut;
        $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function deleteSecurity($str_SECURITY_ID, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "delete";
        $str_SECURITY_ID = $db->quote($str_SECURITY_ID);
        $str_UPDATED_BY = $db->quote($_SESSION['str_SECURITY_ID']);
        $sql = "UPDATE t_security "
                . "SET str_STATUT = '$str_STATUT',"
                . "str_UPDATED_BY = $str_UPDATED_BY, "
                . "dt_UPDATED = '" . gmdate("Y-m-d, H:i:s") . "' "
                . "WHERE str_SECURITY_ID = $str_SECURITY_ID";
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
    function editSecurity($str_SECURITY_ID, $str_NAME, $str_LASTNAME, $str_EMAIL, $str_LOGIN, $str_PASSWORD, $str_PASSWORD_CONF,$str_PRIVILEGE, $db)
    {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        if(is_existe_use($db, $str_LOGIN, "edit", $str_SECURITY_ID)){
            $str_SECURITY_ID = $db->quote($str_SECURITY_ID);
            $str_NAME = $db->quote($str_NAME);
            $str_LASTNAME=$db->quote($str_LASTNAME);
            $str_LOGIN=$db->quote($str_LOGIN);
            $str_EMAIL=$db->quote($str_EMAIL);
            $str_PRIVILEGE=$db->quote($str_PRIVILEGE);
            if ($str_PASSWORD_CONF === $str_PASSWORD){
                $str_PASSWORD = generatePassword(ALGO, $str_PASSWORD);
                $str_PASSWORD = $db->quote($str_PASSWORD);
                //$str_ILLUSTRATION = NULL;
                $sql = "UPDATE t_security "
                    . "SET str_NOM = $str_NAME,"
                    . "str_PRENOM = $str_LASTNAME,"
                    . "str_LOGIN = $str_LOGIN,"
                    . "str_PASSWORD = $str_PASSWORD,"
                    . "str_EMAIL = $str_EMAIL,"
                    . "str_UPDATED_BY = '" . $_SESSION['str_SECURITY_ID'] . "',"
                    . "dt_UPDATED = '" . gmdate("Y-m-d, H:i:s") . "',"
                    . "str_PRIVILEGE = $str_PRIVILEGE"
                    . " WHERE str_SECURITY_ID = $str_SECURITY_ID";

                try {
                    $sucess = $db->exec($sql);
                    if ($sucess > 0) {
                        $message = "Modification effectuée avec succès";
                        $code_statut = "1";
                    } else {
                        $message = "Erreur lors de la modification";
                        $code_statut = "0";
                    }
                } catch (PDOException $e) {
                    die("Erreur ! : " . $e->getMessage());
                }
            }
            else {
                $message = "Les mots de passe ne sont pas identique.";
                $code_statut = "0";
            }
        }
        else{
            $message = "Le login est déjà utilisé.";
            $code_statut = "0";
        }

        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
    //    $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllBranche($str_BRANCHE_ID, $db){
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;
        if ($str_BRANCHE_ID == "" || $str_BRANCHE_ID == null) {
            $str_BRANCHE_ID = "%%";
        }
        $str_BRANCHE_ID = $db -> quote($str_BRANCHE_ID);

        $sql = "SELECT * FROM t_branche "
            . " WHERE str_BRANCHE_ID LIKE " . $str_BRANCHE_ID . " AND str_STATUT <> '".$str_STATUT."' "
            . " ORDER BY dt_CREATED DESC;";
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
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllIntermediaire($str_INTERMEDIAIRE_ID, $db){
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;
        if ($str_INTERMEDIAIRE_ID == "" || $str_INTERMEDIAIRE_ID == null) {
            $str_INTERMEDIAIRE_ID = "%%";
        }
        $str_INTERMEDIAIRE_ID = $db -> quote($str_INTERMEDIAIRE_ID);

        $sql = "SELECT * FROM t_intermediaire "
            . " WHERE str_INTERMEDIAIRE_ID LIKE " . $str_INTERMEDIAIRE_ID . " AND str_STATUT <> '".$str_STATUT."' "
            . " ORDER BY dt_CREATED DESC;";
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
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllPhase($str_PHASE_ID, $db){
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;
        if ($str_PHASE_ID == "" || $str_PHASE_ID == null) {
            $str_PHASE_ID = "%%";
        }
        $str_PHASE_ID = $db -> quote($str_PHASE_ID);

        $sql = "SELECT * FROM t_phase "
            . " WHERE str_PHASE_ID LIKE " . $str_PHASE_ID . " AND str_STATUT <> '".$str_STATUT."' "
            . " ORDER BY dt_CREATED DESC;";
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
        echo "[" . json_encode($arrayJson) . "]";
    }
    function isExistCodePhase($str_PHASE_ID, $db) {
        $str_STATUT = 'delete';
        $str_PHASE_ID = $db->quote($str_PHASE_ID);
        $sql = "SELECT * FROM t_phase WHERE str_PHASE_ID LIKE " . $str_PHASE_ID . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_PHASE_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function addPhase($db, $str_LIBELLE, $str_DATE_DEBUT, $str_DATE_FIN) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";
        $str_PHASE_ID = RandomString();

        $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
        $sql = "INSERT INTO t_phase(str_PHASE_ID, str_LIBELLE, dt_DEBUT, dt_FIN, str_STATUT, dt_CREATED, str_CREATED_BY)"
            . "VALUES (:str_PHASE_ID, :str_LIBELLE, :dt_DEBUT, :dt_FIN, :str_STATUT,$dt_CREATED,:str_CREATED_BY)";
        try {
            if (!isExistCodePhase($str_PHASE_ID, $db)) {

                $stmt = $db->prepare($sql);
                $str_STATUT = "enable";
                $stmt->BindParam(':str_PHASE_ID', $str_PHASE_ID);
                $stmt->BindParam(':str_LIBELLE', $str_LIBELLE);
                $stmt->BindParam(':dt_DEBUT', $str_DATE_DEBUT);
                $stmt->BindParam(':dt_FIN', $str_DATE_FIN);
                $stmt->BindParam(':str_STATUT', $str_STATUT);
                $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_SECURITY_ID']);
                //var_dump($stmt);
                if ($stmt->execute()) {
                    $message = "Insertion effectué avec succès";
                    $code_statut = "1";
                } else {
                    $message = "Erreur lors de l'insertion";
                    $code_statut = "0";
                }
            } else {
                $message = "Ce Code  : \" " . $str_PHASE_ID . " \" de table existe déja! \r\n";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }

        $arrayJson["results"] = $message;
        $arrayJson["code_statut"] = $code_statut;
        $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function deletePhase($str_PHASE_ID, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "delete";
        $str_PHASE_ID = $db->quote($str_PHASE_ID);
        $str_UPDATED_BY = $db->quote($_SESSION['str_SECURITY_ID']);
        $sql = "UPDATE t_phase "
            . "SET str_STATUT = '$str_STATUT',"
            . "str_UPDATED_BY = $str_UPDATED_BY, "
            . "dt_UPDATED = '" . gmdate("Y-m-d, H:i:s") . "' "
            . "WHERE str_PHASE_ID = $str_PHASE_ID";
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
    function editePhase($str_PHASE_ID, $str_LIBELLE, $str_DATE_DEBUT, $str_DATE_FIN, $db)
    {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        //ECHO $str_ETAT_ID;
        $str_LIBELLE = $db->quote($str_LIBELLE);
        $str_PHASE_ID = $db->quote($str_PHASE_ID);
        $str_DATE_DEBUT = $db->quote($str_DATE_DEBUT);
        $str_DATE_FIN = $db->quote($str_DATE_FIN);
        $sql = "UPDATE t_phase "
            . "SET str_LIBELLE = $str_LIBELLE,"
            . "dt_DEBUT = $str_DATE_DEBUT,"
            . "dt_FIN = $str_DATE_FIN,"
            . "str_UPDATED_BY = '" . $_SESSION['str_SECURITY_ID'] . "',"
            . "dt_UPDATED = '" . gmdate("Y-m-d, H:i:s") . "'"
            . " WHERE str_PHASE_ID = $str_PHASE_ID";

        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Modification effectuée avec succès";
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
        //    $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }

    function getAlphabetiqueWord(){
        $arrayJson = array();
        $arraySql = array();
        $message = "";
        $code_statut = "";
        $code_statut = "0";
        $intResult = 0;
        $lettre = "";
        foreach(range('A', 'Z') as $letter) {
            $arraySql[] = array('str_WORD' => strtoupper($letter));
            if($letter=="Z"){
                foreach(range('A', 'Z') as $lettres) {
                    foreach(range('A', 'Z') as $letters) {
                        $arraySql[] = array('str_WORD' => strtoupper($lettres).''.strtoupper($letters));
                    }
                }
            }
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }

    function addCourrier($str_NUMERO_POLICE, $str_ANCIENNE_POL, $str_CODE_PARTENAIRE, $str_CLIENT, $str_PRODUIT, $dt_DATE_EFFET, $dt_FIN_GARANTIE, $int_DUREE, $int_PNETTE, $int_CUMULE_PAYE,$int_PROVISION_FIN, $int_COMMISSION, $int_AUTRE_CHARGE, $int_CHARGE_TOTAL, $int_NBSIN, $int_NBPRIME, $int_PART_CUMULE_PAYE, $int_RATIO_COMBINE, $int_SP, $str_CLASSE_ROBUSTESSE, $str_ANOMALIE, $int_NSBIN_PRECEDENT, $int_RATIO_COMBINE_PRECEDENT, $bl_RENOUVELLE, $int_REF_RENOUVELLEMENT, $str_BLOCKRISQUE, $str_DECISION_PROVISOIRE, $int_POURCENTAGE_AJUST, $str_DECISION_FINAL, $int_NOUVELLE_PRIME, $str_IDENTIFIANT, $str_BRANCHE_ID, $str_INTERMEDIAIRE, $str_INTERMEDIAIRE_ID, $int_PRIME_TTC, $str_PHASE, $int_PNETTEPRORATA, $dt_STATISTIQUE, $db)
    {
        $current_ok = " \r\n ";
        $current_ok .= "NUMERO DE POLICE  \t ANCIENNE POLICE \t CODE PARTENANIRE \t CLIENT \t PRODUIT \t DATE EFFET \t DATE FIN GARANTIE \t DUREE \t PRIME NETTE \t CUMULE PAYE \t PROVISION FIN \t COMMISSION FIN  \t COMISSION \t AUTRE CHARGE \t CHARGE TOTAL \t NBSIN \t NBSIN PRIME \t PART CUMULE PAYE \t RATIO COMBINE \t SP \t CLASSE DE ROBUSTESSE \t ANOMALIE \t NSBIN PRECEDENT \t RATIO COMBINE PRECEDENT \t RENOUVELLEMENT \t BLOCKRISQUE \t DECISION PROVISOIR \t POURCENTAGE AJUSTEMENT \t DECISION \t NOUVELLE PRIME \t IDENTIFIANT \t BRANCHE \t INTERMEDIAIRE \t PRIME TTC  \t PHASE    \r\n";
        $current_ok .= "{$str_NUMERO_POLICE} \t {$str_ANCIENNE_POL} \t  {$str_CODE_PARTENAIRE} \t {$str_CLIENT} \t {$str_PRODUIT} \t {$dt_DATE_EFFET} \t {$dt_FIN_GARANTIE} \t {$int_DUREE} \t {$int_PNETTE} \t {$int_CUMULE_PAYE} \t {$int_PROVISION_FIN} \t {$int_COMMISSION} \t {$int_AUTRE_CHARGE} \t {$int_CHARGE_TOTAL} \t  {$int_NBSIN} \t {$int_NBPRIME} \t {$int_PART_CUMULE_PAYE} \t {$int_RATIO_COMBINE} \t {$int_SP} \t {$str_CLASSE_ROBUSTESSE} \t {$str_ANOMALIE} \t {$int_NSBIN_PRECEDENT} \t {$int_RATIO_COMBINE_PRECEDENT} \t {$bl_RENOUVELLE} \t {$int_REF_RENOUVELLEMENT} \t {$str_BLOCKRISQUE} \t {$str_DECISION_PROVISOIRE} \t {$int_POURCENTAGE_AJUST} \t {$str_DECISION_FINAL} \t {$int_NOUVELLE_PRIME} \t {$str_IDENTIFIANT} \t {$str_BRANCHE_ID} \t {$str_INTERMEDIAIRE_ID} {$str_INTERMEDIAIRE} \t {$int_PRIME_TTC} \t {$str_PHASE} \t {$int_PNETTEPRORATA} \r\n";
        //echo "{$str_NUMERO_POLICE} \t {$str_ANCIENNE_POL} \t  {$str_CODE_PARTENAIRE} \t {$str_CLIENT} \t {$str_PRODUIT} \t {$dt_DATE_EFFET} \t {$dt_FIN_GARANTIE} \t {$int_DUREE} \t {$int_PNETTE} \t {$int_CUMULE_PAYE} \t {$int_PROVISION_FIN} \t {$int_COMMISSION} \t {$int_AUTRE_CHARGE} \t {$int_CHARGE_TOTAL} \t  {$int_NBSIN} \t {$int_NBPRIME} \t {$int_PART_CUMULE_PAYE} \t {$int_RATIO_COMBINE} \t {$int_SP} \t {$str_CLASSE_ROBUSTESSE} \t {$str_ANOMALIE} \t {$int_NSBIN_PRECEDENT} \t {$int_RATIO_COMBINE_PRECEDENT} \t {$bl_RENOUVELLE} \t {$int_REF_RENOUVELLEMENT} \t {$str_BLOCKRISQUE} \t {$str_DECISION_PROVISOIRE} \t {$int_POURCENTAGE_AJUST} \t {$str_DECISION_FINAL} \t {$int_NOUVELLE_PRIME} \t {$str_IDENTIFIANT} \t {$str_BRANCHE_ID} \t {$str_INTERMEDIAIRE_ID} {$str_INTERMEDIAIRE} \t {$str_PHASE} \r\n";

        //exit();
        $db->beginTransaction();
        set_time_limit(0);
        $cpt_erreur = 0;
        $cpt = 0;
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";
        if (isset($_FILES['str_ILLUSTRATION']) && $_FILES['str_ILLUSTRATION']['error'] == 0)
        {
            //Testons la taille des fichiers par rapport à 2Mo = 2000000 octets
            if ($_FILES['str_ILLUSTRATION']['size'] <= 100000000) {
                $str_ILLUSTRATION = basename($_FILES['str_ILLUSTRATION']['name']);
                $extention = strtolower(substr(strrchr($_FILES['str_ILLUSTRATION']['name'], '.'), 1));
                $nom_crypter = sha1($str_ILLUSTRATION);
                $str_ILLUSTRATION = "documents/" . $nom_crypter . "." . $extention;
                $Resultmove = move_uploaded_file($_FILES['str_ILLUSTRATION']['tmp_name'], $str_ILLUSTRATION);
                $fileErreur = "documents/".$nom_crypter."-".date("Y-m-d")."-2-{$_SESSION['str_SECURITY_ID']}.err";
                $fichiers = fopen($fileErreur, "w");
                $fileSucces = "documents/".$nom_crypter."-".date("Y-m-d")."-2-{$_SESSION['str_SECURITY_ID']}.log";
                $fichiersSucces = fopen($fileSucces, "w");
                if($fichiers==false)
                    die ("Impossible de creer le fichier");
                if($fichiersSucces==false)
                    die ("Impossible de creer le fichier");

                if (/*$extention === "xls" || */ $extention === "xlsx") {
                    $file = $str_ILLUSTRATION;
                    $XLSXDocument = new PHPExcel_Reader_Excel2007();
                    //exit();
                    $objPHPExcel = $XLSXDocument->load($file);

                    $lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
                    $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
                    $i =0;
                    $mt_pnette = 0;
                    $met_cumule_paye = 0;
                    $mt_provision_fin = 0;
                    $mt_charge_total = 0;
                    $mt_autre_charge = 0;
                    $mt_nouvelle_prime = 0;
                    $mt_commission = 0;
                    $mt_bsin = 0;
                    $mt_nbprime = 0;
                    $mt_part_cumule_paye = 0;
                    $mt_prime_ttc = 0;

                    foreach ($rowIterator as $row) {
                        $rowIndex = $row->getRowIndex();
                        $str_COURRIER_IDS = RandomString();

                        $int_PNETTEPRORATAS = ($int_PNETTEPRORATA<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_PNETTEPRORATA}".$rowIndex)->getValue())):0);
                        $str_NUMERO_POLICES = ($str_NUMERO_POLICE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_NUMERO_POLICE}".$rowIndex)->getValue())):"");
                        $str_ANCIENNE_POLS = ($str_ANCIENNE_POL<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_ANCIENNE_POL}".$rowIndex)->getValue())):"");
                        $str_CODE_PARTENAIRES = ($str_CODE_PARTENAIRE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_CODE_PARTENAIRE}".$rowIndex)->getValue())):"");
                        $str_CLIENTS = ($str_CLIENT<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_CLIENT}".$rowIndex)->getValue())):"");
                        $str_PRODUITS = ($str_PRODUIT==""?"":htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_PRODUIT}".$rowIndex)->getValue())));

                        $dt_DATE_EFFETS = ($dt_DATE_EFFET<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$dt_DATE_EFFET}".$rowIndex)->getValue())):"");
                        $dt_FIN_GARANTIES = ($dt_FIN_GARANTIE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$dt_FIN_GARANTIE}".$rowIndex)->getValue())):"");
                        $dt_STATISTIQUES = ($dt_STATISTIQUE==""?"":htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$dt_STATISTIQUE}".$rowIndex)->getValue())));

                        if($i>0) {
                            $cell = $objPHPExcel->getActiveSheet()->getCell("{$dt_DATE_EFFET}" . $rowIndex);
                            $InvDate = $cell->getValue();
                            if (PHPExcel_Shared_Date::isDateTime($cell)) {
                                $dt_DATE_EFFETS = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                            }
                            $cell = $objPHPExcel->getActiveSheet()->getCell("{$dt_FIN_GARANTIE}" . $rowIndex);
                            $InvDate = $cell->getValue();
                            if (PHPExcel_Shared_Date::isDateTime($cell)) {
                                $dt_FIN_GARANTIES = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                            }
                            if(isset($dt_STATISTIQUE) && !empty($dt_STATISTIQUE))
                            {
                                $cell = $objPHPExcel->getActiveSheet()->getCell("{$dt_STATISTIQUE}" . $rowIndex);
                                $InvDate = $cell->getValue();
                                if (PHPExcel_Shared_Date::isDateTime($cell)) {
                                    $dt_STATISTIQUES = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                                }
                            }
                        }
//Il faut faire cela car sans ça l'intégration ne fonctionne pas
                        //echo $dt_STATISTIQUES.'<br/>';
                        if(empty($dt_STATISTIQUES)) $dt_STATISTIQUES = date("Y-m-d");
                        $int_DUREES = (int) ($int_DUREE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_DUREE}".$rowIndex)->getValue())):"");
                        $int_PNETTES = (int) ($int_PNETTE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_PNETTE}".$rowIndex)->getValue())):"");
                        $int_CUMULE_PAYES = (int) ($int_CUMULE_PAYE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_CUMULE_PAYE}".$rowIndex)->getValue())):"");
                        $int_PROVISION_FINS = (int) ($int_PROVISION_FIN<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_PROVISION_FIN}".$rowIndex)->getValue())):"");
                        $int_COMMISSIONS = (int) ($int_COMMISSION<>""?ceil(htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_COMMISSION}".$rowIndex)->getValue()))):"");
                        $int_AUTRE_CHARGES = (int) ($int_AUTRE_CHARGE<>""?ceil(htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_AUTRE_CHARGE}".$rowIndex)->getValue()))):"");
                        $int_CHARGE_TOTALS = (int) ($int_CHARGE_TOTAL<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_CHARGE_TOTAL}".$rowIndex)->getValue())):0);
                        $int_NBSINS = (int) ($int_NBSIN<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_NBSIN}".$rowIndex)->getValue())):0);

                        $int_NBPRIMES = (int) ($int_NBPRIME<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_NBPRIME}".$rowIndex)->getValue())):"");
                        $int_PART_CUMULE_PAYES = (int) ($int_PART_CUMULE_PAYE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_PART_CUMULE_PAYE}".$rowIndex)->getValue())):"");
                        $int_RATIO_COMBINES = (int) ($int_RATIO_COMBINE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_RATIO_COMBINE}".$rowIndex)->getValue())):"");
                        $int_SPS =  ($int_SP<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_SP}".$rowIndex)->getValue())):"");
                        $str_CLASSE_ROBUSTESSES = ($str_CLASSE_ROBUSTESSE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_CLASSE_ROBUSTESSE}".$rowIndex)->getValue())):"");
                        $str_ANOMALIES = ($str_ANOMALIE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_ANOMALIE}".$rowIndex)->getValue())):"");

                        $str_ANOMALIESS = 1;
                        if($str_ANOMALIES=="NA")
                            $str_ANOMALIESS = 0;

                        $int_NSBIN_PRECEDENTS = (int) ($int_NSBIN_PRECEDENT<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_NSBIN_PRECEDENT}".$rowIndex)->getValue())):"");
                        $int_RATIO_COMBINE_PRECEDENTS = (int) ($int_RATIO_COMBINE_PRECEDENT<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_RATIO_COMBINE_PRECEDENT}".$rowIndex)->getValue())):"");
                        $bl_RENOUVELLES = ($bl_RENOUVELLE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$bl_RENOUVELLE}".$rowIndex)->getValue())):1);
                        $int_REF_RENOUVELLEMENTS = (int) ($int_REF_RENOUVELLEMENT<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_REF_RENOUVELLEMENT}".$rowIndex)->getValue())):"");
                        $str_BLOCKRISQUES = ($str_BLOCKRISQUE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_BLOCKRISQUE}".$rowIndex)->getValue())):"");
                        $str_DECISION_PROVISOIRES = ($str_DECISION_PROVISOIRE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_DECISION_PROVISOIRE}".$rowIndex)->getValue())):"");
                        $int_POURCENTAGE_AJUSTS =  (int) ($int_POURCENTAGE_AJUST<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_POURCENTAGE_AJUST}".$rowIndex)->getValue())):"");
                        $str_DECISION_FINALS = ($str_DECISION_FINAL<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_DECISION_FINAL}".$rowIndex)->getValue())):"");
                        $int_NOUVELLE_PRIMES = (int) ($int_NOUVELLE_PRIME<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_NOUVELLE_PRIME}".$rowIndex)->getValue())):"");

                        $str_IDENTIFIANTS = ($str_IDENTIFIANT<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_IDENTIFIANT}".$rowIndex)->getValue())):"");
                        $str_BRANCHE_IDS = ($str_BRANCHE_ID<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_BRANCHE_ID}".$rowIndex)->getValue())):"");
                        $str_INTERMEDIAIRE_IDS = ($str_INTERMEDIAIRE_ID<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_INTERMEDIAIRE_ID}".$rowIndex)->getValue())):"");
                        $str_INTERMEDIAIRES = ($str_INTERMEDIAIRE<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_INTERMEDIAIRE}".$rowIndex)->getValue())):"");
                        $int_PRIME_TTCS = ($int_PRIME_TTC<>""?htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$int_PRIME_TTC}".$rowIndex)->getValue())):"");
                       // $str_PHASES = htmlspecialchars(trim($objPHPExcel->getActiveSheet()->getCell("{$str_PHASE}".$rowIndex)->getValue()));

                        $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
                        $sql = "INSERT INTO t_courrier (int_COURRIER_ID, str_COURRIER_ID, str_NUMERO_POLICE, str_ANCIENNE_POL, str_CODE_PARTENAIRE, str_CLIENT, str_PRODUIT, dt_DATE_EFFET, dt_FIN_GARANTIE, int_DUREE, int_PNETTE, int_CUMULE_PAYE, int_PROVISION_FIN, int_COMMISSION, int_AUTRE_CHARGE, int_CHARGE_TOTAL, int_NBSIN, int_NBPRIME, int_PART_CUMULE_PAYE, int_RATIO_COMBINE, int_SP, str_CLASSE_ROBUSTESSE, str_ANOMALIE, int_NSBIN_PRECEDENT, int_RATIO_COMBINE_PRECEDENT, bl_RENOUVELLE, int_REF_RENOUVELLEMENT, str_BLOCKRISQUE, str_DECISION_PROVISOIRE, int_POURCENTAGE_AJUST, str_DECISION_FINAL, int_NOUVELLE_PRIME, str_STATUT, str_CREATED_BY, dt_CREATED, str_IDENTIFIANT, str_BRANCHE_ID, str_INTERMEDIAIRE_ID, int_PRIME_TTC, int_PNETTEPRORATA, dt_STATISTIQUE, str_PHASE_ID) "
                                ." VALUES (NULL, :str_COURRIER_ID, :str_NUMERO_POLICE, :str_ANCIENNE_POL, :str_CODE_PARTENAIRE, :str_CLIENT, :str_PRODUIT, :dt_DATE_EFFET, :dt_FIN_GARANTIE, :int_DUREE, :int_PNETTE, :int_CUMULE_PAYE, :int_PROVISION_FIN, :int_COMMISSION, :int_AUTRE_CHARGE, :int_CHARGE_TOTAL, :int_NBSIN, :int_NBPRIME, :int_PART_CUMULE_PAYE, :int_RATIO_COMBINE, :int_SP, :str_CLASSE_ROBUSTESSE, :str_ANOMALIE, :int_NSBIN_PRECEDENT, :int_RATIO_COMBINE_PRECEDENT, :bl_RENOUVELLE, :int_REF_RENOUVELLEMENT, :str_BLOCKRISQUE, :str_DECISION_PROVISOIRE, :int_POURCENTAGE_AJUST, :str_DECISION_FINAL, :int_NOUVELLE_PRIME, :str_STATUT, :str_CREATED_BY, $dt_CREATED, :str_IDENTIFIANT, :str_BRANCHE_ID, :str_INTERMEDIAIRE_ID, :int_PRIME_TTC, :int_PNETTEPRORATA, :dt_STATISTIQUE, :str_PHASE_ID);";

                        if($i>0) {

                            $str_INTERMEDIAIRE_IDS = getIdIntermediaire($str_INTERMEDIAIRE_IDS, $str_INTERMEDIAIRES, $db);
                            $str_BRANCHE_IDS = getIdBranche($str_BRANCHE_IDS, $db);
                          /* echo $sql = "INSERT INTO t_courrier (int_COURRIER_ID, str_COURRIER_ID, str_NUMERO_POLICE, str_ANCIENNE_POL, str_CODE_PARTENAIRE, str_CLIENT, str_PRODUIT, dt_DATE_EFFET, dt_FIN_GARANTIE, int_DUREE, int_PNETTE, int_CUMULE_PAYE, int_PROVISION_FIN, int_COMMISSION, int_AUTRE_CHARGE, int_CHARGE_TOTAL, int_NBSIN, int_NBPRIME, int_PART_CUMULE_PAYE, int_RATIO_COMBINE, int_SP, str_CLASSE_ROBUSTESSE, str_ANOMALIE, int_NSBIN_PRECEDENT, int_RATIO_COMBINE_PRECEDENT, bl_RENOUVELLE, int_REF_RENOUVELLEMENT, str_BLOCKRISQUE, str_DECISION_PROVISOIRE, int_POURCENTAGE_AJUST, str_DECISION_FINAL, int_NOUVELLE_PRIME, str_STATUT, str_CREATED_BY, dt_CREATED, str_UPDATED_BY, dt_UPDATED, str_IDENTIFIANT, str_BRANCHE_ID, str_INTERMEDIAIRE_ID, str_PHASE_ID) "
                                ." VALUES (NULL, $str_COURRIER_IDS, $str_NUMERO_POLICES, $str_ANCIENNE_POLS, $str_CODE_PARTENAIRES, $str_CLIENTS, $str_PRODUITS, $dt_DATE_EFFETS, $dt_FIN_GARANTIES, $int_DUREES, $int_PNETTES, $int_CUMULE_PAYES, $int_PROVISION_FINS, $int_COMMISSIONS, $int_AUTRE_CHARGES, $int_CHARGE_TOTALS, $int_NBSINS, $int_NBPRIMES, $int_PART_CUMULE_PAYES, $int_RATIO_COMBINES, $int_SPS, $str_CLASSE_ROBUSTESSES, $str_ANOMALIESS, $int_NSBIN_PRECEDENTS, $int_RATIO_COMBINE_PRECEDENTS, $bl_RENOUVELLES, $int_REF_RENOUVELLEMENTS, $str_BLOCKRISQUES, $str_DECISION_PROVISOIRES, $int_POURCENTAGE_AJUSTS, $str_DECISION_FINALS, $int_NOUVELLE_PRIMES, $str_STATUT, {$_SESSION['str_SECURITY_ID']}, $dt_CREATED, $str_IDENTIFIANTS, $str_BRANCHE_IDS, $str_INTERMEDIAIRE_IDS, $str_PHASE);";

                             echo " str_ANOMALIES ".$str_ANOMALIES."int_NSBIN_PRECEDENTS " . $int_NSBIN_PRECEDENTS." int_RATIO_COMBINE_PRECEDENTS ".$int_RATIO_COMBINE_PRECEDENTS." bl_RENOUVELLES ". $bl_RENOUVELLES." int_REF_RENOUVELLEMENTS ".$int_REF_RENOUVELLEMENTS." str_BLOCKRISQUES ". $str_BLOCKRISQUES." str_DECISION_PROVISOIRES ". $str_DECISION_PROVISOIRES." int_POURCENTAGE_AJUSTS ". $int_POURCENTAGE_AJUSTS." str_DECISION_FINALS ".$str_DECISION_FINALS." int_NOUVELLE_PRIMES ".$int_NOUVELLE_PRIMES." str_STATUT ".$str_STATUT." dt_CREATED ".$dt_CREATED." str_IDENTIFIANTS ".$str_IDENTIFIANTS." str_BRANCHE_IDS ".$str_BRANCHE_IDS." str_INTERMEDIAIRE_IDS ".$str_INTERMEDIAIRE_IDS." str_PHASE ".$str_PHASE;
                             exit();
                            echo " str_ANOMALIES ".$str_ANOMALIESS."int_NSBIN_PRECEDENTS " . $int_NSBIN_PRECEDENTS." int_RATIO_COMBINE_PRECEDENTS ".$int_RATIO_COMBINE_PRECEDENTS." bl_RENOUVELLES ". $bl_RENOUVELLES." int_REF_RENOUVELLEMENTS ".$int_REF_RENOUVELLEMENTS." str_BLOCKRISQUES ". $str_BLOCKRISQUES." str_DECISION_PROVISOIRES ". $str_DECISION_PROVISOIRES." int_POURCENTAGE_AJUSTS ". $int_POURCENTAGE_AJUSTS." str_DECISION_FINALS ".$str_DECISION_FINALS." int_NOUVELLE_PRIMES ".$int_NOUVELLE_PRIMES." str_STATUT ".$str_STATUT." dt_CREATED ".$dt_CREATED." str_IDENTIFIANTS ".$str_IDENTIFIANTS." str_BRANCHE_IDS ".$str_BRANCHE_IDS." str_INTERMEDIAIRE_IDS ".$str_INTERMEDIAIRE_IDS." str_PHASE ".$str_PHASE;
*/
                            $int_PNETTEPRORATAS = str_replace(' ', '', $int_PNETTEPRORATAS);

                            if (!empty($str_COURRIER_IDS)) {
                                $str_PHASE_IDS = getIdPhase($str_PHASE, $db);
                                if (!empty($str_PHASE_IDS)) {
                                    if(!updateCourrier($str_NUMERO_POLICES, $str_ANCIENNE_POLS, $str_CODE_PARTENAIRES, $str_CLIENTS, $str_PRODUITS, $dt_DATE_EFFETS, $dt_FIN_GARANTIES, $int_DUREES, $int_PNETTES, $int_CUMULE_PAYES, $int_PROVISION_FINS, $int_COMMISSIONS, $int_AUTRE_CHARGES, $int_CHARGE_TOTALS, $int_NBSINS, $int_NBPRIMES, $int_PART_CUMULE_PAYES, $int_RATIO_COMBINES, $int_SPS, $str_CLASSE_ROBUSTESSES, $str_ANOMALIESS, $int_NSBIN_PRECEDENTS, $int_RATIO_COMBINE_PRECEDENTS, $bl_RENOUVELLES, $int_REF_RENOUVELLEMENTS, $str_BLOCKRISQUES, $str_DECISION_PROVISOIRES, $int_POURCENTAGE_AJUSTS, $str_DECISION_FINALS, $int_NOUVELLE_PRIMES, $str_IDENTIFIANTS, $str_BRANCHE_IDS, $str_INTERMEDIAIRES, $str_INTERMEDIAIRE_IDS, $int_PRIME_TTCS, $str_PHASE_IDS, $int_PNETTEPRORATAS, $dt_STATISTIQUES, $db))
                                    {
                                        //var_dump($int_PNETTEPRORATAS);
                                        try {
                                            $stmt = $db->prepare($sql);
                                            //echo "Try it############";
                                            $stmt->BindParam(':str_COURRIER_ID', $str_COURRIER_IDS);
                                            $stmt->BindParam(':str_NUMERO_POLICE', $str_NUMERO_POLICES);
                                            $stmt->BindParam(':str_ANCIENNE_POL', $str_ANCIENNE_POLS);
                                            $stmt->BindParam(':str_CODE_PARTENAIRE', $str_CODE_PARTENAIRES);
                                            $stmt->BindParam(':str_CLIENT', $str_CLIENTS);
                                            $stmt->BindParam(':str_PRODUIT', $str_PRODUITS);
                                            $stmt->BindParam(':dt_DATE_EFFET', $dt_DATE_EFFETS);
                                            $stmt->BindParam(':dt_FIN_GARANTIE', $dt_FIN_GARANTIES);
                                            $stmt->BindParam(':int_DUREE', $int_DUREES);
                                            $stmt->BindParam(':int_PNETTE', $int_PNETTES);
                                            $stmt->BindParam(':int_CUMULE_PAYE', $int_CUMULE_PAYES);
                                            $stmt->BindParam(':int_PROVISION_FIN', $int_PROVISION_FINS);
                                            $stmt->BindParam(':int_COMMISSION', $int_COMMISSIONS);
                                            $stmt->BindParam(':int_AUTRE_CHARGE', $int_AUTRE_CHARGES);
                                            $stmt->BindParam(':int_CHARGE_TOTAL', $int_CHARGE_TOTALS);
                                            $stmt->BindParam(':int_NBSIN', $int_NBSINS);
                                            $stmt->BindParam(':int_NBPRIME', $int_NBPRIMES);
                                            $stmt->BindParam(':int_PART_CUMULE_PAYE', $int_PART_CUMULE_PAYES);
                                            $stmt->BindParam(':int_RATIO_COMBINE', $int_RATIO_COMBINES);
                                            $stmt->BindParam(':int_SP', $int_SPS);
                                            $stmt->BindParam(':str_CLASSE_ROBUSTESSE', $str_CLASSE_ROBUSTESSES);
                                            $stmt->BindParam(':str_ANOMALIE', $str_ANOMALIESS);
                                            $stmt->BindParam(':int_NSBIN_PRECEDENT', $int_NSBIN_PRECEDENTS);
                                            $stmt->BindParam(':int_RATIO_COMBINE_PRECEDENT', $int_RATIO_COMBINE_PRECEDENTS);
                                            $stmt->BindParam(':bl_RENOUVELLE', $bl_RENOUVELLES);
                                            $stmt->BindParam(':int_REF_RENOUVELLEMENT', $int_REF_RENOUVELLEMENTS);
                                            $stmt->BindParam(':str_BLOCKRISQUE', $str_BLOCKRISQUES);
                                            $stmt->BindParam(':str_DECISION_PROVISOIRE', $str_DECISION_PROVISOIRES);
                                            $stmt->BindParam(':int_POURCENTAGE_AJUST', $int_POURCENTAGE_AJUSTS);
                                            $stmt->BindParam(':str_DECISION_FINAL', $str_DECISION_FINALS);
                                            $stmt->BindParam(':int_NOUVELLE_PRIME', $int_NOUVELLE_PRIMES);
                                            $stmt->BindParam(':str_STATUT', $str_STATUT);
                                            $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_SECURITY_ID']);
                                            //$stmt->BindParam(':dt_CREATED', $dt_CREATED);
                                            $stmt->BindParam(':str_IDENTIFIANT', $str_IDENTIFIANTS);
                                            $stmt->BindParam(':str_BRANCHE_ID', $str_BRANCHE_IDS);
                                            $stmt->BindParam(':str_INTERMEDIAIRE_ID', $str_INTERMEDIAIRE_IDS);
                                            $stmt->BindParam(':int_PRIME_TTC', $int_PRIME_TTCS);
                                            $stmt->BindParam(':int_PNETTEPRORATA', $int_PNETTEPRORATAS); //Mis à jour le 30/11/2018
                                            $stmt->BindParam(':dt_STATISTIQUE', $dt_STATISTIQUES);

                                            $stmt->BindParam(':str_PHASE_ID', $str_PHASE_IDS);

                                            //var_dump($stmt->execute());
                                            if ($stmt->execute()) {
                                                $cpt++;
                                                $current_ok = "{$str_NUMERO_POLICES} \t {$str_ANCIENNE_POLS} \t  {$str_CODE_PARTENAIRES} \t {$str_CLIENTS} \t {$str_PRODUITS} \t {$dt_DATE_EFFETS} \t {$dt_FIN_GARANTIES} \t {$int_DUREES} \t {$int_PNETTES} \t {$int_CUMULE_PAYES} \t {$int_PROVISION_FINS} \t {$int_COMMISSIONS} \t {$int_AUTRE_CHARGES} \t {$int_CHARGE_TOTALS} \t  {$int_NBSINS} \t {$int_NBPRIMES} \t {$int_PART_CUMULE_PAYES} \t {$int_RATIO_COMBINES} \t {$int_SPS} \t {$str_CLASSE_ROBUSTESSES} \t {$str_ANOMALIES} \t {$int_NSBIN_PRECEDENTS} \t {$int_RATIO_COMBINE_PRECEDENTS} \t {$bl_RENOUVELLES} \t {$int_REF_RENOUVELLEMENTS} \t {$str_BLOCKRISQUES} \t {$str_DECISION_PROVISOIRES} \t {$int_POURCENTAGE_AJUSTS} \t {$str_DECISION_FINALS} \t {$int_NOUVELLE_PRIMES} \t {$str_IDENTIFIANTS} \t {$str_BRANCHE_IDS} \t {$str_INTERMEDIAIRE_IDS} \t {$str_PHASE} \r\n";
                                                fputs($fichiersSucces, $current_ok);
                                                $mt_pnette += $int_PNETTES;
                                                $met_cumule_paye += $int_CUMULE_PAYES;
                                                $mt_provision_fin += $int_PROVISION_FINS;
                                                $mt_charge_total += $int_CHARGE_TOTALS;
                                                $mt_autre_charge += $int_AUTRE_CHARGES;
                                                $mt_nouvelle_prime += $int_NOUVELLE_PRIMES;
                                                $mt_commission += $int_COMMISSIONS;
                                                $mt_bsin += $int_NBSINS;
                                                $mt_nbprime += $int_NBPRIMES;
                                                $mt_part_cumule_paye += $int_PART_CUMULE_PAYES;
                                                $mt_prime_ttc += $int_PRIME_TTCS;
                                                $message = "L'insertion a été effectué avec succès. il y a {$cpt} lignes en base de données. Il y a eu {{$cpt_erreur}} erreurs";
                                                $code_statut = "1";

                                            } else {
                                                $cpt_erreur++;
                                                $message = "enregistrement impossible, il y a {$cpt_erreur} erreurs";
                                                $code_statut = "0";
                                            }
                                        } catch (PDOException $e) {
                                            die("Erreur ! : " . $e->getMessage());
                                        }
                                    }
                                    else
                                    {
                                        $cpt++;
                                        $current_ok = "{$str_NUMERO_POLICES} \t {$str_ANCIENNE_POLS} \t  {$str_CODE_PARTENAIRES} \t {$str_CLIENTS} \t {$str_PRODUITS} \t {$dt_DATE_EFFETS} \t {$dt_FIN_GARANTIES} \t {$int_DUREES} \t {$int_PNETTES} \t {$int_CUMULE_PAYES} \t {$int_PROVISION_FINS} \t {$int_COMMISSIONS} \t {$int_AUTRE_CHARGES} \t {$int_CHARGE_TOTALS} \t  {$int_NBSINS} \t {$int_NBPRIMES} \t {$int_PART_CUMULE_PAYES} \t {$int_RATIO_COMBINES} \t {$int_SPS} \t {$str_CLASSE_ROBUSTESSES} \t {$str_ANOMALIES} \t {$int_NSBIN_PRECEDENTS} \t {$int_RATIO_COMBINE_PRECEDENTS} \t {$bl_RENOUVELLES} \t {$int_REF_RENOUVELLEMENTS} \t {$str_BLOCKRISQUES} \t {$str_DECISION_PROVISOIRES} \t {$int_POURCENTAGE_AJUSTS} \t {$str_DECISION_FINALS} \t {$int_NOUVELLE_PRIMES} \t {$str_IDENTIFIANTS} \t {$str_BRANCHE_IDS} \t {$str_INTERMEDIAIRE_IDS} \t {$str_PHASE} \r\n";
                                        fputs($fichiersSucces, $current_ok);
                                        $mt_pnette += $int_PNETTES;
                                        $met_cumule_paye += $int_CUMULE_PAYES;
                                        $mt_provision_fin += $int_PROVISION_FINS;
                                        $mt_charge_total += $int_CHARGE_TOTALS;
                                        $mt_autre_charge += $int_AUTRE_CHARGES;
                                        $mt_nouvelle_prime += $int_NOUVELLE_PRIMES;
                                        $mt_commission += $int_COMMISSIONS;
                                        $mt_bsin += $int_NBSINS;
                                        $mt_nbprime += $int_NBPRIMES;
                                        $mt_part_cumule_paye += $int_PART_CUMULE_PAYES;
                                        $mt_prime_ttc += $int_PRIME_TTCS;
                                        $message = "{$cpt} ligne identique ont été mise à jours. Il y a eu {{$cpt_erreur}} erreurs";
                                        $code_statut = "1";
                                    }
                                } else {
                                    die("Erreur ! : Aucune phase n'a été retrouvé...");
                                }
                            }
                        }
                        $i++;
                    }
                }
                else {
                    $message = "Erreur, veuillez selectionner un fichier avec l'extension 'excel'\r\n";
                    fputs ($fichiers, $message);
                }
            }
            else{
                echo "je ne suis pas supporté";
                return;
            }
            $i--;
            //conclusion fichier intégration reussi
            $message = "TOTAL MIS A JOUR SUR TOTAL LU : {$cpt}/{$i}\r\n";
            $message .= "MONTANT TOTAL CUMULE PAYE : {$met_cumule_paye}\r\n";
            $message .= "MONTANT TOTAL PRIME NETTE : {$mt_pnette}\r\n";
            $message .= "MONTANT TOTAL CHARGE TOTAL : {$mt_charge_total}\r\n";
            $message .= "MONTANT TOTAL AUTRE CHARGE : {$mt_autre_charge}\r\n";
            $message .= "MONTANT TOTAL NOUVELLE PRIME : {$mt_nouvelle_prime}\r\n";
            $message .= "MONTANT TOTAL PROVISION FIN : {$mt_provision_fin}\r\n";
            $message .= "MONTANT TOTAL COMMISSION : {$mt_commission}\r\n";
            $message .= "MONTANT TOTAL BSIN : {$mt_bsin}\r\n";
            $message .= "MONTANT TOTAL TTC : {$mt_prime_ttc}\r\n";
            $message .= "MONTANT TOTAL NB PRIME : {$mt_nbprime}\r\n";
            $message .= "MONTANT TOTAL PART CUMULE PAYE : {$mt_part_cumule_paye}\r\n";
            $message .= "PHASE : {$str_PHASE}\r\n";

            fputs ($fichiersSucces, $current_ok);
            fputs ($fichiersSucces, $message);
            fclose ($fichiersSucces);
        }
        $db->commit();
        $arrayJson["results"] = $message;
        $arrayJson["code_statut"] = $code_statut;
        $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function isExistIndentifiant($str_IDENTIFIANTS, $db){
        $str_STATUT = 'delete';
        $str_IDENTIFIANTS = $db->quote($str_IDENTIFIANTS);
        $sql = "SELECT * FROM t_courrier WHERE str_IDENTIFIANT LIKE " . $str_IDENTIFIANTS . " AND str_STATUT <> '" . $str_STATUT . "';";

        if(!empty($str_IDENTIFIANTS)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function updateCourrier($str_NUMERO_POLICES, $str_ANCIENNE_POLS, $str_CODE_PARTENAIRES, $str_CLIENTS, $str_PRODUITS, $dt_DATE_EFFETS, $dt_FIN_GARANTIES, $int_DUREES, $int_PNETTES, $int_CUMULE_PAYES, $int_PROVISION_FINS, $int_COMMISSIONS, $int_AUTRE_CHARGES, $int_CHARGE_TOTALS, $int_NBSINS, $int_NBPRIMES, $int_PART_CUMULE_PAYES, $int_RATIO_COMBINES, $int_SPS, $str_CLASSE_ROBUSTESSES, $str_ANOMALIESS, $int_NSBIN_PRECEDENTS, $int_RATIO_COMBINE_PRECEDENTS, $bl_RENOUVELLES, $int_REF_RENOUVELLEMENTS, $str_BLOCKRISQUES, $str_DECISION_PROVISOIRES, $int_POURCENTAGE_AJUSTS, $str_DECISION_FINALS, $int_NOUVELLE_PRIMES, $str_IDENTIFIANTS, $str_BRANCHE_IDS, $str_INTERMEDIAIRES, $str_INTERMEDIAIRE_IDS, $int_PRIME_TTCS, $str_PHASE_IDS, $int_PNETTEPRORATAS, $dt_STATISTIQUES, $db)
    {

        //var_dump(isExistIndentifiant($str_IDENTIFIANTS, $db));
        if(isExistIndentifiant($str_IDENTIFIANTS, $db))
        {
            //echo "Update it ###########";
            $dt_STATISTIQUES = $db->quote($dt_STATISTIQUES);
            $str_NUMERO_POLICES = $db->quote($str_NUMERO_POLICES);
            $str_ANCIENNE_POLS = $db->quote($str_ANCIENNE_POLS);
            $str_CODE_PARTENAIRES = $db->quote($str_CODE_PARTENAIRES);
            $str_CLIENTS = $db->quote($str_CLIENTS);
            $str_PRODUITS = $db->quote($str_PRODUITS);
            $dt_DATE_EFFETS = $db->quote($dt_DATE_EFFETS);
            $dt_FIN_GARANTIES = $db->quote($dt_FIN_GARANTIES);
            $int_DUREES = $db->quote($int_DUREES);
            $int_PNETTES = $db->quote($int_PNETTES);
            $int_CUMULE_PAYES = $db->quote($int_CUMULE_PAYES);
            $int_PROVISION_FINS = $db->quote($int_PROVISION_FINS);
            $int_COMMISSIONS = $db->quote($int_COMMISSIONS);
            $int_AUTRE_CHARGES = $db->quote($int_AUTRE_CHARGES);
            $int_CHARGE_TOTALS = $db->quote($int_CHARGE_TOTALS);
            $int_NBSINS = $db->quote($int_NBSINS);
            $int_NBPRIMES = $db->quote($int_NBPRIMES);
            $int_PART_CUMULE_PAYES = $db->quote($int_PART_CUMULE_PAYES);
            $int_RATIO_COMBINES = $db->quote($int_RATIO_COMBINES);
            $int_SPS = $db->quote($int_SPS);
            $str_CLASSE_ROBUSTESSES = $db->quote($str_CLASSE_ROBUSTESSES);
            $str_ANOMALIESS = $db->quote($str_ANOMALIESS);
            $int_NSBIN_PRECEDENTS = $db->quote($int_NSBIN_PRECEDENTS);
            $int_RATIO_COMBINE_PRECEDENTS = $db->quote($int_RATIO_COMBINE_PRECEDENTS);
            $bl_RENOUVELLES = $db->quote($bl_RENOUVELLES);
            $int_REF_RENOUVELLEMENTS = $db->quote($int_REF_RENOUVELLEMENTS);
            $str_BLOCKRISQUES = $db->quote($str_BLOCKRISQUES);
            $str_DECISION_PROVISOIRES = $db->quote($str_DECISION_PROVISOIRES);
            $int_POURCENTAGE_AJUSTS = $db->quote($int_POURCENTAGE_AJUSTS);
            $str_DECISION_FINALS = $db->quote($str_DECISION_FINALS);
            $int_NOUVELLE_PRIMES = $db->quote($int_NOUVELLE_PRIMES);
            $str_IDENTIFIANTS = $db->quote($str_IDENTIFIANTS);
            $str_BRANCHE_IDS = $db->quote($str_BRANCHE_IDS);
            $str_INTERMEDIAIRES = $db->quote($str_INTERMEDIAIRES);
            $str_INTERMEDIAIRE_IDS = $db->quote($str_INTERMEDIAIRE_IDS);
            $int_PRIME_TTCS = $db->quote($int_PRIME_TTCS);
            $str_PHASE_IDS = $db->quote($str_PHASE_IDS);
            $int_PNETTEPRORATAS = $db->quote($int_PNETTEPRORATAS);
            $str_UPDATED_BY = $db->quote($_SESSION['str_SECURITY_ID']);
            $sql = "UPDATE t_courrier "
                . "SET str_NUMERO_POLICE = $str_NUMERO_POLICES,"
                . " str_ANCIENNE_POL = $str_ANCIENNE_POLS,"
                . " str_CODE_PARTENAIRE = $str_CODE_PARTENAIRES,"
                . " str_CLIENT = $str_CLIENTS,"
                . " str_PRODUIT = $str_PRODUITS,"
                . " dt_DATE_EFFET = $dt_DATE_EFFETS,"
                . " dt_FIN_GARANTIE = $dt_FIN_GARANTIES,"
                . " int_DUREE = $int_DUREES,"
                . " int_PNETTE = $int_PNETTES,"
                . " int_CUMULE_PAYE = $int_CUMULE_PAYES,"
                . " int_PROVISION_FIN = $int_PROVISION_FINS,"
                . " int_COMMISSION = $int_COMMISSIONS,"
                . " int_AUTRE_CHARGE = $int_AUTRE_CHARGES,"
                . " int_CHARGE_TOTAL = $int_CHARGE_TOTALS,"
                . " int_NBSIN = $int_NBSINS,"
                . " int_NBPRIME = $int_NBPRIMES,"
                . " int_PART_CUMULE_PAYE = $int_PART_CUMULE_PAYES,"
                . " int_RATIO_COMBINE = $int_RATIO_COMBINES,"
                . " int_SP = $int_SPS,"
                . " str_CLASSE_ROBUSTESSE = $str_CLASSE_ROBUSTESSES,"
                . " str_ANOMALIE = $str_ANOMALIESS,"
                . " int_NSBIN_PRECEDENT = $int_NSBIN_PRECEDENTS,"
                . " int_RATIO_COMBINE_PRECEDENT = $int_RATIO_COMBINE_PRECEDENTS,"
                . " bl_RENOUVELLE = $bl_RENOUVELLES,"
                . " int_REF_RENOUVELLEMENT = $int_REF_RENOUVELLEMENTS,"
                . " str_BLOCKRISQUE = $str_BLOCKRISQUES,"
                . " str_DECISION_PROVISOIRE = $str_DECISION_PROVISOIRES,"
                . " int_POURCENTAGE_AJUST = $int_POURCENTAGE_AJUSTS,"
                . " str_DECISION_FINAL = $str_DECISION_FINALS,"
                . " int_NOUVELLE_PRIME = $int_NOUVELLE_PRIMES,"
                . " str_BRANCHE_ID = $str_BRANCHE_IDS,"
                . " str_INTERMEDIAIRE_ID = $str_INTERMEDIAIRE_IDS,"
                . " int_PRIME_TTC = $int_PRIME_TTCS,"
                . " int_PNETTEPRORATA = $int_PNETTEPRORATAS,"
                . " dt_STATISTIQUE = $dt_STATISTIQUES,"
                . " str_PHASE_ID = $str_PHASE_IDS,"
                . "str_UPDATED_BY = $str_UPDATED_BY, "
                . "dt_UPDATED = '" . gmdate("Y-m-d, H:i:s") . "' "
                . "WHERE str_IDENTIFIANT = $str_IDENTIFIANTS";
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

            return true;
        }
        return false;
    }
    function isExistIdentifiant($str_IDENTIFIANT, $db) {
        $str_STATUT = 'delete';
        $str_IDENTIFIANT = $db->quote($str_IDENTIFIANT);
        $sql = "SELECT str_INDENTIFIANT FROM t_courrier WHERE str_INDENTIFIANT LIKE " . $str_IDENTIFIANT . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_IDENTIFIANT)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function getAllCourriers($str_COURRIER_ID, $str_INTERMEDIAIRE_ID, $str_BRANCHE_ID, $str_PHASE_ID, $str_DATE_DEBUT, $str_DATE_FIN, $str_POLICE, $db){
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;
        if ($str_COURRIER_ID == "" || $str_COURRIER_ID == null) {
            $str_COURRIER_ID = "%%";
        }
        $str_COURRIER_ID = $db -> quote($str_COURRIER_ID);
        if ($str_INTERMEDIAIRE_ID == "" || $str_INTERMEDIAIRE_ID == null) {
            $str_INTERMEDIAIRE_ID = "%%";
        }
        if ($str_BRANCHE_ID == "" || $str_BRANCHE_ID == null) {
            $str_BRANCHE_ID = "%%";
        }
        if ($str_PHASE_ID == "" || $str_PHASE_ID == null) {
            $str_PHASE_ID = "%%";
        }
        if ($str_POLICE == "" || $str_POLICE == null) {
            $str_POLICE = "%%";
        }
        $str_POLICE = $db -> quote($str_POLICE);

        $str_INTERMEDIAIRE_ID = $db->quote($str_INTERMEDIAIRE_ID);
        $str_BRANCHE_ID = $db->quote($str_BRANCHE_ID);
        $str_PHASE_ID = $db->quote($str_PHASE_ID);

        if( ($str_DATE_DEBUT<>'' or $str_DATE_DEBUT<>null) and ($str_DATE_FIN<>'' or $str_DATE_FIN<> null)){
            $str_DATE_DEBUT = $db->quote($str_DATE_DEBUT);
            $str_DATE_FIN = $db->quote($str_DATE_FIN);
            if ($str_DATE_DEBUT == "" || $str_DATE_DEBUT == null) {
                $str_DATE_DEBUT = "%%";
            }
            if ($str_DATE_FIN == "" || $str_DATE_FIN == null) {
                $str_DATE_FIN = "%%";
            }
            $sql = "SELECT * "
                ."FROM v_courriers "
                ."WHERE str_INTERMEDIAIRE_ID LIKE $str_INTERMEDIAIRE_ID AND str_BRANCHE_ID LIKE $str_BRANCHE_ID AND dt_FIN_GARANTIE between $str_DATE_DEBUT AND $str_DATE_FIN AND str_PHASE_ID LIKE $str_PHASE_ID  AND str_NUMERO_POLICE LIKE $str_POLICE  ";

        }
        else{
            if($str_DATE_DEBUT<>''){
                if ($str_DATE_DEBUT == "" || $str_DATE_DEBUT == null) {
                    $str_DATE_DEBUT = "%%";
                }
                $str_DATE_DEBUT = $db->quote($str_DATE_DEBUT);

                $sql = "SELECT * "
                    ."FROM v_courriers "
                    ."WHERE str_INTERMEDIAIRE_ID LIKE $str_INTERMEDIAIRE_ID AND str_BRANCHE_ID LIKE $str_BRANCHE_ID AND dt_FIN_GARANTIE LIKE $str_DATE_DEBUT AND str_PHASE_ID LIKE $str_PHASE_ID  AND str_NUMERO_POLICE LIKE $str_POLICE  ";

            }
            else{
                if ($str_DATE_FIN == "" || $str_DATE_FIN == null) {
                    $str_DATE_FIN = "%%";
                }
                $str_DATE_FIN = $db->quote($str_DATE_FIN);

                $sql = "SELECT * "
                    ."FROM v_courriers "
                    ."WHERE str_INTERMEDIAIRE_ID LIKE $str_INTERMEDIAIRE_ID AND str_BRANCHE_ID LIKE $str_BRANCHE_ID AND dt_FIN_GARANTIE LIKE $str_DATE_FIN AND str_PHASE_ID LIKE $str_PHASE_ID  AND str_NUMERO_POLICE LIKE $str_POLICE  ";

            }
        }
        //echo $sql;
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
        echo "[" . json_encode($arrayJson) . "]";
    }


    function getIdPhase($str_PHASE_ID, $db){
        $str_STATUT = 'delete';
        $str_PHASE_ID = $db->quote($str_PHASE_ID);
        $sql = "SELECT * FROM t_phase WHERE str_PHASE_ID LIKE " . $str_PHASE_ID . " AND str_STATUT <> '" . $str_STATUT . "'";

        if(!empty($str_PHASE_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    foreach ($result as $item_result) {
                        return $item_result['str_PHASE_ID'];
                    }
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function getIdBranche($str_BRANCHE, $db){
        $str_STATUT = 'delete';
        $str_BRANCHE = $db->quote($str_BRANCHE);
        $sql = "SELECT * FROM t_branche WHERE str_LIBELLE LIKE " . $str_BRANCHE . " AND str_STATUT <> '" . $str_STATUT . "'";

        if(!empty($str_BRANCHE)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    foreach ($result as $item_result) {
                        return $item_result['str_BRANCHE_ID'];
                    }
                }
                else{
                    $str_BRANCHE = str_replace("'", "", $str_BRANCHE);
                    return addBranche($db, $str_BRANCHE);
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function getIdIntermediaire($str_INTERMEDIAIRE_ID, $str_INTERMEDIAIRE, $db){
        $str_STATUT = 'delete';
        $str_INTERMEDIAIRE_ID = htmlentities(trim($str_INTERMEDIAIRE_ID));
        $str_INTERMEDIAIRE = htmlentities(trim($str_INTERMEDIAIRE));
        $str_CODE = $str_INTERMEDIAIRE_ID;
        $str_LIBELLE = $str_INTERMEDIAIRE;
        $str_INTERMEDIAIRE_ID = $db->quote($str_INTERMEDIAIRE_ID);
        $str_INTERMEDIAIRE = $db->quote($str_INTERMEDIAIRE);
        $sql = "SELECT * FROM t_intermediaire WHERE str_CODE LIKE " . $str_INTERMEDIAIRE_ID . " AND str_LIBELLE LIKE " . $str_INTERMEDIAIRE . " AND str_STATUT <> '" . $str_STATUT . "'";

        if(!empty($str_INTERMEDIAIRE_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    foreach ($result as $item_result) {
                        return $item_result['str_INTERMEDIAIRE_ID'];
                    }
                }
                else{
                    $str_CODE = substr($str_CODE, 0, 250);
                    $str_LIBELLE = substr($str_LIBELLE, 0, 250);
                    return addIntermediaire($db, $str_CODE, $str_LIBELLE);
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function addIntermediaire($db, $str_CODE, $str_LIBELLE) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";
        $str_INTERMEDIAIRE_ID = RandomString();

        $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
        $sql = "INSERT INTO t_intermediaire(str_INTERMEDIAIRE_ID, str_CODE, str_LIBELLE,  str_STATUT, dt_CREATED, str_CREATED_BY)"
            . "VALUES (:str_INTERMEDIAIRE_ID, :str_CODE, :str_LIBELLE, :str_STATUT,$dt_CREATED,:str_CREATED_BY)";
        try {
            if (!isExistCodeIntermediaire($str_INTERMEDIAIRE_ID, $db)) {

                $stmt = $db->prepare($sql);
                $str_STATUT = "enable";
                $stmt->BindParam(':str_INTERMEDIAIRE_ID', $str_INTERMEDIAIRE_ID);
                $stmt->BindParam(':str_CODE', $str_CODE);
                $stmt->BindParam(':str_LIBELLE', $str_LIBELLE);
                $stmt->BindParam(':str_STATUT', $str_STATUT);
                $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_SECURITY_ID']);

                if ($stmt->execute()) {
                    $message = "Insertion effectué avec succès";
                    $code_statut = "1";
                } else {
                    $message = "Erreur lors de l'insertion";
                    $code_statut = "0";
                }
            } else {
                $message = "Ce Code  : \" " . $str_INTERMEDIAIRE_ID . " \" de table existe déja! \r\n";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }

        return $str_INTERMEDIAIRE_ID;
    }
    function isExistCodeIntermediaire($str_INTERMEDIAIRE_ID, $db) {
        $str_STATUT = 'delete';
        $str_INTERMEDIAIRE_ID = $db->quote($str_INTERMEDIAIRE_ID);
        $sql = "SELECT * FROM t_intermediaire WHERE str_INTERMEDIAIRE_ID LIKE " . $str_INTERMEDIAIRE_ID . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_INTERMEDIAIRE_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function addBranche($db, $str_LIBELLE) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";
        $str_BRANCHE_ID = RandomString();

        $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
        $sql = "INSERT INTO t_branche(str_BRANCHE_ID, str_LIBELLE,  str_STATUT, dt_CREATED, str_CREATED_BY)"
            . "VALUES (:str_BRANCHE_ID, :str_LIBELLE, :str_STATUT,$dt_CREATED,:str_CREATED_BY)";
        try {
            if (!isExistCodeBranche($str_BRANCHE_ID, $db)) {

                $stmt = $db->prepare($sql);
                $str_STATUT = "enable";
                $stmt->BindParam(':str_BRANCHE_ID', $str_BRANCHE_ID);
                $stmt->BindParam(':str_LIBELLE', $str_LIBELLE);
                $stmt->BindParam(':str_STATUT', $str_STATUT);
                $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_SECURITY_ID']);
                //var_dump($stmt);
                if ($stmt->execute()) {
                    $message = "Insertion effectué avec succès";
                    $code_statut = "1";
                } else {
                    $message = "Erreur lors de l'insertion";
                    $code_statut = "0";
                }
            } else {
                $message = "Ce Code  : \" " . $str_BRANCHE_ID . " \" de table existe déja! \r\n";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }

        return $str_BRANCHE_ID;
    }
    function isExistCodeBranche($str_BRANCHE_ID, $db) {
        $str_STATUT = 'delete';
        $str_BRANCHE_ID = $db->quote($str_BRANCHE_ID);
        $sql = "SELECT * FROM t_branche WHERE str_BRANCHE_ID LIKE " . $str_BRANCHE_ID . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_BRANCHE_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    function addHash($str_FILE, $str_INTERMEDIAIRE_NAME, $str_CLIENT_NAME, $str_FILE_RAR, $str_INTERMEDIAIRE_ID, $int_COURRIER_ID, $str_NUMERO_POLICE, $str_PERIODE, $int_PRIME_TTC, $db) {

        $int_NUMBER_EXTRACT = getNumberExtraction($int_COURRIER_ID, $db);

        if(!empty($int_NUMBER_EXTRACT) && $int_NUMBER_EXTRACT > 0)
        {
            $str_EXTRACTION_ID = RandomString();

            $str_PARAM = "Intermédiaire : " .$str_INTERMEDIAIRE_NAME." | client : ".$str_CLIENT_NAME." | numero de police : ".$str_NUMERO_POLICE." | Periode : ".$str_PERIODE." | Prime TTC : ".$int_PRIME_TTC;
            $dt_CREATED = $db->quote(gmdate("Y-m-d, H:i:s"));
            $sql = "INSERT INTO t_extraction(str_EXTRACTION_ID, str_FILE, str_PARAM, int_NUMBER_EXTRACT, str_RAR, str_STATUT, str_CREATED_BY, dt_CREATED, str_INTERMEDIAIRE_ID, pk_COURRIER_ID) "
                . "VALUES (:str_EXTRACTION_ID, :str_FILE, :str_PARAM, :int_NUMBER_EXTRACT, :str_RAR, :str_STATUT, :str_CREATED_BY, $dt_CREATED, :str_INTERMEDIAIRE_ID, :pk_COURRIER_ID)";

            try {
                if (!isExistCodeHash($str_EXTRACTION_ID, $db)) {

                    $stmt = $db->prepare($sql);
                    $str_STATUT = "enable";
                    $int_COURRIER_ID = str_replace("'", " ", $int_COURRIER_ID);
                    $stmt->BindParam(':str_EXTRACTION_ID', $str_EXTRACTION_ID);
                    $stmt->BindParam(':str_FILE', $str_FILE);
                    $stmt->BindParam(':str_PARAM', $str_PARAM);
                    $stmt->BindParam(':int_NUMBER_EXTRACT', $int_NUMBER_EXTRACT);
                    $stmt->BindParam(':str_RAR', $str_FILE_RAR);
                    $stmt->BindParam(':str_STATUT', $str_STATUT);
                    $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_SECURITY_ID']);
                    $stmt->BindParam(':str_INTERMEDIAIRE_ID', $str_INTERMEDIAIRE_ID);
                    $stmt->BindParam(':pk_COURRIER_ID', $int_COURRIER_ID);
                    //var_dump($stmt);
                    if ($stmt->execute()) {
                        return $str_EXTRACTION_ID;
                    } else {
                        return "Erreur HASH";
                    }
                } else {
                    $message = "Ce Code  : \" " . $str_EXTRACTION_ID . " \" de table existe déja! \r\n";
                    $code_statut = "0";
                }
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
            }

        }
    }
    function isExistCodeHash($str_EXTRACTION_ID, $db) {
        $str_STATUT = 'delete';
        $str_EXTRACTION_ID = $db->quote($str_EXTRACTION_ID);
        $sql = "SELECT * FROM t_extraction WHERE str_EXTRACTION_ID LIKE " . $str_EXTRACTION_ID . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_EXTRACTION_ID)){
            try {
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
    function getNumberExtraction($str_COURRIER_ID, $db){
        $str_STATUT = 'delete';
        $int_NUMBER_EXTRACT = 1;
        $dt_UPDATED = $db->quote(gmdate("Y-m-d, H:i:s"));
        $str_UPDATED_BY = $db->quote($_SESSION['str_SECURITY_ID']);
        $str_COURRIER_ID = $db->quote($str_COURRIER_ID);
        $sql = "SELECT * FROM t_extraction WHERE pk_COURRIER_ID LIKE " . $str_COURRIER_ID . " AND str_STATUT <> '" . $str_STATUT . "'";
        if(!empty($str_COURRIER_ID)){
            try {
                //echo $sql;
                $stmt = $db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    $int_NUMBER_EXTRACT = (int) count($result);
                    $int_NUMBER_EXTRACT++;
                }
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
                return false;
            }
        }
        return $int_NUMBER_EXTRACT;
    }

    function createZipFile($file_name, $str_TYPE){

        switch ($str_TYPE){
            case 'pdf_courriersAll':
                $structure = "pdf_courriers".date('Y')."/".str_replace(' ', '_',strtolower($_SESSION['nom'])) ."/". date('d-m-Y') . "/";
                break;
            case 'courriers_sansAll':
                $structure = "courriers_sans".date('Y')."/".str_replace(' ', '_',strtolower($_SESSION['nom'])) ."/". date('d-m-Y') . "/";
                break;
            case 'sansentete':
                $structure = "courriers_sans".date('Y')."/".str_replace(' ', '_',strtolower($_SESSION['nom'])) ."/". date('d-m-Y') . "/";
                break;
            default:
                $structure = "courriers_avec".date('Y')."/".str_replace(' ', '_',strtolower($_SESSION['nom'])) ."/". date('d-m-Y') . "/";
                break;

        }

        $zip = new ZipArchive;
        if ($zip->open("{$file_name}.zip", ZipArchive::CREATE) === TRUE) {
            if ($handle = opendir($structure)) {
                //ouverture du dossier racine
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $data = $structure . '/' . $entry;
                        $dir = scandir($data, 1);
                        if (is_dir($data)) {
                            if ($dh = opendir($data)) {
                                while (($file = readdir($dh)) !== false) {
                                    if ($file != "." && $file != "..") {
                                        //echo "filename:" . $file . "<br>";
                                        $zip->addFile($data .'/'.$file);
                                    }
                                }
                                closedir($dh);
                            }
                        }
                    }
                }
                closedir($handle);
            }
            $zip->close();
            return true;
        }
        return false;
    }

    function getAllExtraction( $libelle, $params, $nbre, $str_EXTRACTION_ID, $db, $index){
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;

        if ($str_EXTRACTION_ID == "" || $str_EXTRACTION_ID == null) {
            $str_EXTRACTION_ID = "%%";
        }
        $str_EXTRACTION_ID = $db -> quote($str_EXTRACTION_ID);
        if ($libelle == "" || $libelle == null) {
            $libelle = "%%";
        }
        $libelle = $db -> quote('%'.$libelle.'%');
        if ($nbre == "" || $nbre == null) {
            $nbre = "%%";
        }
        $nbre = $db -> quote($nbre);
        if ($params == "" || $params == null) {
            $params = "%%";
        }
        $params = $db -> quote($params.'%');

        $sql = "SELECT * FROM t_extraction "
            . " WHERE str_EXTRACTION_ID LIKE " . $str_EXTRACTION_ID . " AND str_PARAM LIKE $libelle AND int_NUMBER_EXTRACT LIKE $nbre AND dt_CREATED LIKE $params AND str_STATUT <> '".$str_STATUT."'  "
            . " ORDER BY dt_CREATED DESC LIMIT ".$index.",10;";
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
        //echo "[" . json_encode($arrayJson) . "]";
        echo  json_encode($arraySql) ;
    }
    function countData($db, $str_EXTRACTION_ID, $libelle, $nbre, $params){
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "delete";
        $intResult = 0;

        if ($str_EXTRACTION_ID == "" || $str_EXTRACTION_ID == null) {
            $str_EXTRACTION_ID = "%%";
        }
        $str_EXTRACTION_ID = $db -> quote($str_EXTRACTION_ID);
        if ($libelle == "" || $libelle == null) {
            $libelle = "%%";
        }
        $libelle = $db -> quote('%'.$libelle.'%');
        if ($nbre == "" || $nbre == null) {
            $nbre = "%%";
        }
        $nbre = $db -> quote($nbre);
        if ($params == "" || $params == null) {
            $params = "%%";
        }
        $params = $db -> quote($params.'%');


        $sql = "SELECT count(*) AS numberData FROM t_extraction "
                ." WHERE str_EXTRACTION_ID LIKE " . $str_EXTRACTION_ID . " AND str_PARAM LIKE $libelle AND int_NUMBER_EXTRACT LIKE $nbre AND dt_CREATED LIKE $params AND str_STATUT <> '".$str_STATUT."'  ";
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
?>