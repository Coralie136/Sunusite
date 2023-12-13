<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    private $data = array();

	public function __construct() {
		parent::__construct();

        //------------------------------------------------
        // LOAD MODELS REQUIRE FOR THE CURRENT CONTROLLER
        //------------------------------------------------
        
//          $this->load->model('establishment', 'etablissement'); // load the 'establishment' model as 'etablissement'
          $this->load->model('log', 'log_file'); // load the 'log' model as 'log_file'
		  $this->load->model('user', 'user'); // load the user model as 'user'
        
        //------------------------------------------------
        
        //---------------
        // SET VARIABLES
        //---------------
//            var_dump(unserialize (USER_TYPE)); exit;
//            $this->data['userType'] = unserialize(USER_TYPE);
        
        //---------------
            // $pass = 'Sunu@admin2018';
            // $random_salt = $this->user->random_salt();
            // $passwd = $this->user->hash_passwd($pass, $random_salt);
            // echo $pass.'<br/>'.$random_salt.'<br/>'.$passwd;exit;

	}

	public function index() { // the index function that will be call first
        // if user already connected, redirect to the article that's correspond
		if ($this->session->userdata('logged_in') != '') {
            
            // Redirect the user to the article
            redirect('admin/article', 'refresh');
            
        }
        
        // $pass = 'admin';
        // $random_salt = $this->user->random_salt();
        // $passwd = $this->user->hash_passwd($pass, $random_salt);
        // echo $pass.'<br/>'.$random_salt.'<br/>'.$passwd;exit;
        
        // load the login form
		$this->data['feedBack']   = array('type' => 'info', 'message' => 'Veuillez entrer vos identifiants de connexion !');
		$this->load->view('admin/login', $this->data);
        
	}

	public function connexion() { // function to connect a user to the pannel using his login and password given in login form
        
        // check if the authentification form is not empty and process then
        if ($_POST) {
        
            // get all data from the authentification form
            $login  = stripslashes($this->input->post('login')); // email || number
            $pwd    = $this->input->post('pwd');

            //--------------------------------------------------------------------------
            // get all the user data that's corresponds to that login (email || number)
            //
            // READ DATA FROM user JOIN ON personnel
            //--------------------------------------------------------------------------
            
                // array of joins to store one or multiple join condition
                $joins  = array(
                    'join0' => array(
                        'table'     => 'personnel',
                        'condition' => 'personnel.id_user = user.id_user',
                        'type'      => 'inner'
                    ),
                    'join1' => array(
                        'table'     => 'level',
                        'condition' => 'level.id_level = user.id_level',
                        'type'      => 'inner'
                    ),
                );

                // array of all the where condition using OR
                $orWhere  = array(
                    'personnel.email_personnel'     => $login,
                    'personnel.email1_personnel'    => $login,
                    'personnel.numero_personnel'    => $login,
                    'user.email_user'               => $login
                );

                // array of all the where condition using AND
                $where = array();

                // value of rows the query should return
                $limit  = 1;
            
                // array of all the order condition
                $order  = array(
                    'user.id_user'  => 'DESC'
                );
            
                // execute the query and return all the required rows
                $res = $this->user->readJoins('*, personnel.*', $joins, $orWhere, $where, $limit, $order);
                //var_dump($res); exit;
            
            //--------------------------------------------------------------------------

            // process only if there is a user account that corresponds to the login
            if (!empty($res)) {

                // process only if the user account is not disabled
                if($res[0]->statut_user == 1) {

                    // get the user random salt and set the encrypted password
                    var_dump($pwd);
                    $random_salt    = $res[0]->randomSalt_user; // random salt
                    $ePwd           = $this->user->hash_passwd($pwd, $random_salt); // encrypted password
                    //var_dump($ePwd); exit;

                    //---------------------------------------------------------------------------------
                    // check if the authentification password corresponds to the user account password
                    //
                    // READ DATA FROM user JOIN ON personnel
                    //---------------------------------------------------------------------------------

                        // array of all the where condition using OR
                        $orWhere = array(
                            'personnel.email_personnel !='  => $login,
                            'personnel.numero_personnel'    => $login,
                            'user.email_user'               => $login
                        );

                        // array of all the where condition using AND
                        $where      = array(
                            'user.pwd_user'                 => $ePwd,
                            'user.id_user'                  => $res[0]->id_user
                        );

                        // value of rows the query should return
                        $limit      = 1;

                        // array of all the order condition
                        $order      = array(
                            'user.id_user'  => 'DESC'
                        );

                        // execute the query and return all the required rows
                        $result = $this->user->readJoins('*, personnel.*', $joins, $orWhere, $where, $limit, $order);
//                    var_dump($result); exit;
                    //---------------------------------------------------------------------------------

                    // process only if the password is correct
                    if (!empty($result)) {

                        // set session data with all the user data
                        $session_data   = array(
                            'email'         => $result[0]->email_user,
                            'name'          => trim($result[0]->nom_personnel.' '.$result[0]->prenom_personnel),
//                            'role'          => trim($result[0]->id_fonction),
                            'last_login'    => $result[0]->dateLoggedIn_user,
                            'user_id'       => $result[0]->id_user
                        );
                        
                        $user_access    = array(
                            'accessMenu'    => $result[0]->menu_level,
                            'accessS'       => $result[0]->statistique_level,
                            'accessNA'      => $result[0]->niveauAcces_level,
                            'accessU'       => $result[0]->user_level,
                        );
                        
                        //--------------------------------------------
                        // LOAD ALL THE CONNECTED USER'S INFORMATIONS
                        //--------------------------------------------
                        
                            // load the user profile picture
                            if (!empty($result[0]->photo_personnel)) {

                                $session_data['photo'] = $result[0]->id_user.'/'.$result[0]->photo_personnel;

                            } else { // use the default profile picture

                                // check for the user sex
                                $default    = (!empty($result[0]->sexe_personnel)) ? '-'.$result[0]->sexe_personnel.'.png' : '.jpg' ;
                                
                                $session_data['photo'] = 'profile'.$default;
                            }
                        
                        //--------------------------------------------

                        // Add user data in session
                        $this->session->set_userdata('logged_in', $session_data);
                        $this->session->set_userdata('access', $user_access);
                        $this->session->set_userdata('user_id', $result[0]->id_user);

                        //update user last_login
                        $this->user->update(array('id_user' => $result[0]->id_user), array('dateLoggedIn_user' => date("Y-m-d H:i:s")));
                        
                        //-------------------------
                        // Get the session data
                        //
                        // READ DATA FROM _SESSION
                        //-------------------------
                            $inserted   = $this->session->userdata('__ci_last_regenerate');
                            $data_log   = '';

                            foreach($this->session->userdata as $key => $value) {
                                if (is_array($value)) {
                                    $data_log   .= "{";
                                    foreach($value as $k => $val) {
                                        $data_log   .= $k."=>".$val."::";
                                    }
                                    $data_log   = substr_replace($data_log, '', strrpos($data_log, '::'));
                                    $data_log   .= "}\n";
                                } else {
                                    $data_log   .= $key."=>".$value."\n";
                                }
                            }
                        //-------------------------

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                            // setting up data to insert
                            $toInsert   = array(
                                'user_log'  => $this->session->userdata('user_id'),
                                'table_log' => "_SESSION",
                                'data_log'  => "login|all|$inserted|0|$data_log",
                            );

                            // inserting log
                            $this->log_file->create($toInsert);
                        //-------------------

                        // Redirect the user to the article
                        redirect('admin/article'); exit;

                    } else { // wrong password
                        // error, wrong password
                        $this->data['feedBack']   = array('type' => 'warning', 'message' => 'Mot de passe incorrect !');
                        $this->load->view('admin/login', $this->data);
                    }

                } else { // disabled account
                    // error, the account's disabled
                    $this->data['feedBack']   = array('type' => 'danger', 'message' => 'Votre compte est désactivé !');
                    $this->load->view('admin/login', $this->data);
                }

            } else { // wrong login
                // error, the login's not correct
                $this->data['feedBack']   = array('type' => 'warning', 'message' => 'Login ou mot de passe incorrect !');
                $this->load->view('admin/login', $this->data);
            }
        
        } else { // form is empty
            // destroy user session and redirect to the authentification form
            redirect('admin/login/logout');
        }
        
	}

    function logout() { // function to log out
        
        //-------------------------
        // Get the session data
        //
        // READ DATA FROM _SESSION
        //-------------------------
            $inserted   = $this->session->userdata('__ci_last_regenerate');
            $data_log   = '';

            foreach($this->session->userdata as $key => $value) {
                if (is_array($value)) {
                    $data_log   .= "{";
                    foreach($value as $k => $val) {
                        $data_log   .= $k."=>".$val."::";
                    }
                    $data_log   = substr_replace($data_log, '', strrpos($data_log, '::'));
                    $data_log   .= "}\n";
                } else {
                    $data_log   .= $key."=>".$value."\n";
                }
            }
        //-------------------------

        //-------------------
        // UPDATE LOG'S DATA
        //-------------------
            // setting up data to insert
            $toInsert   = array(
                'user_log'  => $this->session->userdata('user_id'),
                'table_log' => "_SESSION",
                'data_log'  => "logout|all|$inserted|$data_log|0",
            );

            // inserting log
            $this->log_file->create($toInsert);
        //-------------------
        
        // destroy user session
        $this->session->sess_destroy();
        
        // unset session data
        $this->session->userdata    = array();
        
        // redirect to the default controller
        redirect();
        
    }
    
    function recover() {
        
        // process data only if the form is not empty
        if (!$_POST AND !$this->input->post('email')) {
            
            // get the sent address
            $email  = $this->input->post('email');
            
            // get the account that corresponds to that address
            $user   = $this->user->read('*', array('email_user' => $email));
            
            // check if the address correspond of any account in the system
            if (!empty($user)) {
                
                // get a password for that user
                $pass           = $this->user->get_password(8);
                $random_salt    = $this->user->random_salt();
                $passwd         = $this->user->hash_passwd($pass, $random_salt);
                
                // update user data
                $toUpdate       = array(
                    'pwd_user'              => $passwd,
                    'randomSalt_user'       => $random_salt,
                    'dateRecoveryPwd_user'  => date('Y-m-d H:i:s')
                );
                $where          = array(
                    'email_user'        => $email
                );
                
                // updating user data
                if ($this->user->update($where, $toUpdate)) {
                
                    //----------------------------------------------------
                    // SEND A MAIL TO THE USER WITH THE NEW USER PASSWORD
                    //----------------------------------------------------

                        // create and compose the "password reseted" mail
                        $message    = 'Bonjour '.$user[0]->civility_user.' '.$user[0]->name_user.',<br/>';
                        $message    .= 'Votre mot de passe a été reinitialisé avec succès. Ci-dessous votre nouveau mot de passe:<br/>';
                        $message    .= '<strong>'.$pass.'</strong><br/><br/>';
                        $message    .= 'Cordialement, <br/> XselSMS';

                        // mail settings
                        $this->load->library('email');
                        $this->email->from('console@xselsms.com', 'XselSMS');
                        $this->email->reply_to('console@xselsms.com', 'console@xselsms.com');
                        $this->email->to($user[0]->email_user);
                        $this->email->subject('XselSMS - Mot de passe oublié');
                        $this->email->message($message);

                        // send and clear the mail
                        $this->email->send();
                        $this->email->clear();

                    //----------------------------------------------------
                    
                    // success, password reseted
                    $retour = array('type' => 'success', 'message' => 'Votre mot de passe a été reinitialisé avec succès, veuillez consulter votre messagerie!');
                    
                } else { // try to reset password
                    // warning, can't reset password
                    $retour = array('type' => 'warning', 'message' => 'Impossible de reinitailiser votre mot de passe!');
                }
                
//                var_dump($user); exit;
                
            } else { // test address
                // warning, address does not correspond to any account
                $retour = array('type' => 'warning', 'message' => 'Cette adresse ne correspond à aucun compte!');
            }
            
            // send back the return to the view
            $this->session->set_flashdata('retour', $retour);
            
            // redirect user to the login form
            redirect('login', 'refresh');
            
        } else {
            // redirect user to the login form
            redirect('login');
        }
        
    }
    
}