<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class chiffrecle extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model('chiffre_cle_table', 'chiffre_cle'); // load the chiffre_cle_table model as 'chiffre_cle'
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'
        $this->load->model('photo_table', 'photo'); // load the photo_table model as 'photo'

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
        $this->data['page_title']       = 'Chiffre clé';
        $this->data['page_description'] = 'gestion des chiffre clé';

        // get the class menu property
        $this->data['menu']             = $this->fonctions->menu;

        // set the active menu item
        $this->data['menu']['chiffre_cle']['chiffre_cle']   = 'active open';

        //-----------------------------------------------

        // get all chars arrays
        $this->data['signed_letters']   = unserialize(SIGNED_LETTERS);
        $this->data['signs']            = unserialize(SIGNS);
    }
    public function index() {

        // call to the chiffre_cle method
        $this->chiffrecle();

    }
    public function chiffrecle() {

        //------------------------------------------------------
        // SET ALL THE CSS AND JS REQUIRED FOR THE CURRENT PAGE
        //------------------------------------------------------

        // all the js required
        // $this->data['javascripts'] = array(
        //     'global/scripts/datatable.js',
        //     'global/plugins/datatables/datatables.min.js',
        //     'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
        //     'pages/scripts/table-datatables-managed.js',
        //     'global/plugins/select2/js/select2.full.min.js',
        //     'pages/scripts/components-select2.min.js',
        //     'pages/scripts/components-date-time-pickers.js',
        //     'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        //     'pages/scripts/custom.js',
        // );
        // all the css required
        // $this->data['css'] = array(
        //     'global/plugins/datatables/datatables.css',
        //     'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
        //     'global/plugins/select2/css/select2.min.css',
        //     'global/plugins/select2/css/select2-bootstrap.min.css',
        //     'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        // );

        //------------------------------------------------------

        //------------------------------------------
        // get list of all chiffre_cles in the database
        //
        // READ DATA FROM chiffre_cle
        //------------------------------------------

        // array of joins to store one or multiple join condition
        $joins      = array();

        // array of all the where condition using OR
        $orWhere    = array();

        // array of all the where condition using AND
        $where      = array(
            'chiffre_cle.statut_chiffre_cle !='     => '3',
        );

        // value of rows the query should return
        $limit      = 0;

        // array of all the order condition
        $order      = array(
            'chiffre_cle.dateCreated_chiffre_cle'   => 'DESC',
        );

        // execute the query and return all the required rows
        $this->data['chiffre_cles'] = $this->chiffre_cle->readJoins('chiffre_cle.id_chiffre_cle,chiffre_cle.titre_chiffre_cle, chiffre_cle.fichier_chiffre_cle, chiffre_cle.dateCreated_chiffre_cle, chiffre_cle.statut_chiffre_cle', $joins, $orWhere, $where, $limit, $order);
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = 'active open';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['filiale']['filiale']    = '';
        
        //----------------------------------------------------

        // include the view with all the data requested
        $this->layer->pages('admin/chiffrecle', 'admin/include/menu', $this->data);

    }
    public function newChiffreCle () {
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;
        $this->data['menu']['chiffre_cle']['chiffre_cle']   = 'active open';
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
        $this->data['chiffrecle']  = '';
        if (!empty($aid)) { 
            $this->data['chiffrecle']      = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $aid));
        }
        $this->layer->pages('admin/new_chiffre_cle', 'admin/include/menu', $this->data);

    }
    public function addChiffrecle () {
        if (!empty($_POST)) {
            $aid = $this->input->post('aid');
            if (empty($aid)) {
                $txt_title = $this->input->post('txt_title');
                $files = $_FILES['import-file']['name'];
                if (!empty($txt_title) AND !empty($files)) {
                    $title  = (!empty($txt_title)) ? $this->input->post('txt_title') : '';
                    if (!empty($title) ) {
                        $dt_date = $this->input->post('dt_date');
                        $date   = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                        $date   = DateTime::createFromFormat('d-m-Y', $date);
                        $date   = $date->format('Y-m-d H:i:s');
                        if (!is_dir('./upload/chiffre_cle')) {
                            mkdir('./upload/chiffre_cle', 0777, true);
                        }
                        $config['upload_path']          = './upload/chiffre_cle/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('import-file')) {
                            $data   = $this->upload->data('file_name');
                            $dataE  = (!empty($_FILES['import-file2']['name']) AND $this->upload->do_upload('import-file2')) ? $this->upload->data('file_name') : '';
                            $toInsert       = array(
                                'titre_chiffre_cle'         => $title,
                                'fichier_chiffre_cle'       => $data,
                                'fichier_chiffre_cle_en'       => $dataE,
                                'dateCreated_chiffre_cle'   => $date,
                                'createdBy'             => $this->session->userdata('user_id'),
                                'statut_chiffre_cle'        => '0',
                            );
                            $inserted   = $this->chiffre_cle->create($toInsert);
                            if ($inserted) {
                                $insertedData   = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $inserted));
                                $data_log = '';
                                foreach($insertedData[0] as $key => $value) {
                                    $data_log   .= $key."=>".$value."\n";
                                }
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "chiffre_cle",
                                    'data_log'  => "insert|all|$inserted|0|$data_log",
                                );
                                $this->log_file->create($toInsert);
                                $retour = array('type' => 'success', 'message' => 'Le fichier a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s!');

                            } else { 
                                $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'chiffre_cle');
                            }
                        } else { 
                            $error = array('error' => $this->upload->display_errors('', ''));
                            $retour = array('type' => 'warning', 'message' => $error['error']);
                        }
                    } else {
                        $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                    }
                } else { 
                    $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                }
            }
            else {
                $txt_title = $this->input->post('txt_title');
                if (!empty($txt_title)) {
                    $aid    = ((int)$this->input->post('aid') > 0) ? (int)$this->input->post('aid') : 0;
                    $title  = (!empty($txt_title)) ? $this->input->post('txt_title') : '';
                    if (!empty($aid) AND !empty($title) ) {
                        $dt_date = $this->input->post('dt_date');
                        $date   = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                        $date   = DateTime::createFromFormat('d-m-Y', $date);
                        $date   = $date->format('Y-m-d H:i:s');
                        $files = $_FILES['import-file']['name'];
                        if (!empty($files)) {
                            if (!is_dir('./upload/chiffre_cle')) {
                                mkdir('./upload/chiffre_cle', 0777, true);
                            }
                            $config['upload_path']          = './upload/chiffre_cle/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('import-file')) { 
                                $data = $this->upload->data('file_name');
                                $dataE  = (!empty($_FILES['import-file2']['name']) AND $this->upload->do_upload('import-file2')) ? $this->upload->data('file_name') : '';
                                $toUpdateData   = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $aid));
                                $oData_log  = '';
                                foreach($toUpdateData[0] as $key => $value) {
                                    $oData_log  .= $key."=>".$value."\n";
                                }
                                $toUpdate   = array(
                                    'titre_chiffre_cle'         => $title,
                                    'fichier_chiffre_cle'       => $data,
                                    'fichier_chiffre_cle_en'       => $dataE,
                                    'dateCreated_chiffre_cle'   => $date
                                );
                                $where      = array(
                                    'id_chiffre_cle'            => $aid,
                                );
                                $updated    = $this->chiffre_cle->update($where, $toUpdate);
                                if ($updated) {
                                    $updatedData    = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $aid));
                                    $data_log = '';
                                    foreach($updatedData[0] as $key => $value) {
                                        $data_log   .= $key."=>".$value."\n";
                                    }
                                    $toInsert   = array(
                                        'user_log'  => $this->session->userdata('user_id'),
                                        'table_log' => "chiffre_cle",
                                        'data_log'  => "update|all|$aid|$oData_log|$data_log",
                                    );
                                    $this->log_file->create($toInsert);
                                    $retour = array('type' => 'success', 'message' => 'Le fichier a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');
                                } else { 
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour l\'chiffre_cle');
                                }
                            } else { 
                                $error = array('error' => $this->upload->display_errors('', ''));
                                $retour = array('type' => 'warning', 'message' => $error['error']);
                            }
                        } else {
                            $toUpdateData   = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $aid));
                            $oData_log  = '';
                            foreach($toUpdateData[0] as $key => $value) {
                                $oData_log  .= $key."=>".$value."\n";
                            }
                            $toUpdate   = array(
                                'titre_chiffre_cle'         => $title,
                                'dateCreated_chiffre_cle'   => $date
                            );
                            $where      = array(
                                'id_chiffre_cle'            => $aid,
                            );
                            $updated    = $this->chiffre_cle->update($where, $toUpdate);
                            if ($updated) {
                                $updatedData    = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $aid));
                                $data_log = '';
                                foreach($updatedData[0] as $key => $value) {
                                    $data_log   .= $key."=>".$value."\n";
                                }
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "chiffre_cle",
                                    'data_log'  => "update|all|$aid|$oData_log|$data_log",
                                );
                                $this->log_file->create($toInsert);
                                $retour = array('type' => 'success', 'message' => 'Le fichier a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');
                            } else {
                                $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour l\'chiffre_cle');
                            }
                        }
                    } else { 
                        $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                    }
                } else {
                    $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                }

            }
        } else {
            $retour = array('type' => 'info', 'message' => 'Tous les champs du fomulaire doivent &ecirc;tres renseign&eacute;s!');
        }
        $this->session->set_flashdata('retour', $retour);
        redirect('admin/chiffrecle', 'refresh');

    }
    public function enableChiffrecle () {
        $e_aid = $this->input->post('e_aid');
        if (!empty($e_aid)) { 
            $aid    = $this->input->post('e_aid');
            $where      = array(
                'id_chiffre_cle'        => $aid,
            );
            $toUpdate   = array(
                'statut_chiffre_cle'    => '1',
            );
            $enabled    = $this->chiffre_cle->update($where, $toUpdate);
            if ($enabled) {
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "chiffre_cle",
                    'data_log'  => "enable|statut_chiffre_cle|$aid|0|1",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'chiffre cle activ&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'chiffre_cle!');
            }

        } else { 
            redirect('admin/chiffrecle', 'refresh');
        }
        $this->session->set_flashdata('retour', $retour);
        redirect('admin/chiffrecle', 'refresh');
    }
    public function enableSelectedchiffre_cles () {

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
                        'id_chiffre_cle'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_chiffre_cle'    => '1',
                    );

                    // Stock the update status for test
                    $enable = $this->chiffre_cle->update($where, $toUpdate);
                    //---------------------------------------------------------------------------

                    if ($enable) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "chiffre_cle",
                            'data_log'  => "disable|statut_chiffre_cle|$aid|0|1",
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
            redirect('admin/chiffrecle', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/chiffrecle', 'refresh');

    }
    public function disableChiffrecle () {
        $d_aid = $this->input->post('d_aid');
        if (!empty($d_aid)) { 
            $aid    = $this->input->post('d_aid');
            $where      = array(
                'id_chiffre_cle'        => $aid,
            );
            $toUpdate   = array(
                'statut_chiffre_cle'    => '0',
            );
            $disabled   = $this->chiffre_cle->update($where, $toUpdate);
            
            if ($disabled) { 
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "chiffre_cle",
                    'data_log'  => "disable|statut_chiffre_cle|$aid|1|2",
                );
                $this->log_file->create($toInsert);
                $retour = array('type' => 'success', 'message' => 'chiffre cle d&eacute;sactiv&eacute; avec succ&egrave;s!');

            } else { 
                $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'chiffre_cle!');
            }

        } else { 
            redirect('admin/chiffrecle', 'refresh');
        }
        $this->session->set_flashdata('retour', $retour);
        redirect('admin/chiffrecle', 'refresh');

    }
    public function disableSelectedchiffre_cles () {

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
                        'id_chiffre_cle'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_chiffre_cle'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->chiffre_cle->update($where, $toUpdate);
                    //----------------------------------------------------------------------------

                    if ($disabled) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "chiffre_cle",
                            'data_log'  => "disable|statut_chiffre_cle|$aid|1|2",
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
            redirect('admin/chiffrecle', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/chiffrecle', 'refresh');

    }
    public function deleteChiffrecle () {

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
                'id_chiffre_cle'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_chiffre_cle'    => '3',
            );

            // Stock the update status for test
            $deleted    = $this->chiffre_cle->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($deleted) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "chiffre_cle",
                    'data_log'  => "disable|statut_chiffre_cle|$aid|0,1,2|3",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'chiffre cle supprim&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer le chiffre cle!');
            }

        } else { // redirect the user
            redirect('chiffrecle', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/chiffrecle', 'refresh');

    }
    public function deleteSelectedchiffre_cles () {

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
                        'id_chiffre_cle'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_chiffre_cle'    => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->chiffre_cle->update($where, $toUpdate);
                    //---------------------------------------------------------------------------

                    if ($deleted) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "chiffre_cle",
                            'data_log'  => "disable|statut_chiffre_cle|$aid|0,1,2|3",
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
            redirect('chiffre_cle', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/chiffrecle', 'refresh');

    }
    public function chiffre_clePhoto () {
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;
        if (!empty($aid)) {
            $this->data['menu']['chiffre_cle']['chiffre_cle']   = 'active open';
            $this->data['javascripts'] = array(
                'global/plugins/dropzone/dropzone.min.js',
                'pages/scripts/form-dropzone.min.js',
                'global/plugins/bootstrap-sweetalert/sweetalert.min.js',
                'pages/scripts/ui-sweetalert.min.js',
                'pages/scripts/custom.js',
            );
            $this->data['css'] = array(
                'global/plugins/dropzone/dropzone.min.css',
                'global/plugins/dropzone/basic.min.css',

                // Portfolio css
                'global/plugins/cubeportfolio/css/cubeportfolio.css',
                'pages/css/portfolio.min.css',

                // Bootstrap Sweetalert css
                'global/plugins/bootstrap-sweetalert/sweetalert.css',
            );
            $this->data['chiffrecle']      = $this->chiffre_cle->read('*', array('id_chiffre_cle' => $aid));
            //----------------------------------

            $this->data['chiffre_clePhotos']    = '';

            // Get all the chiffre_cle photos only if there is a defined chiffre_cle
            if (!empty($this->data['chiffrecle'])) {

                // Set the page description
                $this->data['page_description'] = ucfirst($this->data['chiffrecle'][0]->titre_chiffre_cle);
                $joins      = array(
                    'join0' => array(
                        'table'     => 'chiffre_cle',
                        'condition' => 'chiffre_cle.id_chiffre_cle = photo.id_chiffre_cle',
                        'type'      => 'inner',
                    ),
                );

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'chiffre_cle.id_chiffre_cle'        => $this->data['chiffrecle'][0]->id_chiffre_cle,
                    'chiffre_cle.statut_chiffre_cle !=' => '3',
                    'photo.statut_photo !='     => '3',
                );

                // value of rows the query should return
                $limit      = 0;

                // array of all the order condition
                $order      = array(
                    'photo.dateCreated_photo'   => 'DESC',
                );

                // execute the query and return all the required rows
                $this->data['chiffre_clePhotos']    = $this->photo->readJoins('photo.id_photo, photo.fichier_photo, photo.statut_photo', $joins, $orWhere, $where, $limit, $order);

                //-------------------------------------------------

            } // end if

            // include the view with all the data requested
            $this->layer->pages('admin/chiffrecle_photo', 'admin/include/menu', $this->data);

        } else {

            // Redirect the user to the default controller
            redirect();

        } // End if

    }
    public function addchiffre_clePhoto () { 
        $aid    = ((int)$this->input->post('aid') > 0) ? $this->input->post('aid') : 0;
        if (!empty($aid)) { 
            if (!empty($_FILES['picture']['name'])) {
                if (!is_dir('./upload/'.$aid)) {
                    mkdir('./upload/'.$aid, 0777, true);
                }
                $config['upload_path']          = './upload/'.$aid.'/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']            = str_replace($this->data['signed_letters'], '', str_replace(' ', '_', trim($_FILES['picture']['name'])));
                $config['max_size']             = 2048;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('picture')) {
                    $data = $this->upload->data('file_name');
                    $toInsert       = array(
                        'id_chiffre_cle'    => $aid,
                        'fichier_photo' => $data,
                        'createdBy'     => $this->session->userdata('user_id'),
                        'statut_photo'  => '1',
                    );
                    $inserted   = $this->photo->create($toInsert);
                    if ($inserted) {
                        $insertedData   = $this->photo->read('*', array('id_photo' => $inserted));
                        $data_log = '';
                        foreach($insertedData[0] as $key => $value) {
                            $data_log   .= $key."=>".$value."\n";
                        }
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "photo",
                            'data_log'  => "insert|all|$inserted|0|$data_log",
                        );
                        $this->log_file->create($toInsert);
                    } 
                } 
            } // End if

        } // End if

    } // End function
    //----------------------------------------
}
?>