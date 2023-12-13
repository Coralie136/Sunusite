<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pays extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model('pays_model', 'pays'); // load the pays_table model as 'pays'
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'
        //$this->load->model('photo_table', 'photo'); // load the photo_table model as 'photo'

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
        $this->data['page_title']       = 'pays';
        $this->data['page_description'] = 'gestion des pays';

        // get the class menu property
        $this->data['menu']             = $this->fonctions->menu;

        // set the active menu item
        $this->data['menu']['pays']['pays']   = 'active open';

        //-----------------------------------------------

        // get all chars arrays
        $this->data['signed_letters']   = unserialize(SIGNED_LETTERS);
        $this->data['signs']            = unserialize(SIGNS);
    }

    //----------------------------------------------
    // THE INDEX FUNCTION THAT WILL BE CALLED FIRST
    //----------------------------------------------
    public function index() {

        // call to the pays method
        $this->pays();

    }
    //----------------------------------------------

    //-----------------------------------
    // DISPLAY ALL THE paysS INSERTED
    //-----------------------------------
    public function pays() {

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
        // get list of all payss in the database
        //
        // READ DATA FROM pays
        //------------------------------------------

        // array of joins to store one or multiple join condition
        $joins      = array();

        // array of all the where condition using OR
        $orWhere    = array();

        // array of all the where condition using AND
        $where      = array(
            'pays.statut_pays !='     => '3',
        );

        // value of rows the query should return
        $limit      = 0;

        // array of all the order condition
        $order      = array(
            'pays.dateCreated_pays'   => 'DESC',
        );

        // execute the query and return all the required rows
        //var_dump($this->pays->read('*', $joins, $orWhere, $where, $limit, $order)); die();
        $this->data['payss'] = $this->pays->read('*', $where, $order);
        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = 'active open';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

        //----------------------------------------------------

        // include the view with all the data requested
        $this->layer->pages('admin/pays', 'admin/include/menu', $this->data);

    }
    //-----------------------------------

    //-----------------------------------------
    // DISPLAY AN EMPTY FORM TO ADD AN pays
    //-----------------------------------------
    public function newpays () {

        // Get the pays's id
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;

        // set the title of the current page
//            $this->data['page_description']             = 'Ajouter un pays';

        // set the active menu item
        $this->data['menu']['pays']['pays']   = 'active open';

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

        $this->data['pays']  = '';

        // If the pays's id is not empty
        if (!empty($aid)) { // pays's data for update form

            // set the title of the current page
//                $this->data['page_description'] = 'Modifier l\'pays';

            //----------------------------------
            // GET ALL THE pays INFORMATIONS
            //----------------------------------
            // Execute the query and return all the required rows
            $this->data['pays']      = $this->pays->read('*', array('id_pays' => $aid));
            //----------------------------------

        }
        // end if

        // include the view with all the data requested
        $this->layer->pages('admin/new_pays', 'admin/include/menu', $this->data);

    }
    //-----------------------------------------

    //----------------------------------------------
    // ADD (id == 0) OR UPDATE (id != 0) AN pays
    //----------------------------------------------
    public function addPays () {

        // Check if there are posted data and then process
        if (!empty($_POST)) {

//                var_dump($_POST); var_dump($_FILES['import-file']['name']); exit;
            // Check if we have to insert or update data, the id is defined and not null
            $aid = $this->input->post('aid');
            if (empty($aid)) { // insert data

                // Check if all the required data have been posted
                $txt_name = $this->input->post('txt_name');
                $txt_name_en = $this->input->post('txt_name_en');
                $txt_link = $this->input->post('txt_link');
                $txt_lien_mbp = $this->input->post('txt_lien_mbp');
                if (!empty($txt_name) AND !empty($txt_name_en)) {

                    // Get all the form data
                    $name = (!empty($txt_name)) ? $this->input->post('txt_name') : '';
                    $link = (!empty($txt_link)) ? $this->input->post('txt_link') : '';
                    $nameE = (!empty($txt_name_en)) ? $this->input->post('txt_name_en') : '';
                    $linkMbp = (!empty($txt_lien_mbp)) ? $this->input->post('txt_lien_mbp') : '';

//                        var_dump(2147483648 + mt_rand( -2147482448, 2147483647 )); exit;
                    if (!empty($name) AND !empty($nameE)) {

                        $dt_date = $this->input->post('dt_date');
                        $date = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                        $date = DateTime::createFromFormat('d-m-Y', $date);
                        $date = $date->format('Y-m-d H:i:s');

                        //--------------------------
                        // PROCESS pays'S CREATION
                        //--------------------------

                        // setting up data to insert
                        $toInsert = array(
                            'nom_pays' => $name,
                            'nom_pays_en' => $nameE,
                            'lien_site' => $link,
                            'lien_mbp' => $linkMbp,
                            'dateCreated_pays' => $date,
                            'createdBy' => $this->session->userdata('user_id'),
                            'statut_pays' => '1',
                        );

                        // Stock the insertion id for verification
                        $inserted = $this->pays->create($toInsert);

                        // inserting data
                        if ($inserted) {

                            //----------------------------
                            // Get the data just inserted
                            //
                            // READ DATA FROM pays
                            //----------------------------
                            // execute the query and return all the required rows
                            $insertedData = $this->pays->read('*', array('id_pays' => $inserted));

                            $data_log = '';

                            foreach ($insertedData[0] as $key => $value) {
                                $data_log .= $key . "=>" . $value . "\n";
                            }
                            //----------------------------

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                            // setting up data to insert
                            $toInsert = array(
                                'user_log' => $this->session->userdata('user_id'),
                                'table_log' => "pays",
                                'data_log' => "insert|all|$inserted|0|$data_log",
                            );

                            // inserting log
                            $this->log_file->create($toInsert);
                            //-------------------

                            // Return a success message (insertion done)
                            $retour = array('type' => 'success', 'message' => 'Le pays a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s!');

                        } else { // Return a warning message (the data already exists)
                            $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'pays');
                        }
                        //-------------------------

                    } else { // Return a danger message (data are not correct)
                        $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                    }

                } else { // Return an info message (you must fill in all the required fields)
                    $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                }

            } else { // update data
                $name = $this->input->post('txt_name');
                $nameE = $this->input->post('txt_name_en');
                $link = $this->input->post('txt_link');
                $linkMbp = $this->input->post('txt_lien_mbp');

//                        var_dump(2147483648 + mt_rand( -2147482448, 2147483647 )); exit;
                if (!empty($name) AND !empty($nameE)) {

                    $dt_date = $this->input->post('dt_date');
                    $date = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                    $date = DateTime::createFromFormat('d-m-Y', $date);
                    $date = $date->format('Y-m-d H:i:s');

                    //--------------------------
                    // PROCESS pays'S CREATION
                    //--------------------------
                    $dt_date = $this->input->post('dt_date');
                    $date = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                    $date = DateTime::createFromFormat('d-m-Y', $date);
                    $date = $date->format('Y-m-d H:i:s');

                    //-------------------------------
                    // Get the row we have to update
                    //
                    // READ DATA FROM pays
                    //-------------------------------
                    // execute the query and return all the required rows
                    $toUpdateData = $this->pays->read('*', array('id_pays' => $aid));

                    $oData_log = '';

                    foreach ($toUpdateData[0] as $key => $value) {
                        $oData_log .= $key . "=>" . $value . "\n";
                    }
                    //-------------------------------


                    //--------------------------
                    // PROCESS pays'S UPDATE
                    //--------------------------
                    // setting up data to insert
                    $toUpdate = array(
                        'nom_pays' => $name,
                        'nom_pays_en' => $nameE,
                        'lien_site' => $link,
                        'lien_mbp' => $linkMbp,
                        'dateCreated_pays' => $date,
                        'createdBy' => $this->session->userdata('user_id'),
                        'statut_pays' => '1',
                    );
                    //var_dump($toUpdate); die();
                    // setting up where clause
                    $where = array(
                        'id_pays' => $aid,
                    );

                    // Stock the update status for test
                    $updated = $this->pays->update($where, $toUpdate);

                    // updating data
                    if ($updated) {

                        //--------------------------
                        // Get the row just updated
                        //
                        // READ DATA FROM pays
                        //--------------------------
                        // execute the query and return all the required rows
                        $updatedData = $this->pays->read('*', array('id_pays' => $aid));

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
                            'table_log' => "pays",
                            'data_log' => "update|all|$aid|$oData_log|$data_log",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                        //-------------------

                        // Return a success message (update done)
                        $retour = array('type' => 'success', 'message' => 'Le pays a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');

                    } else { // Return a warning message (can't update data)
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour le pays');
                    }

                } else { // Return a danger message (data are not correct)
                    $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                }
            }
        } else { // Return an info message (you must fill in all the required fields)
                $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
            }



        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/pays', 'refresh');

    }
    //----------------------------------------------

    //-------------------
    // ENABLE AN pays
    //-------------------
    public function enablepays () {

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
                'id_pays'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_pays'    => '1',
            );

            // Stock the update status for test
            $enabled    = $this->pays->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($enabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "pays",
                    'data_log'  => "enable|statut_pays|$aid|0|1",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'pays activ&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'pays!');
            }

        } else { // redirect the user
            redirect('admin/pays', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user to the data list
        redirect('admin/pays', 'refresh');

    }
    //-------------------

    //------------------------------
    // ENABLE ALL SELECTED paysS
    //------------------------------
    public function enableSelectedpayss () {

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
                        'id_pays'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_pays'    => '1',
                    );

                    // Stock the update status for test
                    $enable = $this->pays->update($where, $toUpdate);
                    //---------------------------------------------------------------------------

                    if ($enable) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "pays",
                            'data_log'  => "disable|statut_pays|$aid|0|1",
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
            redirect('admin/pays', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/pays', 'refresh');

    }
    //------------------------------

    //-------------------
    // DISABLE A pays
    //-------------------
    public function disablepays () {

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
                'id_pays'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_pays'    => '0',
            );

            // Stock the update status for test
            $disabled   = $this->pays->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($disabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "pays",
                    'data_log'  => "disable|statut_pays|$aid|1|2",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'pays d&eacute;sactiv&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'pays!');
            }

        } else { // redirect the user
            redirect('admin/pays', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/pays', 'refresh');

    }
    //-------------------

    //-------------------------------
    // DISABLE ALL SELECTED paysS
    //-------------------------------
    public function disableSelectedpayss () {

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
                        'id_pays'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_pays'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->pays->update($where, $toUpdate);
                    //----------------------------------------------------------------------------

                    if ($disabled) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "pays",
                            'data_log'  => "disable|statut_pays|$aid|1|2",
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
            redirect('admin/pays', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/pays', 'refresh');

    }
    //-------------------------------

    //------------------
    // DELETE A pays
    //------------------
    public function deletePays () {

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
                'id_pays'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_pays'    => '3',
            );

            // Stock the update status for test
            $deleted    = $this->pays->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($deleted) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "pays",
                    'data_log'  => "disable|statut_pays|$aid|0,1,2|3",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'pays supprim&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer l\'pays!');
            }

        } else { // redirect the user
            redirect('pays', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/pays', 'refresh');

    }
    //------------------

    //------------------------------
    // DELETE ALL SELECTED paysS
    //------------------------------
    public function deleteSelectedpayss () {

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
                        'id_pays'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_pays'    => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->pays->update($where, $toUpdate);
                    //---------------------------------------------------------------------------

                    if ($deleted) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "pays",
                            'data_log'  => "disable|statut_pays|$aid|0,1,2|3",
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
            redirect('pays', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/pays', 'refresh');

    }
    //------------------------------


    //----------------------------------------------------------------------
    // GET ALL THE pays PICTURES AND DISPLAY EACH WITH OPTION TO ADD NEW
    //----------------------------------------------------------------------
    public function paysPhoto () {

        // Get the pays's id
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;

        // Proccess only if there is a defined pays
        if (!empty($aid)) {

            // set the active menu item
            $this->data['menu']['pays']['pays']   = 'active open';

            //-----------------------------------------------------------------
            // SET ALL THE CSS, JS AND FUNCTIONS REQUIRED FOR THE CURRENT PAGE
            //-----------------------------------------------------------------

            // all the js required
            $this->data['javascripts'] = array(
//                        'global/plugins/jquery-validation/js/jquery.validate.min.js',
//                        'global/plugins/jquery-validation/js/additional-methods.min.js',
//                        'pages/scripts/form-validation-md.js',
//                        'global/plugins/select2/js/select2.full.min.js',
//                        'pages/scripts/components-select2.min.js',
//                        'global/plugins/moment.min.js',
//                        'global/plugins/bootstrap-daterangepicker/daterangepicker.min.js',
//                        'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
//                        'global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
//                        'global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
//                        'global/plugins/clockface/js/clockface.js',
//                        'pages/scripts/components-date-time-pickers.min.js',
//                        'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
//                        'global/plugins/ckeditor/ckeditor.js',

                // Dropzone form js
                'global/plugins/dropzone/dropzone.min.js',
                'pages/scripts/form-dropzone.min.js',

                // Portfolio js
//                        'global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js',
//                        'pages/scripts/portfolio-1.min.js',

                // Bootstrap Sweetalert js
                'global/plugins/bootstrap-sweetalert/sweetalert.min.js',
                'pages/scripts/ui-sweetalert.min.js',

                // Custom js
                'pages/scripts/custom.js',
            );

            // all the css required
            $this->data['css'] = array(
//                        'global/plugins/select2/css/select2.min.css',
//                        'global/plugins/select2/css/select2-bootstrap.min.css',
//                        'global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
//                        'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
//                        'global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
//                        'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
//                        'global/plugins/clockface/css/clockface.css',
//                        'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',

                // Dropzone form css
                'global/plugins/dropzone/dropzone.min.css',
                'global/plugins/dropzone/basic.min.css',

                // Portfolio css
                'global/plugins/cubeportfolio/css/cubeportfolio.css',
                'pages/css/portfolio.min.css',

                // Bootstrap Sweetalert css
                'global/plugins/bootstrap-sweetalert/sweetalert.css',
            );

            //-----------------------------------------------------------------

            //----------------------------------
            // GET ALL THE pays INFORMATIONS
            //----------------------------------
            // Execute the query and return all the required rows
            $this->data['pays']      = $this->pays->read('*', array('id_pays' => $aid));
            //----------------------------------

            $this->data['paysPhotos']    = '';

            // Get all the pays photos only if there is a defined pays
            if (!empty($this->data['pays'])) {

                // Set the page description
                $this->data['page_description'] = ucfirst($this->data['pays'][0]->titre_pays);

                //-------------------------------------------------
                // Get list of all photos for the current pays
                //
                // READ DATA FROM photo JOIN pays ON id_pays
                //-------------------------------------------------

                // array of joins to store one or multiple join condition
                $joins      = array(
                    'join0' => array(
                        'table'     => 'pays',
                        'condition' => 'pays.id_pays = photo.id_pays',
                        'type'      => 'inner',
                    ),
                );

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'pays.id_pays'        => $this->data['pays'][0]->id_pays,
                    'pays.statut_pays !=' => '3',
                    'photo.statut_photo !='     => '3',
                );

                // value of rows the query should return
                $limit      = 0;

                // array of all the order condition
                $order      = array(
                    'photo.dateCreated_photo'   => 'DESC',
                );

                // execute the query and return all the required rows
                $this->data['paysPhotos']    = $this->photo->readJoins('photo.id_photo, photo.fichier_photo, photo.statut_photo', $joins, $orWhere, $where, $limit, $order);

                //-------------------------------------------------

            } // end if

            // include the view with all the data requested
            $this->layer->pages('admin/pays_photo', 'admin/include/menu', $this->data);

        } else {

            // Redirect the user to the default controller
            redirect();

        } // End if

    }
    //----------------------------------------------------------------------

    //----------------------------------------
    // ADD PHOTOS TO THE CURRENT SENT pays
    //----------------------------------------
    public function addpaysPhoto () { // function to add photo to pays

        // Get the defined pays id
        $aid    = ((int)$this->input->post('aid') > 0) ? $this->input->post('aid') : 0;

        // Check if the pays already exists or not
        if (!empty($aid)) { // set director informations

            // Check if all the required data have been posted
            if (!empty($_FILES['picture']['name'])) {

                //-------------------------
                // PROCESS THE FILE UPLOAD
                //-------------------------

                // create the file upload folder if not exists
                if (!is_dir('./upload/'.$aid)) {

                    mkdir('./upload/'.$aid, 0777, true);

                }

                // setting upload preferences
                $config['upload_path']          = './upload/'.$aid.'/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']            = str_replace($this->data['signed_letters'], '', str_replace(' ', '_', trim($_FILES['picture']['name'])));
//                                $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                $config['max_size']             = 2048;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;

                // initializing the upload class
                $this->load->library('upload', $config);

                //-------------------------

                if ($this->upload->do_upload('picture')) {

                    // get uploaded file name
                    $data = $this->upload->data('file_name');

                    //-----------------------------
                    // SET DIRECTOR'S INFORMATIONS
                    //-----------------------------

                    // setting up data to insert
                    $toInsert       = array(
                        'id_pays'    => $aid,
                        'fichier_photo' => $data,
                        'createdBy'     => $this->session->userdata('user_id'),
                        'statut_photo'  => '1',
                    );

                    // Stock the insertion id for verification
                    $inserted   = $this->photo->create($toInsert);

                    // inserting data
                    if ($inserted) {

                        //----------------------------
                        // Get the data just inserted
                        //
                        // READ DATA FROM photo
                        //----------------------------
                        // execute the query and return all the required rows
                        $insertedData   = $this->photo->read('*', array('id_photo' => $inserted));

                        $data_log = '';

                        foreach($insertedData[0] as $key => $value) {
                            $data_log   .= $key."=>".$value."\n";
                        }
                        //----------------------------

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "photo",
                            'data_log'  => "insert|all|$inserted|0|$data_log",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                        //-------------------

                    } // End if
                    //-----------------------------

                } // End if

            } // End if

        } // End if

    } // End function
    //----------------------------------------
}
?>