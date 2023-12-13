<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller{
    
    public function __construct(){
        
        parent::__construct();
        
        $this->load->model('contact_table', 'contact');

        $this->load->model('pays_model', 'pays');
        //$this->load->model('souscriptions_model', 'souscription');
        $this->load->model('assurables_model', 'assurable');
        //$this->load->model('categories_model', 'categorie');
        $this->load->model('User', 'user');
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'

        //element for refractor
        $this->load->model('ages_model', 'age');
        $this->load->model('assurables_model', 'assurable');
        $this->load->model('Client_contact_model', 'client_contact');
        $this->load->model('clients_model', 'clients');
        //end element for refractor

        //Librairies
        $this->lang->load('content');

        //menu
        $this->data['menu'] = $this->fonctions->menu;
        $this->data['menu']['accueil'] = 'active';

        //langue courante
        $this->lg = $this->lang->lang();
        $this->data['lang'] = $this->lg;

        $this->data['titrePage'] = lang('monprofil');


        
        // check if that user has a valid (active) session
        if ($this->session->userdata('logged_in') == ''){
            
            // redirect to the authentification form
            redirect('admin');
        }

        //-----------------------------------------------
        // SET AND GET ALL THE DATA ABOUT USER CONNEXION
        //-----------------------------------------------

            // get the user session data
            $logged_in = $this->session->userdata('logged_in');
            $this->data['logged_in'] = $logged_in;

            // set the title of the current page
            $this->data['page_title']       = 'Administrateur';
            $this->data['page_description'] = 'gestion des administrateurs filiales';

            // get the class menu property
            $this->data['menu']             = $this->fonctions->menu;

            // set the active menu item
            $this->data['menu']['contact']['contact']   = 'active open';
        
        //-----------------------------------------------
            
        // get all chars arrays
        $this->data['signed_letters']   = unserialize(SIGNED_LETTERS);
        $this->data['signs']            = unserialize(SIGNS);
    }
    
    //----------------------------------------------
    // THE INDEX FUNCTION THAT WILL BE CALLED FIRST
    //----------------------------------------------
    public function index() {
        // call to the contact method
        $this->contact();

    }
    //----------------------------------------------
    
    //-----------------------------------
    // DISPLAY ALL THE contact INSERTED
    //-----------------------------------
    public function contact() {

        //------------------------------------------------------
        // SET ALL THE CSS AND JS REQUIRED FOR THE CURRENT PAGE
        //------------------------------------------------------

            // all the js required
            $this->data['javascripts'] = array(
                'global/scripts/datatable.js',
                'global/plugins/datatables/datatables.min.js',
                'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
                'pages/scripts/table-datatables-managed.js',
                'global/plugins/select2/js/select2.full.min.js',
                'pages/scripts/components-select2.min.js',          
                'pages/scripts/components-date-time-pickers.js',
                'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                'pages/scripts/custom.js',
            );
            // all the css required
            $this->data['css'] = array(
                'global/plugins/datatables/datatables.css',
                'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
                'global/plugins/select2/css/select2.min.css',
                'global/plugins/select2/css/select2-bootstrap.min.css',                    
                'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
            );

        //------------------------------------------------------

        //------------------------------------------
        // get list of all contact in the database
        //
        // READ DATA FROM contact
        //------------------------------------------

        $where      = array(
            'contact.statut_contact != '     => '3',
        );
        $contacts = $this->contact->readContacts("*", $where);


        $n = sizeof($contacts);
        for ($i=0; $i < $n; $i++) {
            $assurables = '';
            $list = explode('|', $contacts[$i]->id_assurable);
            $p = sizeof($list);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){

                    $assure = $this->assurable->read('nom_assurable', array('id_assurable' => $list[$j]));
                    $assurables .= $assure[0]->nom_assurable.'<br/>';
                }
            }
            $contacts[$i]->assurables = $assurables;
        }

        $this->data['contacts'] = $contacts;
        $this->data['menu']['contact']['contact']    = 'active open';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

        //var_dump($contacts);die();

        $this->layer->pages('admin/contact', 'admin/include/menu', $this->data);

    }
    //-----------------------------------
    
    //-----------------------------------------
    // DISPLAY AN EMPTY FORM TO ADD AN contact
    //-----------------------------------------
    public function newcontact () {
                    
        // Get the contact's id
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;

        // set the title of the current page
        // $this->data['page_description']             = 'Ajouter un contact';

        // set the active menu item
        $this->data['menu']['contact']['contact']   = 'active open';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

        //-----------------------------------------------------------------
        // SET ALL THE CSS, JS AND FUNCTIONS REQUIRED FOR THE CURRENT PAGE
        //-----------------------------------------------------------------

            // all the js required
            // $this->data['javascripts'] = array(
            //     'global/plugins/jquery-validation/js/jquery.validate.min.js',
            //     'global/plugins/jquery-validation/js/additional-methods.min.js',
            //     'pages/scripts/form-validation-md.js',
            //     'global/plugins/select2/js/select2.full.min.js',
            //     'pages/scripts/components-select2.min.js',
            //     'global/plugins/moment.min.js',
            //     'global/plugins/bootstrap-daterangepicker/daterangepicker.min.js',
            //     'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            //     'global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            //     'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
            //     'global/plugins/clockface/js/clockface.js',
            //     'pages/scripts/components-date-time-pickers.min.js',
            //     'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
            //     'global/plugins/ckeditor/ckeditor.js',
            //     'pages/scripts/custom.js',
            // );

            // all the css required
            // $this->data['css'] = array(
            //     'global/plugins/select2/css/select2.min.css',
            //     'global/plugins/select2/css/select2-bootstrap.min.css',
            //     'global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
            //     'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
            //     'global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            //     'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
            //     'global/plugins/clockface/css/clockface.css',
            //     'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
            // );

        //-----------------------------------------------------------------
        
        $this->data['contact']  = '';

        //var_dump($this->lg);die();
        //if($this->lg == 'fr')
            $select = "nom_pays, id_pays";
        //else $select = "nom_pays_en as nom_pays, id_pays";
        $this->data['payss'] = $this->pays->readOrder($select, array(), 'nom_pays ASC');

        if($this->lg == 'fr') $select = "nom_assurable, id_assurable";
        else $select = "nom_assurable_en as nom_assurable, id_assurable";
        $this->data['assurables'] = $this->assurable->readOrder($select, array(), 'ordre ASC');

        // If the contact's id is not empty
        if (!empty($aid)) { // contact's data for update form

            // set the title of the current page
            // $this->data['page_description'] = 'Modifier l\'contact';

            //----------------------------------
            // GET ALL THE contact INFORMATIONS
            //----------------------------------
                // Execute the query and return all the required rows
                $this->data['contact']      = $this->contact->read('*', array('id_contact' => $aid));
            //----------------------------------

        }
        // end if

        // include the view with all the data requested
        $this->layer->pages('admin/new_contact', 'admin/include/menu', $this->data);
        
    }
    //-----------------------------------------
    
    //----------------------------------------------
    // ADD (id == 0) OR UPDATE (id != 0) AN contact
    //----------------------------------------------
    public function addcontact () {

            //var_dump($_POST); die();
            // Check if there are posted data and then process
            if (!empty($_POST)) {

                //                var_dump($_POST); var_dump($_FILES['import-file']['name']); exit;
                // Check if we have to insert or update data, the id is defined and not null
                $aid = $this->input->post('aid');
                if (empty($aid)) { // insert data

                    // Check if all the required data have been posted
                    $txt_name = $this->input->post('txt_name');
                    $txt_email = $this->input->post('txt_email');
                    $id_pays = $this->input->post('id_pays');
                    $id_assurable = $this->input->post('id_assurable[]');
                    $txt_password = $this->input->post('txt_password');
                    $txt_id_user  = $this->input->post('txt_id_user');
                    if (!empty($txt_name) AND !empty($txt_email) AND !empty($id_pays) AND !empty($id_assurable)) {

                        $rest = $this->user->read('*', array('email_user' => $txt_email));


                        if($rest[0]->email_user != $txt_email){
                            // Get all the form data
                            $name = (!empty($txt_name)) ? $this->input->post('txt_name') : '';
                            $email = (!empty($txt_email)) ? $this->input->post('txt_email') : '';
                            $pays = (!empty($id_pays)) ? $this->input->post('id_pays') : '';
                            $txt_password = (!empty($id_pays)) ? $this->input->post('txt_password') : '';
                            $id_assurable = (!empty($id_assurable)) ? $this->input->post('id_assurable[]') : '';


                            $date = date('d-m-Y');
                            $date = DateTime::createFromFormat('d-m-Y', $date);
                            $date = $date->format('Y-m-d H:i:s');


                            $n = sizeof($id_assurable);
                            $assure = array();
                            $liste = '';
                            $orWhereAssurable = " ( ";
                            for($i=0; $i < $n; $i++) {
                                if($i>0)$orWhereAssurable.=" OR ";
                                if($id_assurable[$i] != 0) {
                                    $assure[] = $id_assurable[$i];
                                    $liste .= $id_assurable[$i].'|';
                                    $orWhereAssurable .= " assurable.id_assurable = ".intval($id_assurable[$i]);
                                }
                            }
                            $orWhereAssurable .= " ) ";

                            $id_user = $this->user->get_unused_id();
                            $toInsertUser = array(
                                'id_user' => $id_user,
                                'id_level' => '100',
                                'email_user' => $email,
                                'pwd_user' => $this->generatePassword( $txt_password),
                                'statut_user' => '0', //1
                                'dateCreated_user' => $date
                            );

                            // Stock the insertion id for verification

                            $insertedUser = $this->user->create($toInsertUser);

                            // $dataUser = $this->user->read('*', array('email_user' => $email)); //parce que le insert_id() de create ne fonctionne pas

                            // setting up data to insert
                            $toInsert = array(
                                'nom_contact' => $name,
                                'email_contact' => $email,
                                'dateCreated_contact' => $date,
                                'statut_contact' => '1',
                                'createdBy' => $this->session->userdata('user_id'),
                                'id_pays' => $pays,
                                'id_assurable' => $liste,
                                'id_user' => $id_user
                            );

                            // Stock the insertion id for verification
                            $inserted = $this->contact->create($toInsert);

                            //var_dump($inserted); die();

                            // inserting data
                            if ($inserted) {

                                //----------------------------
                                // Get the data just inserted
                                //
                                // READ DATA FROM contact
                                //----------------------------
                                // execute the query and return all the required rows
                                $insertedData = $this->contact->read('*', array('id_contact' => $inserted));

                                $data_log = '';

                                foreach ($insertedData[0] as $key => $value) {
                                    $data_log .= $key . "=>" . $value . "\n";
                                }
                                //----------------------------

                                //associer le client et le contact
                                $this->doRefractor($pays, $orWhereAssurable, $inserted);

                                //-------------------
                                // UPDATE LOG'S DATA
                                //-------------------
                                // setting up data to insert
                                $toInsert = array(
                                    'user_log' => $this->session->userdata('user_id'),
                                    'table_log' => "contact",
                                    'data_log' => "insert|all|$inserted|0|$data_log",
                                );

                                // inserting log
                                $this->log_file->create($toInsert);
                                //-------------------
                                // Return a success message (insertion done)
                                $retour = array('type' => 'success', 'message' => 'L\'administrateur a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s!');


                            } else { // Return a warning message (the data already exists)
                                $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er l\'administrateur');
                            }
                        }
                        else{
                            $retour = array('type' => 'warning', 'message' => 'L\'email renseigné existe déjà !');
                        }
                    }else{
                        $retour = array('type' => 'warning', 'message' => 'Veuillez renseigner tout les champs s\'il vous plait');
                    }
                }
                else { // update data

                    // Check if all the required data have been posted
                    $txt_name = $this->input->post('txt_name');
                    $txt_email = $this->input->post('txt_email');
                    $id_pays = $this->input->post('id_pays');
                    $id_assurable = $this->input->post('id_assurable');
                    $txt_password  = $this->input->post('txt_password');
                    $txt_id_user  = $this->input->post('txt_id_user');
                    if (!empty($txt_name) AND !empty($txt_email) AND !empty($id_pays) AND !empty($txt_password)) {

                        $rest = $this->user->read('*', array(
                                'email_user' => $txt_email, 'id_user <> ' => $txt_id_user)
                        );

                        //var_dump($aid); die();
                        //var_dump($rest); die();

                        if ($rest[0]->email_user != $txt_email) {
                            // Get all the form data
                            $aid = ((int)$this->input->post('aid') > 0) ? (int)$this->input->post('aid') : 0;

                            // Get all the form data
                            $name = (!empty($txt_name)) ? $this->input->post('txt_name') : '';
                            $email = (!empty($txt_email)) ? $this->input->post('txt_email') : '';
                            $pays = (!empty($id_pays)) ? $this->input->post('id_pays') : '';
                            $id_assurable = (!empty($id_assurable)) ? $this->input->post('id_assurable') : '';
                            $txt_password = (!empty($txt_password)) ? $this->input->post('txt_password') : '';

                            if (!empty($aid) AND !empty($email) AND !empty($name) AND !empty($pays) AND !empty($id_assurable) AND !empty($txt_password)) {

                                $date = date('d-m-Y');
                                $date = DateTime::createFromFormat('d-m-Y', $date);
                                $date = $date->format('Y-m-d H:i:s');
                                $toUpdateData = $this->contact->read('*', array('id_contact' => $aid));

                                $oData_log = '';

                                foreach ($toUpdateData[0] as $key => $value) {
                                    $oData_log .= $key . "=>" . $value . "\n";
                                }

                                $n = sizeof($id_assurable);
                                $assure = array();
                                $liste = '';
                                $orWhereAssurable = "( ";
                                for ($i = 0; $i < $n; $i++) {
                                    if ($i > 0) $orWhereAssurable .= " OR ";
                                    if ($id_assurable[$i] != 0) {
                                        $assure[] = $id_assurable[$i];
                                        $liste .= $id_assurable[$i] . '|';
                                        $orWhereAssurable .= " assurable.id_assurable = " . intval($id_assurable[$i]);
                                    }
                                }
                                $orWhereAssurable .= " )";


                                $toUpdateUser = array(
                                    'email_user' => $email,
                                    'pwd_user' => $this->generatePassword($txt_password),
                                    'statut_user' => '0',
                                    'dateCreated_user' => $date
                                );
                                //var_dump($toUpdateData); die();
                                // setting up where clause
                                $where = array(
                                    'id_user' => $toUpdateData[0]->id_user,
                                );

                                // Stock the update status for test
                                $updated = $this->user->update($where, $toUpdateUser);


                                // setting up data to update
                                $toUpdate = array(
                                    'nom_contact' => $name,
                                    'email_contact' => $email,
                                    'id_pays' => $pays,
                                    'id_assurable' => $liste,
                                    'dateCreated_contact' => $date
                                );

                                // setting up where clause
                                $where = array(
                                    'id_contact' => $aid,
                                );

                                // Stock the update status for test
                                $updated = $this->contact->update($where, $toUpdate);

                                //associer le client et le contact
                                $this->doRefractor($pays, $orWhereAssurable, $aid);

                                // updating data
                                if ($updated) {

                                    //--------------------------
                                    // Get the row just updated
                                    //
                                    // READ DATA FROM article
                                    //--------------------------
                                    // execute the query and return all the required rows
                                    $updatedData = $this->contact->read('*', array('id_contact' => $aid));


                                    $data_log = '';

                                    foreach ($updatedData[0] as $key => $value) {
                                        $data_log .= $key . "=>" . $value . "\n";
                                    }
                                    //--------------------------

                                    //-------------------
                                    // UPDATE LOG'S DATA
                                    //-------------------
                                    // setting up data to insert
                                    $toInsert = array(
                                        'user_log' => $this->session->userdata('user_id'),
                                        'table_log' => "article",
                                        'data_log' => "update|all|$aid|$oData_log|$data_log",
                                    );

                                    // inserting log
                                    $this->log_file->create($toInsert);
                                    //-------------------

                                    // Return a success message (update done)
                                    $retour = array('type' => 'success', 'message' => 'L\'administrateur a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');

                                } else { // Return a warning message (can't update data)
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour l\'article');
                                }
                                //---------------------------
                            } else { // Return a danger message (data are not correct)
                                $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                            }

                        } else {
                            $retour = array('type' => 'warning', 'message' => 'Cet adresse email a déjà été utilisé. Cependant elle a été bannie du système veuillez contacter votre administrateur !');
                        }
                    }
                    else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    }
                }
            }else{
                $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'administrateur');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/contact', 'refresh');
            
        }
    //----------------------------------------------
    
    //-------------------
    // ENABLE AN contact
    //-------------------
    public function enablecontact () {

            // Process only if there is an id selected
            $e_aid = $this->input->post('e_aid');
            if (!empty($e_aid)) { // process

                // Get the sent row's id
                $aid    = $this->input->post('e_aid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $aid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_contact'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_contact'    => '1',
                    );

                    // Stock the update status for test
                    $enabled    = $this->contact->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($enabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "contact",
                            'data_log'  => "enable|statut_contact|$aid|0|1",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'contact activ&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'contact!');
                }

            } else { // redirect the user
                redirect('admin/contact', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user to the data list
            redirect('admin/contact', 'refresh');

        }
    //-------------------
    
    //------------------------------
    // ENABLE ALL SELECTED contact
    //------------------------------
    public function enableSelectedcontact () {
                
            // Process only if there is an id selected
            $e_aids = $this->input->post('e_aids');
            if (!empty($e_aids)) { // process

                // Get the sent row's id
                $aids       = $this->input->post('e_aids');
                $allDone    = true;
                $done       = 0;

                foreach ($aids as $aid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 1, id == $aid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_contact'        => $aid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_contact'    => '1',
                            );

                            // Stock the update status for test
                            $enable = $this->contact->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($enable) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "contact",
                                    'data_log'  => "disable|statut_contact|$aid|0|1",
                                );

                                // inserting log
                                $this->log_file->create($toInsert);
                            //-------------------
                        } else {
                            //
                            $allDone    = false;
                        }
                    } else {
                        // set the sendback, 'message' and 'type'
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($aids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; activ&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/contact', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/contact', 'refresh');
            
        }
    //------------------------------
    
    //-------------------
    // DISABLE A contact
    //-------------------
    public function disablecontact () {

            // Process only if there is an id selected
            $d_aid = $this->input->post('d_aid');
            if (!empty($d_aid)) { // process

                // Get the sent row's id
                $aid    = $this->input->post('d_aid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $aid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_contact'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_contact'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->contact->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($disabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "contact",
                            'data_log'  => "disable|statut_contact|$aid|1|2",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'contact d&eacute;sactiv&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'contact!');
                }

            } else { // redirect the user
                redirect('admin/contact', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/contact', 'refresh');

        }
    //-------------------
    
    //-------------------------------
    // DISABLE ALL SELECTED contact
    //-------------------------------
    public function disableSelectedcontact () {
                
            // Process only if there is an id selected
            $d_aids = $this->input->post('d_aids');
            if (!empty($d_aids)) { // process

                // Get the sent row's id
                $aids       = $this->input->post('d_aids');
                $allDone    = true;
                $done       = 0;

                foreach ($aids as $aid) {
                    if ($allDone) {
                        //----------------------------------------------------------------------------
                        // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $aid)
                        //----------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_contact'        => $aid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_contact'    => '0',
                            );

                            // Stock the update status for test
                            $disabled   = $this->contact->update($where, $toUpdate);
                        //----------------------------------------------------------------------------

                        if ($disabled) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "contact",
                                    'data_log'  => "disable|statut_contact|$aid|1|2",
                                );

                                // inserting log
                                $this->log_file->create($toInsert);
                            //-------------------
                        } else {
                            //
                            $allDone    = false;
                        }
                    } else {
                        // set the sendback, 'message' and 'type'
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($aids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; d&eacute;sactiv&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/contact', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/contact', 'refresh');
            
        }
    //-------------------------------
    
    //------------------
    // DELETE A contact
    //------------------
    public function deletecontact () {

            // Process only if there is an id selected
            $rm_aid = $this->input->post('rm_aid');
            if (!empty($rm_aid)) { // process

                // Get the sent row's id
                $aid    = $this->input->post('rm_aid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $aid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_contact'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_contact'    => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->contact->update($where, $toUpdate);

                    $dataContact = $this->contact->read('*', array('id_contact'        => $aid));

                    $where      = array(
                        'id_user'        => $dataContact[0]->id_user,
                    );

                    // Stock the update status for test
                    $deletedUser    = $this->user->delete($where);

                //------------------------------------------------------------------------------
                if ($deleted) { // success, row's status updated

                    $this->contact->delete($where);

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                    /*
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "contact",
                            'data_log'  => "disable|statut_contact|$aid|0,1,2|3",
                        );

                        try{
                            // inserting log
                            $this->log_file->create($toInsert);
                        }
                        catch (Exception $e){
                            die("Erreur = > ".$e->getMessage());
                        }*/
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'L\'administrateur filiale a été supprim&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer l\'administrateur!');
                }

            } else { // redirect the user
                redirect('contact', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/contact', 'refresh');

        }
    //------------------
    
    //------------------------------
    // DELETE ALL SELECTED contact
    //------------------------------
    public function deleteSelectedcontacts () {
                
            // Process only if there is an id selected
            $rm_aids = $this->input->post('rm_aids');
            if (!empty($rm_aids)) { // process

                // Get the sent row's id
                $aids       = $this->input->post('rm_aids');
                $allDone    = true;
                $done       = 0;

                foreach ($aids as $aid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // DELETE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $aid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_contact'        => $aid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_contact'    => '3',
                            );

                            // Stock the update status for test
                            $deleted    = $this->contact->update($where, $toUpdate);



                            $dataContact = $this->contact->read('*', array('id_contact'        => $aid));

                            $where      = array(
                                'id_user'        => $dataContact[0]->id_user,
                            );

                            // Stock the update status for test
                            $deletedUser    = $this->user->delete($where);
                        //---------------------------------------------------------------------------

                        if ($deleted) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "contact",
                                    'data_log'  => "disable|statut_contact|$aid|0,1,2|3",
                                );

                                // inserting log
                                $this->log_file->create($toInsert);
                            //-------------------
                        } else {
                            //
                            $allDone    = false;
                        }
                    } else {
                        // set the sendback, 'message' and 'type'
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($aids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('contact', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/contact', 'refresh');
            
        }
    //------------------------------

    /**
     * Ajouté par JMO le 12/03/2019
     * OBJECTIF : Creer des utilisateurs dans la partie contact qui pourrons seulement se contacter sur la plactorme contacr
     */
    private function generatePassword( $pwd) {
        $data = array();
        $data["ALGO"] = "SHA256";
        $data["DATE"] = $pwd;
        ksort($data);
        $message = http_build_query($data);
        $cle_bin = pack("a", "SONATEL");
        return strtoupper(hash_hmac(strtolower($data["ALGO"]), $message, $cle_bin));
    }

    private function doRefractor($id_pays, $orWhereAssurable, $id_contact){
        $where      = array(
            'client_contact.id_contact = '     => $id_contact,
            ' client_contact.bl_display LIKE '     => 1
        );
        $this->client_contact->delete($where);
        //var_dump($this->client_contact->delete($where));die();
        //get all customers
        $sql_clients = "SELECT * FROM clients "
            ." JOIN age ON clients.id_age = age.id_age "
            ." JOIN souscription ON souscription.id_souscription = clients.id_souscription "
            ." JOIN pays ON pays.id_pays = clients.id_pays  "
            ."JOIN assurable ON assurable.id_assurable = clients.assurables "
            ." WHERE pays.id_pays = $id_pays AND  ".$orWhereAssurable;
        $query_clients = $this->db->query($sql_clients)->result();

        //var_dump($sql_clients); die();

        foreach ($query_clients as $clients){

            //verifier si la ligne n'a pas déjà été créé
            $sql_clients_contact = "SELECT * FROM client_contact "
                ." WHERE id_contact LIKE '$id_contact' AND id_clients LIKE '".$clients->id_client."' ";
            $query_clients_contact = $this->db->query($sql_clients_contact)->result();

            //var_dump(empty($query_clients_contact)); die();
            if(empty($query_clients_contact)){
                $req_client_contact = array(
                    'id_clients' => $clients->id_client,
                    'id_contact' => $id_contact
                );
                $this->client_contact->create($req_client_contact);
            }
        }
    }
}
?>