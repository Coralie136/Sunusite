<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filiale extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model('pays_model', 'pays');
        $this->load->model('filiale_table', 'filiale');
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'


        //Librairies
        $this->lang->load('content');

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
        $this->data['page_title']       = 'Filiale';
        $this->data['page_description'] = 'gestion des filiales';

        // get the class menu property
        $this->data['menu']             = $this->fonctions->menu;

        // set the active menu item
        $this->data['menu']['filiale']['filiale']   = 'active open';

        //-----------------------------------------------

        // get all chars arrays
        $this->data['signed_letters']   = unserialize(SIGNED_LETTERS);
        $this->data['signs']            = unserialize(SIGNS);
    }

    //----------------------------------------------
    // THE INDEX FUNCTION THAT WILL BE CALLED FIRST
    //----------------------------------------------
    public function index() {
        // call to the filiale method
        $this->filiale();

    }
    //----------------------------------------------

    //-----------------------------------
    // DISPLAY ALL THE filiale INSERTED
    //-----------------------------------
    public function filiale() {

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
        // get list of all filiale in the database
        //
        // READ DATA FROM filiale
        //------------------------------------------

        $where      = array(
            'description.statut_description != '     => '3',
        );
        $filiales = $this->filiale->readfiliales("*", $where);

       // var_dump($filiales); die();

        $this->data['filiales'] = $filiales;
        $this->data['menu']['filiale']['filiale']    = 'active open';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

        //var_dump($filiales);die();

        $this->layer->pages('admin/filiale', 'admin/include/menu', $this->data);

    }
    //-----------------------------------

    //-----------------------------------------
    // DISPLAY AN EMPTY FORM TO ADD AN filiale
    //-----------------------------------------
    public function newFiliale () {

        // Get the filiale's id
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;

        // set the title of the current page
        //$this->data['page_description']             = 'Ajouter un filiale';

        // set the active menu item
        $this->data['menu']['filiale']['filiale']   = 'active open';

        //-----------------------------------------------------------------
        // SET ALL THE CSS, JS AND FUNCTIONS REQUIRED FOR THE CURRENT PAGE
        //-----------------------------------------------------------------

        // all the js required
        $this->data['javascripts'] = array(
            'global/plugins/jquery-validation/js/jquery.validate.min.js',
            'global/plugins/jquery-validation/js/additional-methods.min.js',
            'pages/scripts/form-validation-md.js',
            'global/plugins/select2/js/select2.full.min.js',
            'pages/scripts/components-select2.min.js',
            'global/plugins/moment.min.js',
            'global/plugins/bootstrap-daterangepicker/daterangepicker.min.js',
            'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
            'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
            'global/plugins/clockface/js/clockface.js',
            'pages/scripts/components-date-time-pickers.min.js',
            'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
            'global/plugins/ckeditor/ckeditor.js',
            'pages/scripts/custom.js',
        );

        // all the css required
        $this->data['css'] = array(
            'global/plugins/select2/css/select2.min.css',
            'global/plugins/select2/css/select2-bootstrap.min.css',
            'global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
            'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
            'global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
            'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
            'global/plugins/clockface/css/clockface.css',
            'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
        );

        //-----------------------------------------------------------------

        $this->data['filiale']  = '';

        //var_dump($this->lg);die();
        //if($this->lg == 'fr')
        $select = "nom_pays, id_pays";
        //else $select = "nom_pays_en as nom_pays, id_pays";
        $where = array("statut_pays !=" => 3);
        $this->data['payss'] = $this->pays->readOrder($select, $where, 'nom_pays ASC');

        // If the filiale's id is not empty
        if (!empty($aid)) { // filiale's data for update form

            // set the title of the current page
         // $this->data['page_description'] = 'Modifier l\'filiale';

            //----------------------------------
            // GET ALL THE filiale INFORMATIONS
            //----------------------------------
            // Execute the query and return all the required rows
            $this->data['filiale']      = $this->filiale->read('*', array('id_description' => $aid));
            //----------------------------------

        }
        // end if

        // include the view with all the data requested
        $this->layer->pages('admin/new_filiale', 'admin/include/menu', $this->data);

    }
    //-----------------------------------------

    //----------------------------------------------
    // ADD (id == 0) OR UPDATE (id != 0) AN filiale
    //----------------------------------------------
    public function addFiliale () {

        //var_dump($_POST); die();
        // Check if there are posted data and then process
        if (!empty($_POST)) {

            // var_dump($_POST); var_dump($_FILES['import-file']['name']); exit;
            // Check if we have to insert or update data, the id is defined and not null
            $aid = $this->input->post('aid');
            //var_dump($aid); die();
            if (empty($aid)) { // insert data

                // Check if all the required data have been posted
                $dt_date = $this->input->post('dt_date');
                $id_pays = $this->input->post('id_pays');
                $txt_title = $this->input->post('txt_title');
                $txt_title_en = $this->input->post('txt_title_en');
                $txt_link = $this->input->post('txt_link');
                $txt_text = $this->input->post('txt_text');
                $txt_text_en  = $this->input->post('txt_text_en');
                $txt_siege_sociale = $this->input->post('txt_siege_sociale');
                $txt_siege_sociale_en = $this->input->post('txt_siege_sociale_en');
                $txt_info_juridique_fr  = $this->input->post('txt_info_juridique_fr');
                $txt_info_juridique_en  = $this->input->post('txt_info_juridique_en');
                $txt_direction_general_fr  = $this->input->post('txt_direction_general_fr');
                $txt_direction_general_en  = $this->input->post('txt_direction_general_en');
                $txt_actionnariat_fr  = $this->input->post('txt_actionnariat_fr');
                $txt_actionnariat_en  = $this->input->post('txt_actionnariat_en');
                $txt_conseil_admin_fr  = $this->input->post('txt_conseil_admin_fr');
                $txt_conseil_admin_en  = $this->input->post('txt_conseil_admin_en');
                $txt_produit_fr  = $this->input->post('txt_produit_fr');
                $txt_produit_en  = $this->input->post('txt_produit_en');

                if (!empty($id_pays) ) {

                    $date = DateTime::createFromFormat('d-m-Y', $dt_date);
                    $date = $date->format('Y-m-d H:i:s');

                    $id_pays = $this->input->post('id_pays');
                    $txt_title = $this->input->post('txt_title');
                    $txt_title_en = $this->input->post('txt_title_en');
                    $txt_link = $this->input->post('txt_link');
                    $txt_text = $this->input->post('txt_text');
                    $txt_text_en  = $this->input->post('txt_text_en');
                    $txt_siege_sociale = $this->input->post('txt_siege_sociale');
                    $txt_siege_sociale_en = $this->input->post('txt_siege_sociale_en');
                    $txt_info_juridique_fr  = $this->input->post('txt_info_juridique_fr');
                    $txt_info_juridique_en  = $this->input->post('txt_info_juridique_en');
                    $txt_direction_general_fr  = $this->input->post('txt_direction_general_fr');
                    $txt_direction_general_en  = $this->input->post('txt_direction_general_en');
                    $txt_actionnariat_fr  = $this->input->post('txt_actionnariat_fr');
                    $txt_actionnariat_en  = $this->input->post('txt_actionnariat_en');
                    $txt_conseil_admin_fr  = $this->input->post('txt_conseil_admin_fr');
                    $txt_conseil_admin_en  = $this->input->post('txt_conseil_admin_en');
                    $txt_produit_fr  = $this->input->post('txt_produit_fr');
                    $txt_produit_en  = $this->input->post('txt_produit_en');
                        // setting up data to insert

                    //-------------------------
                    // PROCESS THE FILE UPLOAD
                    //-------------------------

                    // create the file upload folder if not exists
                    if (!is_dir('./upload/filiale')) {

                        mkdir('./upload/filiale', 0777, true);

                    }

                    // setting upload preferences
                    $config['upload_path']          = './upload/filiale/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                    $config['max_size']             = 2048;
                    $config['max_width']            = 610;
                    $config['max_height']           = 500;

                    // initializing the upload class
                    $this->load->library('upload', $config);

                    //-------------------------
                    $this->upload->do_upload('import-file');

                    // get uploaded file name
                    $data = $this->upload->data('file_name');
                    $toInsert = array(
                        'titre_en' => $txt_title_en,
                        'titre_fr' => $txt_title,
                        'lien_site_description' => $txt_link,
                        'detail_en' => $txt_text_en,
                        'detail_fr' => $txt_text,
                        'image' => $data,
                        'siege_social_en' => $txt_siege_sociale_en,
                        'siege_social_fr' => $txt_siege_sociale,
                        'info_juridique_en' => $txt_info_juridique_en,
                        'info_juridique_fr' => $txt_info_juridique_fr,
                        'direction_general_en' => $txt_direction_general_en,
                        'direction_general_fr' => $txt_direction_general_fr,
                        'actionnariat_en' => $txt_actionnariat_en,
                        'actionnariat_fr' => $txt_actionnariat_fr,
                        'conseil_admin_en' => $txt_conseil_admin_en,
                        'conseil_admin_fr' => $txt_conseil_admin_fr,
                        'produit_en' => $txt_produit_en,
                        'produit_fr' => $txt_produit_fr,
                        'dateCreated_description' => $date,
                        'statut_description' => '1',
                        'createdBy' => $this->session->userdata('user_id'),
                        'id_pays' => $id_pays
                    );

                    // Stock the insertion id for verification
                    $inserted = $this->filiale->create($toInsert);

                    //var_dump($inserted); die();

                    // inserting data
                    if ($inserted) {

                        //----------------------------
                        // Get the data just inserted
                        //
                        // READ DATA FROM filiale
                        //----------------------------
                        // execute the query and return all the required rows
                        $insertedData = $this->filiale->read('*', array('id_description' => $inserted));

                        $data_log = '';

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert = array(
                            'user_log' => $this->session->userdata('user_id'),
                            'table_log' => "filiale",
                            'data_log' => "insert|all|$inserted|0|$data_log",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                        //-------------------
                        $retour = array('type' => 'success', 'message' => 'La filiale a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s !');
                        if(!empty($this->upload->display_errors()))
                        {
                            $retour = array('type' => 'info', 'message' => 'La filiale a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s! Cependant, '.$this->upload->display_errors());
                        }
                        // Return a success message (insertion done)



                    } else { // Return a warning message (the data already exists)
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'filiale');
                    }
                }else{
                    $retour = array('type' => 'warning', 'message' => 'Veuillez renseigner tout les champs s\'il vous plait');
                }
            }
            else { // update data
                //echo "test"; die();
                // Check if all the required data have been posted
                $id_pays = $this->input->post('id_pays');
                $dt_date = $this->input->post('dt_date');
                $txt_title = $this->input->post('txt_title');
                $txt_title_en = $this->input->post('txt_title_en');
                $txt_link = $this->input->post('txt_link');
                $txt_text = $this->input->post('txt_text');
                $txt_text_en  = $this->input->post('txt_text_en');
                $txt_siege_sociale = $this->input->post('txt_siege_sociale');
                $txt_siege_sociale_en = $this->input->post('txt_siege_sociale_en');
                $txt_info_juridique_fr  = $this->input->post('txt_info_juridique_fr');
                $txt_info_juridique_en  = $this->input->post('txt_info_juridique_en');
                $txt_direction_general_fr  = $this->input->post('txt_direction_general_fr');
                $txt_direction_general_en  = $this->input->post('txt_direction_general_en');
                $txt_actionnariat_fr  = $this->input->post('txt_actionnariat_fr');
                $txt_actionnariat_en  = $this->input->post('txt_actionnariat_en');
                $txt_conseil_admin_fr  = $this->input->post('txt_conseil_admin_fr');
                $txt_conseil_admin_en  = $this->input->post('txt_conseil_admin_en');
                $txt_produit_fr  = $this->input->post('txt_produit_fr');
                $txt_produit_en  = $this->input->post('txt_produit_en');

                if (!empty($id_pays) ) {
                    //-------------------------
                    // PROCESS THE FILE UPLOAD
                    //-------------------------


                    $date = DateTime::createFromFormat('d-m-Y', $dt_date);
                    $date = $date->format('Y-m-d H:i:s');
                    $toUpdateData = $this->filiale->read('*', array('id_description' => $aid));

                    $oData_log = '';

                    foreach ($toUpdateData[0] as $key => $value) {
                        $oData_log .= $key . "=>" . $value . "\n";
                    }
                    // create the file upload folder if not exists
                    if (!is_dir('./upload/filiale')) {

                        mkdir('./upload/filiale', 0777, true);

                    }

                    // setting upload preferences
                    $config['upload_path']          = './upload/filiale/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                    $config['max_size']             = 2048;
                    $config['max_width']            = 610;
                    $config['max_height']           = 500;


                    // initializing the upload class
                    $this->load->library('upload', $config);
                    // setting up data to update
                    //echo 'test'; die();

                    if($this->upload->do_upload('import-file')){


                        //-------------------------

                        // get uploaded file name
                        $data = $this->upload->data('file_name');
                        $toUpdate = array(
                            'titre_en' => $txt_title_en,
                            'titre_fr' => $txt_title,
                            'lien_site_description' => $txt_link,
                            'detail_en' => $txt_text_en,
                            'detail_fr' => $txt_text,
                            'image' => $data,
                            'siege_social_en' => $txt_siege_sociale_en,
                            'siege_social_fr' => $txt_siege_sociale,
                            'info_juridique_en' => $txt_info_juridique_en,
                            'info_juridique_fr' => $txt_info_juridique_fr,
                            'direction_general_en' => $txt_direction_general_en,
                            'direction_general_fr' => $txt_direction_general_fr,
                            'actionnariat_en' => $txt_actionnariat_en,
                            'actionnariat_fr' => $txt_actionnariat_fr,
                            'conseil_admin_en' => $txt_conseil_admin_en,
                            'conseil_admin_fr' => $txt_conseil_admin_fr,
                            'produit_en' => $txt_produit_en,
                            'produit_fr' => $txt_produit_fr,
                            'dateCreated_description' => $date,
                            'statut_description' => '1',
                            'createdBy' => $this->session->userdata('user_id'),
                            'id_pays' => $id_pays
                        );
                    }
                    else{
                        $toUpdate = array(
                            'titre_en' => $txt_title_en,
                            'titre_fr' => $txt_title,
                            'lien_site_description' => $txt_link,
                            'detail_en' => $txt_text_en,
                            'detail_fr' => $txt_text,
                            'siege_social_en' => $txt_siege_sociale_en,
                            'siege_social_fr' => $txt_siege_sociale,
                            'info_juridique_en' => $txt_info_juridique_en,
                            'info_juridique_fr' => $txt_info_juridique_fr,
                            'direction_general_en' => $txt_direction_general_en,
                            'direction_general_fr' => $txt_direction_general_fr,
                            'actionnariat_en' => $txt_actionnariat_en,
                            'actionnariat_fr' => $txt_actionnariat_fr,
                            'conseil_admin_en' => $txt_conseil_admin_en,
                            'conseil_admin_fr' => $txt_conseil_admin_fr,
                            'produit_en' => $txt_produit_en,
                            'produit_fr' => $txt_produit_fr,
                            'dateCreated_description' => $date,
                            'statut_description' => '1',
                            'createdBy' => $this->session->userdata('user_id'),
                            'id_pays' => $id_pays
                        );
                    }
                    //echo 'test'; die();
                    // setting up where clause
                    $where = array(
                        'id_description' => $aid,
                    );

                    // Stock the update status for test
                    $updated = $this->filiale->update($where, $toUpdate);


                    // updating data
                    if ($updated) {

                        //--------------------------
                        // Get the row just updated
                        //
                        // READ DATA FROM article
                        //--------------------------
                        // execute the query and return all the required rows
                        $updatedData = $this->filiale->read('*', array('id_description' => $aid));


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
                        $retour = array('type' => 'success', 'message' => 'La filiale a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');
                        if(!empty($this->upload->display_errors()))
                        {
                            $retour = array('type' => 'info', 'message' => 'La filiale a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s! Cependant, '.$this->upload->display_errors());
                        }
                        // Return a success message (update done)


                    } else { // Return a warning message (can't update data)
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour l\'article');
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
        redirect('admin/filiale', 'refresh');

    }
    //----------------------------------------------

    //-------------------
    // ENABLE AN filiale
    //-------------------
    public function enablefiliale () {

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
                'id_filiale'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_filiale'    => '1',
            );

            // Stock the update status for test
            $enabled    = $this->filiale->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($enabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "filiale",
                    'data_log'  => "enable|statut_filiale|$aid|0|1",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'filiale activ&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'filiale!');
            }

        } else { // redirect the user
            redirect('admin/filiale', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user to the data list
        redirect('admin/filiale', 'refresh');

    }
    //-------------------

    //------------------------------
    // ENABLE ALL SELECTED filiale
    //------------------------------
    public function enableSelectedfiliale () {

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
                        'id_filiale'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_filiale'    => '1',
                    );

                    // Stock the update status for test
                    $enable = $this->filiale->update($where, $toUpdate);
                    //---------------------------------------------------------------------------

                    if ($enable) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "filiale",
                            'data_log'  => "disable|statut_filiale|$aid|0|1",
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
            redirect('admin/filiale', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/filiale', 'refresh');

    }
    //------------------------------

    //-------------------
    // DISABLE A filiale
    //-------------------
    public function disablefiliale () {

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
                'id_filiale'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_filiale'    => '0',
            );

            // Stock the update status for test
            $disabled   = $this->filiale->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($disabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "filiale",
                    'data_log'  => "disable|statut_filiale|$aid|1|2",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'filiale d&eacute;sactiv&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'filiale!');
            }

        } else { // redirect the user
            redirect('admin/filiale', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/filiale', 'refresh');

    }
    //-------------------

    //-------------------------------
    // DISABLE ALL SELECTED filiale
    //-------------------------------
    public function disableSelectedfiliale () {

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
                        'id_filiale'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_filiale'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->filiale->update($where, $toUpdate);
                    //----------------------------------------------------------------------------

                    if ($disabled) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "filiale",
                            'data_log'  => "disable|statut_filiale|$aid|1|2",
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
            redirect('admin/filiale', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/filiale', 'refresh');

    }
    //-------------------------------

    //------------------
    // DELETE A filiale
    //------------------
    public function deletefiliale () {

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
                'id_description'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_description'    => '3',
            );

            // Stock the update status for test
            $deleted    = $this->filiale->update($where, $toUpdate);

            $datafiliale = $this->filiale->read('*', array('id_description'        => $aid));


            //------------------------------------------------------------------------------
            if ($deleted) { // success, row's status updated


                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert

                    $toInsert   = array(
                        'user_log'  => $this->session->userdata('user_id'),
                        'table_log' => "description",
                        'data_log'  => "disable|statut_description|$aid|0,1,2|3",
                    );

                    try{
                        // inserting log
                        $this->log_file->create($toInsert);
                    }
                    catch (Exception $e){
                        die("Erreur = > ".$e->getMessage());
                    }
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'filiale supprim&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer la filiale!');
            }

        } else { // redirect the user
            redirect('filiale', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/filiale', 'refresh');

    }
    //------------------

    //------------------------------
    // DELETE ALL SELECTED filiale
    //------------------------------
    public function deleteSelectedfiliales () {

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
                        'id_filiale'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_filiale'    => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->filiale->update($where, $toUpdate);



                    $datafiliale = $this->filiale->read('*', array('id_filiale'        => $aid));

                    $where      = array(
                        'id_user'        => $datafiliale[0]->id_user,
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
                            'table_log' => "filiale",
                            'data_log'  => "disable|statut_filiale|$aid|0,1,2|3",
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
            redirect('filiale', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/filiale', 'refresh');

    }
    //------------------------------


}
?>