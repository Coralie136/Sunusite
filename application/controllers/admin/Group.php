<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller{
 
        public function __construct () {

            parent::__construct();

            //------------------------------------------------
            // LOAD MODELS REQUIRE FOR THE CURRENT CONTROLLER
            //------------------------------------------------
            
                $this->load->model('experience_table', 'experience'); // load the 'experience_table' model as 'experience'
                $this->load->model('history_table', 'historique'); // load the 'history_table' model as 'historique'
                $this->load->model('log', 'log_file'); // load the log model as 'log_file'
                $this->load->model('team_table', 'equipe'); // load the 'team_table' model as 'equipe'
                $this->load->model('text_table', 'texte'); // load the 'text_table' model as 'texte'
                $this->load->model('text_type', 'typeTexte'); // load the 'text_type' model as 'typeTexte'
                $this->load->model('Reseau_table', 'reseau'); // load the 'text_type' model as 'reseau'

            //------------------------------------------------

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
                $this->data['logged_in']                = $logged_in;

                // set the title of the current page
                $this->data['page_title']               = 'Le Groupe';
                //    $this->data['page_description']         = 'Gestion des appréciations';

                // get the class menu property
                $this->data['menu']                     = $this->fonctions->menu;

                // set the active menu item
                $this->data['menu']['group']['group']   = 'active open';
            
                // get all chars arrays
                $this->data['letters']  = unserialize(LETTERS);
                $this->data['numbers']  = unserialize(NUMBERS);
                $this->data['signs']    = unserialize(SIGNS);

             //-----------------------------------------------

        }
        public function index () {

            // call to the history method
            $this->history();

        }

        public function history () {

            // set the title of the current page
            $this->data['page_description']         = 'Historique';

            // set the active menu item
            $this->data['menu']['group']['history'] = 'active open';
            $this->data['menu']['group']['director']    = '';
            $this->data['menu']['group']['text']    = '';
            $this->data['menu']['image']['image']    = '';
            $this->data['menu']['image']['slider']    = '';
            $this->data['menu']['group']['network']    = '';
            $this->data['menu']['pays']['pays']    = '';
            $this->data['menu']['contact']['contact']    = '';
            $this->data['menu']['filiale']['filiale']    = '';
            $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

                $this->data['javascripts'] = array(
                    'global/scripts/datatable.js',
                    'global/plugins/datatables/datatables.min.js',
                    'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
                    'pages/scripts/table-datatables-managed.js',
                    'global/plugins/select2/js/select2.full.min.js',
                    'pages/scripts/components-select2.min.js',
                    'global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js',
                    'pages/scripts/custom.js',
                );
                // all the css required
                $this->data['css'] = array(
                    'global/plugins/datatables/datatables.min.css',
                    'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
                    'global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
                    'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                    'global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
                    'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
                    'global/plugins/clockface/css/clockface.css',
                    'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
                    'global/plugins/select2/css/select2.min.css',
                    'global/plugins/select2/css/select2-bootstrap.min.css',

                    'layouts/layout/css/custom.css',
                );

            //-----------------------------------------------------------------

            //-----------------------------------------
            // Get all the histories from the database
            //
            // READ DATA FROM historique
            //-----------------------------------------

                // array of joins to store one or multiple join condition
                $joins      = array();

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'historique.statut_historique !='   => '3',
                );

                // value of rows the query should return
                $limit      = 0;

                // array of all the order condition
                $order      = array(
                    'historique.dateCreated_historique' => 'DESC',
                );

                // execute the query and return all the required rows
                $this->data['histories']    = $this->historique->readJoins('*', $joins, $orWhere, $where, $limit, $order);

            //-----------------------------------------

            // include the view with all the data requested
            $this->layer->pages('admin/history', 'admin/include/menu', $this->data);
            
        }

        //pas encore fait
        public function addHistory () {

            // Check if there are posted data and then process
            if (!empty($_POST)) {

                // Check if we have to insert or update data, the id is defined and not null
                $hid = (int)$this->input->post('hid');
                if (empty($hid)) { // insert data

                    // Check if all the required data have been posted
                    $slt_year = $this->input->post('slt_year');
                    $txt_history = $this->input->post('txt_history');
                    $txt_history_en = $this->input->post('txt_history_en');
                    $slt_month = $this->input->post('slt_month');
                    if (!empty($slt_year) AND !empty($txt_history)) {

                        // Get all the form data
                        $month  = (!empty($slt_month)) ? $this->input->post('slt_month') : 0;
                        $year   = (!empty($slt_year)) ? $this->input->post('slt_year') : 1;
                        $text   = (!empty($txt_history)) ? $this->input->post('txt_history') : '';
                        $textEn = (!empty($txt_history_en)) ? $this->input->post('txt_history_en') : '';

                        if(!empty($year) AND !empty($text)){

                            //--------------------------
                            // PROCESS HISTORY CREATION
                            //--------------------------

                                // setting up data to insert
                                $toInsert = array(
                                    'annee_historique'      => $year,
                                    'mois_historique'       => $month,
                                    'texte_historique'      => $text,
                                    'texte_historique_en'   => $textEn,
                                    'createdBy'             => $this->session->userdata('user_id'),
                                    'statut_historique'     => '1',
                                );

                                // Stock the insertion id for verification
                                $inserted   = $this->historique->create($toInsert);

                                // inserting data
                                if ($inserted) {

                                    //-----------------------------
                                    // Get the data just inserted
                                    //
                                    // READ DATA FROM historique
                                    //-----------------------------
                                        // execute the query and return all the required rows
                                        $insertedData   = $this->historique->read('*', array('id_historique' => $inserted));

                                        $data_log = '';

                                        foreach($insertedData[0] as $key => $value) {
                                            $data_log   .= $key."=>".$value."\n";
                                        }
                                    //-----------------------------

                                    //-------------------
                                    // UPDATE LOG'S DATA
                                    //-------------------
                                        // setting up data to insert
                                        $toInsert   = array(
                                            'user_log'  => $this->session->userdata('user_id'),
                                            'table_log' => "historique",
                                            'data_log'  => "insert|all|$inserted|0|$data_log",
                                        );

                                        // inserting log
                                        $this->log_file->create($toInsert);
                                    //-------------------

                                    // Return a success message (data successfully added)
                                    $retour = array('type' => 'success', 'message' => 'L\'historique a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s!');

                                } else { // Return a warning message (the data already exists)
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'historique');
                                }
                            //--------------------------

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    } // End if

                } else { // update data

                    // Check if all the required data have been posted
                    $hid = $this->input->post('hid');
                    $slt_year = $this->input->post('slt_year');
                    $slt_month = $this->input->post('slt_month');
                    $txt_history = $this->input->post('txt_history');
                    $txt_history_en = $this->input->post('txt_history_en');
                    if (!empty($hid) AND !empty($slt_year) AND !empty($txt_history)) {

                        // Get all the form data
                        $hid      = ((int)$hid > 0) ? (int)$this->input->post('hid') : 0;

                        $month  = (!empty($slt_month)) ? $this->input->post('slt_month') : 0;
                        $year   = (!empty($slt_year)) ? $this->input->post('slt_year') : 1;
                        $text   = (!empty($txt_history)) ? $this->input->post('txt_history') : '';
                        $textEn = (!empty($txt_history_en)) ? $this->input->post('txt_history_en') : '';

                        if (!empty($hid) AND !empty($year) AND !empty($text)) {

                            //--------------------------------
                            // Get the data we have to update
                            //
                            // READ DATA FROM historique
                            //--------------------------------
                                // execute the query and return all the required rows
                                $toUpdateData   = $this->historique->read('*', array('id_historique' => $hid));

                                $oData_log      = '';

                                foreach($toUpdateData[0] as $key => $value) {
                                    $oData_log  .= $key."=>".$value."\n";
                                }
                            //--------------------------------

                            //-----------------------------
                            // PROCESS HISTORY UPDATE
                            //-----------------------------

                                // Where clause
                                $where          = array(
                                    'id_historique'         => $hid,
                                    'statut_historique !='  => '3',
                                );

                                // setting up data to update
                                $toUpdate       = array(
                                    'annee_historique'      => $year,
                                    'mois_historique'       => $month,
                                    'texte_historique'      => $text,
                                    'texte_historique_en'   => $textEn,
                                );
                                
                                // Stock the update status for test
                                $updated    = $this->historique->update($where, $toUpdate);

                                // update data
                                if ($updated) {

                                    //---------------------------
                                    // Get the data just updated
                                    //
                                    // READ DATA FROM historique
                                    //---------------------------
                                        // execute the query and return all the required rows
                                        $updatedData    = $this->historique->read('*', array('id_historique' => $hid));

                                        $data_log = '';

                                        foreach($updatedData[0] as $key => $value) {
                                            $data_log   .= $key."=>".$value."\n";
                                        }
                                    //---------------------------

                                    //-------------------
                                    // UPDATE LOG'S DATA
                                    //-------------------
                                        // setting up data to insert
                                        $toInsert   = array(
                                            'user_log'  => $this->session->userdata('user_id'),
                                            'table_log' => "historique",
                                            'data_log'  => "update|all|$hid|$oData_log|$data_log",
                                        );

                                        // inserting log
                                        $this->log_file->create($toInsert);
                                    //-------------------

                                    // Return a success message (row successfully updated)
                                    $retour = array('type' => 'success', 'message' => 'L\'historique a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');

                                } else { // Return a warning message (the data already exists)
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de modifier l\'historique');
                                }
                            //-----------------------------

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    }

                } // End if

            } else { // Return an info message (you must fill in all the fields)
                $retour = array('type' => 'info', 'message' => 'Tous les champs du fomulaire doivent &ecirc;tres renseign&eacute;s!');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/history', 'refresh');
            
        }

        public function enableHistory () {

            // Process only if there is an id selected
            $e_hid = $this->input->post('e_hid');
            if (!empty($e_hid)) { // process

                // Get the sent row's id
                $hid    = $this->input->post('e_hid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $hid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_historique'     => $hid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_historique' => '1',
                    );

                    // Stock the update status for test
                    $enabled    = $this->historique->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($enabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "historique",
                            'data_log'  => "enable|statut_historique|$hid|0|1",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Historique activ&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'historique!');
                }

            } else { // redirect the user
                redirect('admin/group/history', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user to the data list
            redirect('admin/group/history', 'refresh');

        }

        public function enableSelectedHistories () {
                
            // Process only if there is an id selected
            $e_hids = $this->input->post('e_hids');
            if (!empty($e_hids)) { // process

                // Get the sent row's id
                $hids       = $this->input->post('e_hids');
                $allDone    = true;
                $done       = 0;

                foreach ($hids as $hid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 1, id == $hid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_historique'     => $hid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_historique' => '1',
                            );

                            // Stock the update status for test
                            $enable = $this->historique->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($enable) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "historique",
                                    'data_log'  => "disable|statut_historique|$hid|0|1",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($hids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; activ&eacute;e avec succès!');
                }

            } else { // redirect the user
                redirect('admin/group/history', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/history', 'refresh');
            
        }

        public function disableHistory () {

            // Process only if there is an id selected
            $d_hid = $this->input->post('d_hid');
            if (!empty($d_hid)) { // process

                // Get the sent row's id
                $hid    = $this->input->post('d_hid');

                    $where      = array(
                        'id_historique'     => $hid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_historique' => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->historique->update($where, $toUpdate);
                //----------------------------------------------------------------------------

                if ($disabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "historique",
                            'data_log'  => "disable|statut_historique|$hid|1|2",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Historique d&eacute;sactiv&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'historique!');
                }

            } else { // redirect the user
                redirect('admin/group/history', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/history', 'refresh');

        }

        public function disableSelectedHistories () {
                
            // Process only if there is an id selected
            $d_hids = $this->input->post('d_hids');
            if (!empty($d_hids)) { // process

                // Get the sent row's id
                $hids       = $this->input->post('d_hids');
                $allDone    = true;
                $done       = 0;

                foreach ($hids as $hid) {
                    if ($allDone) {
                        //----------------------------------------------------------------------------
                        // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $hid)
                        //----------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_historique'     => $hid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_historique' => '0',
                            );

                            // Stock the update status for test
                            $disabled   = $this->historique->update($where, $toUpdate);
                        //----------------------------------------------------------------------------

                        if ($disabled) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "historique",
                                    'data_log'  => "disable|statut_historique|$hid|1|2",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($hids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; d&eacute;sactiv&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/history', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/history', 'refresh');
            
        }
   
        public function deleteHistory () {

            // Process only if there is an id selected
            $rm_hid = $this->input->post('rm_hid');
            if (!empty($rm_hid)) { // process

                // Get the sent row's id
                $hid    = $this->input->post('rm_hid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $hid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_historique'     => $hid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_historique' => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->historique->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($deleted) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "historique",
                            'data_log'  => "disable|statut_historique|$hid|0,1,2|3",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Historique supprim&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer l\'historique!');
                }

            } else { // redirect the user
                redirect('admin/group/history', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/history', 'refresh');

        }

        public function deleteSelectedHistories () {
                
            // Process only if there is an id selected
            $rm_hids = $this->input->post('rm_hids');
            if (!empty($rm_hids)) { // process

                // Get the sent row's id
                $hids       = $this->input->post('rm_hids');
                $allDone    = true;
                $done       = 0;

                foreach ($hids as $hid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // DELETE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $hid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_historique'     => $hid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_historique' => '3',
                            );

                            // Stock the update status for test
                            $deleted    = $this->historique->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($deleted) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "historique",
                                    'data_log'  => "disable|statut_historique|$hid|0,1,2|3",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($hids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/history', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/history', 'refresh');
            
        }

        public function text() {

            // set the title of the current page
            $this->data['page_description']         = 'Textes';

            // set the active menu item
            $this->data['menu']['group']['text']    = 'active open';
            $this->data['menu']['image']['image']    = '';
            $this->data['menu']['image']['slider']    = '';
            $this->data['menu']['group']['network']    = '';
            $this->data['menu']['pays']['pays']    = '';
            $this->data['menu']['contact']['contact']    = '';
            $this->data['menu']['filiale']['filiale']    = '';
            $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

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

            //---------------------------------------
            // get list of all texts in the database
            //
            // READ DATA FROM texte
            //---------------------------------------

                // array of joins to store one or multiple join condition
                $joins      = array(
                    'join0' => array(
                        'table'     => 'type_texte',
                        'condition' => 'type_texte.id_type_texte = texte.id_type_texte',
                        'type'      => 'inner',
                    ),
                );

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'texte.statut_texte !='     => '3',
                );

                // value of rows the query should return
                $limit      = 0;

                // array of all the order condition
                $order      = array(
                    'texte.dateCreated_texte'   => 'DESC',
                );

                // execute the query and return all the required rows
                $this->data['texts']    = $this->texte->readJoins('type_texte.id_type_texte, type_texte.nom_type_texte, texte.id_texte, texte.contenu_texte, texte.dateCreated_texte, texte.statut_texte', $joins, $orWhere, $where, $limit, $order);

            //---------------------------------------

            // include the view with all the data requested
            $this->layer->pages('admin/text', 'admin/include/menu', $this->data);

        }

        public function newText () {
                        
            // Get the text's id
            $tid    = ((int)$this->input->get('tid') > 0) ? (int)$this->input->get('tid') : 0 ;

            // set the title of the current page
            $this->data['page_description']         = 'Textes';

            // set the active menu item
            $this->data['menu']['group']['text']    = 'active open';

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

                // // all the css required
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
            
            // Get all the text types from database
            $this->data['types']    = $this->typeTexte->read('id_type_texte, nom_type_texte', array('statut_type_texte' => '1'));

            $this->data['text']     = '';
            
            // If the text's id is not empty
            if (!empty($tid)) { // text's data for update form

                // set the title of the current page
                $this->data['page_description'] = 'Modifier le texte';

                //----------------------------------
                // GET ALL THE TEXT INFORMATIONS
                //----------------------------------
                    // Execute the query and return all the required rows
                    $this->data['text']         = $this->texte->read('*', array('id_texte' => $tid));
                //----------------------------------

            }
            // end if

            // include the view with all the data requested
            $this->layer->pages('admin/new_text', 'admin/include/menu', $this->data);
            
        }

        //pas encore fait
        public function addText () {

            // Check if there are posted data and then process
            if (!empty($_POST)) {

                // Check if we have to insert or update data, the id is defined and not null
                $tid = $this->input->post('tid');
                if (empty($tid)) { // insert data

                    // Check if all the required data have been posted
                    $slt_type = $this->input->post('slt_type');
                    $txt_text = $this->input->post('txt_text');
                    $txt_text_en = $this->input->post('txt_text_en');
                    if (!empty($slt_type) AND !empty($txt_text)) {

                        // Get all the form data
                        $type   = ((int)$slt_type > 0) ? (int)$this->input->post('slt_type') : 0;
                        $text   = (!empty($txt_text)) ? $this->input->post('txt_text') : '';
                        $textE  = (!empty($txt_text_en)) ? $this->input->post('txt_text_en') : '';

                        // Check if the required data are really defined
                        if (!empty($type) AND !empty($text)) {

                            //-------------------------
                            // PROCESS TEXT'S CREATION
                            //-------------------------

                                // setting up data to insert
                                $toInsert       = array(
                                    'id_type_texte'     => $type,
                                    'contenu_texte'     => $text,
                                    'contenu_texte_en'  => $textE,
                                    'createdBy'         => $this->session->userdata('user_id'),
                                    'statut_texte'      => '1',
                                );

                                // Stock the insertion id for verification
                                $inserted   = $this->texte->create($toInsert);

                                // inserting data
                                if ($inserted) {

                                    //----------------------------
                                    // Get the data just inserted
                                    //
                                    // READ DATA FROM texte
                                    //----------------------------
                                        // execute the query and return all the required rows
                                        $insertedData   = $this->texte->read('*', array('id_texte' => $inserted));

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
                                            'table_log' => "texte",
                                            'data_log'  => "insert|all|$inserted|0|$data_log",
                                        );

                                        // inserting log
                                        $this->log_file->create($toInsert);
                                    //-------------------

                                    // Return a success message (insertion done)
                                    $retour = array('type' => 'success', 'message' => 'Le texte a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s!');

                                } else { // Return a warning message (the data already exists)
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de le texte');
                                }
                            //------------------------

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    }

                } else { // update data

                    // Check if all the required data have been posted
                    $slt_type = $this->input->post('slt_type');
                    $txt_text = $this->input->post('txt_text');
                    $txt_text_en = $this->input->post('txt_text_en');
                    $tid = (int)$this->input->post('tid');
                    if (!empty($slt_type) AND !empty($txt_text) AND !empty($txt_text_en)) {

                        // Get all the form data
                        $tid    = ((int)$tid > 0) ? (int)$this->input->post('tid') : 0;

                        // Get all the form data
                        $type   = ((int)$slt_type > 0) ? (int)$this->input->post('slt_type') : 0;
                        $text   = (!empty($txt_text)) ? $this->input->post('txt_text') : '';
                        $textE  = (!empty($txt_text_en)) ? $this->input->post('txt_text_en') : '';

                        // Check if all the required data have been defined
                        if (!empty($tid) AND !empty($type) AND !empty($text)) {

                            //-------------------------------
                            // Get the row we have to update
                            //
                            // READ DATA FROM texte
                            //-------------------------------
                                // execute the query and return all the required rows
                                $toUpdateData   = $this->texte->read('*', array('id_texte' => $tid));

                                $oData_log  = '';

                                foreach($toUpdateData[0] as $key => $value) {
                                    $oData_log  .= $key."=>".$value."\n";
                                }
                            //-------------------------------

                            //--------------------------
                            // PROCESS TEXT'S UPDATE
                            //--------------------------

                                // setting up data to update
                                $toUpdate   = array(
                                    'id_type_texte'     => $type,
                                    'contenu_texte'     => $text,
                                    'contenu_texte_en'  => $textE,
                                );

                                // setting up where clause
                                $where      = array(
                                    'id_texte'          => $tid,
                                );

                                // Stock the update status for test
                                $updated    = $this->texte->update($where, $toUpdate);

                                // updating data
                                if ($updated) {

                                    //--------------------------
                                    // Get the row just updated
                                    //
                                    // READ DATA FROM texte
                                    //--------------------------
                                        // execute the query and return all the required rows
                                        $updatedData    = $this->texte->read('*', array('id_texte' => $tid));

                                        $data_log = '';

                                        foreach($updatedData[0] as $key => $value) {
                                            $data_log   .= $key."=>".$value."\n";
                                        }
                                    //--------------------------

                                    //-------------------
                                    // UPDATE LOG'S DATA
                                    //-------------------
                                        // setting up data to insert
                                        $toInsert   = array(
                                            'user_log'  => $this->session->userdata('user_id'),
                                            'table_log' => "texte",
                                            'data_log'  => "update|all|$tid|$oData_log|$data_log",
                                        );

                                        // inserting log
                                        $this->log_file->create($toInsert);
                                    //-------------------

                                    // Return a success message (update done)
                                    $retour = array('type' => 'success', 'message' => 'Le texte a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');

                                } else { // Return a warning message (can't update data)
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour le texte');
                                }
                            //---------------------------

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    }

                }

            } else { // Return an info message (you must fill in all the fields)
                $retour = array('type' => 'info', 'message' => 'Tous les champs du fomulaire doivent &ecirc;tres renseign&eacute;s!');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/text', 'refresh');
            
        }
        
        public function enableText () {

            // Process only if there is an id selected
            $e_tid = $this->input->post('e_tid');
            if (!empty($e_tid)) { // process

                // Get the sent row's id
                $tid    = $this->input->post('e_tid');

                //---------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                //---------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_texte'      => $tid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_texte'  => '1',
                    );

                    // Stock the update status for test
                    $enabled    = $this->texte->update($where, $toUpdate);
                //---------------------------------------------------------------------------

                if ($enabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "texte",
                            'data_log'  => "enable|statut_texte|$tid|0|1",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Texte activ&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer le texte!');
                }

            } else { // redirect the user
                redirect('admin/group/text', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user to the data list
            redirect('admin/group/text', 'refresh');

        }

        public function enableSelectedTexts () {
                
            // Process only if there is an id selected
            $e_tids = $this->input->post('e_tids');
            if (!empty($e_tids)) { // process

                // Get the sent row's id
                $tids       = $this->input->post('e_tids');
                $allDone    = true;
                $done       = 0;

                foreach ($tids as $tid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 1, id == $tid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_texte'      => $tid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_texte'  => '1',
                            );

                            // Stock the update status for test
                            $enable = $this->texte->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($enable) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "texte",
                                    'data_log'  => "disable|statut_texte|$tid|0|1",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($tids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; activ&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/text', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/text', 'refresh');
            
        }

        public function disableText () {

            // Process only if there is an id selected
            $d_tid = $this->input->post('d_tid');
            if (!empty($d_tid)) { // process

                // Get the sent row's id
                $tid    = $this->input->post('d_tid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_texte'      => $tid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_texte'  => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->texte->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($disabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "texte",
                            'data_log'  => "disable|statut_texte|$tid|1|2",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Texte d&eacute;sactiv&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver le texte!');
                }

            } else { // redirect the user
                redirect('admin/group/text', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/text', 'refresh');

        }

        public function disableSelectedTexts () {
                
            // Process only if there is an id selected
            $d_tids = $this->input->post('d_tids');
            if (!empty($d_tids)) { // process

                // Get the sent row's id
                $tids       = $this->input->post('d_tids');
                $allDone    = true;
                $done       = 0;

                foreach ($tids as $tid) {
                    if ($allDone) {
                        //----------------------------------------------------------------------------
                        // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                        //----------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_texte'      => $tid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_texte'  => '0',
                            );

                            // Stock the update status for test
                            $disabled   = $this->texte->update($where, $toUpdate);
                        //----------------------------------------------------------------------------

                        if ($disabled) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "texte",
                                    'data_log'  => "disable|statut_texte|$tid|1|2",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($tids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; d&eacute;sactiv&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/text', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/text', 'refresh');
            
        }

        public function deleteText () {

            // Process only if there is an id selected
            $rm_tid = $this->input->post('rm_tid');
            if (!empty($rm_tid)) { // process

                // Get the sent row's id
                $tid    = $this->input->post('rm_tid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $tid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_texte'      => $tid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_texte'  => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->texte->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($deleted) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "texte",
                            'data_log'  => "disable|statut_texte|$tid|0,1,2|3",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Texte supprim&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer le texte!');
                }

            } else { // redirect the user
                redirect('admin/group/text', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/text', 'refresh');

        }

        public function deleteSelectedTexts () {
                
            // Process only if there is an id selected
            $rm_tids = $this->input->post('rm_tids');
            if (!empty($rm_tids)) { // process

                // Get the sent row's id
                $tids       = $this->input->post('rm_tids');
                $allDone    = true;
                $done       = 0;

                foreach ($tids as $tid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // DELETE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_texte'      => $tid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_texte'  => '3',
                            );

                            // Stock the update status for test
                            $deleted    = $this->texte->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($deleted) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "texte",
                                    'data_log'  => "disable|statut_texte|$tid|0,1,2|3",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($tids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/text', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/text', 'refresh');
            
        }

        public function director () {

            // set the title of the current page
            $this->data['page_description']             = 'Directeur';

            // set the active menu item
            $this->data['menu']['group']['director']    = 'active open';
            $this->data['menu']['group']['text']    = '';
            $this->data['menu']['image']['image']    = '';
            $this->data['menu']['image']['slider']    = '';
            $this->data['menu']['group']['network']    = '';
            $this->data['menu']['pays']['pays']    = '';
            $this->data['menu']['contact']['contact']    = '';
            $this->data['menu']['filiale']['filiale']    = '';
            $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

            $this->data['javascripts'] = array(
                'global/scripts/app.min.js',
                'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
                'global/plugins/jquery.sparkline.min.js',
                'pages/scripts/profile.min.js',
                'global/plugins/ckeditor/ckeditor.js',
                
                'global/scripts/datatable.js',
                'global/plugins/datatables/datatables.min.js',
                'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
                'pages/scripts/table-datatables-managed.js',
                'global/plugins/select2/js/select2.full.min.js',
                'pages/scripts/components-select2.min.js',
                'global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js',
                'pages/scripts/custom.js',
            );
            //     // all the css required
                $this->data['css'] = array(
                    'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
                    'pages/css/profile.min.css',
                    
                    'global/plugins/datatables/datatables.min.css',
                    'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
                    'global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
                    'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                    'global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
                    'global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
                    'global/plugins/clockface/css/clockface.css',
                    'global/plugins/select2/css/select2.min.css',
                    'global/plugins/select2/css/select2-bootstrap.min.css',
                    'layouts/layout/css/custom.css',
                );
                $joins      = array();

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'equipe.directeur_equipe'   => 1,
                    'equipe.statut_equipe'      => '1',
                );

                // value of rows the query should return
                $limit      = 1;

                // array of all the order condition
                $order      = array();

                // execute the query and return all the required rows
                $this->data['director'] = $this->equipe->readJoins('equipe.id_equipe, equipe.nom_equipe, equipe.prenom_equipe, equipe.fonction_equipe, equipe.fonction_equipe_en, equipe.biographie_equipe, equipe.biographie_equipe_en, equipe.fichier_equipe', $joins, $orWhere, $where, $limit, $order);

            //---------------------------------------------
            
            // Set the default value of director experiences
            $this->data['experiences']  = '';
            
            // Process only if there is a defined director
            $director = $this->data['director'];
            if (!empty($director)) {
                    $joins      = array();

                    // array of all the where condition using OR
                    $orWhere    = array();

                    // array of all the where condition using AND
                    $where      = array(
                        'id_equipe'                         => $this->data['director'][0]->id_equipe,
                        'experience.statut_experience !='   => '3',
                    );

                    // value of rows the query should return
                    $limit      = 0;

                    // array of all the order condition
                    $order      = array(
                        'experience.periode_experience'     => 'ASC',
                    );

                    // execute the query and return all the required rows
                    $this->data['experiences']  = $this->experience->readJoins('*', $joins, $orWhere, $where, $limit, $order);

                //-------------------------------------------
                
            } // End if

            // include the view with all the data requested
            $this->layer->pages('admin/director', 'admin/include/menu', $this->data);

        }

        //pas encore fait
        public function setDirectorInfo(){ 
            if (!empty($_POST)) {
                
                // Get the director id
                $did    = ((int)$this->input->post('did') > 0) ? $this->input->post('did') : 0;
                
                // Check if the director already exists or not
                if (!empty($did)) {
                        $joins      = array();

                        // array of all the where condition using OR
                        $orWhere    = array();

                        // array of all the where condition using AND
                        $where      = array(
                            'equipe.id_equipe'          => $did,
                            'equipe.directeur_equipe'   => 1,
                            'equipe.statut_equipe'      => '1',
                        );

                        // value of rows the query should return
                        $limit      = 1;

                        // array of all the order condition
                        $order      = array();

                        $director   = $this->equipe->readJoins('equipe.id_equipe, equipe.nom_equipe, equipe.prenom_equipe, equipe.fonction_equipe, equipe.fonction_equipe_en, equipe.biographie_equipe, equipe.biographie_equipe_en, equipe.fichier_equipe', $joins, $orWhere, $where, $limit, $order);
                    if (!empty($director)) {

                        // set the datas updated status
                        $dataUpdated    = false;

                            $txt_lastName = $this->input->post('txt_lastName');
                            if (!empty($txt_lastName) AND mb_strtolower(trim($txt_lastName)) != $director[0]->nom_equipe) {

                                // get the new director last name
                                $directorLastName   = mb_strtolower(trim(addslashes($this->input->post('txt_lastName'))));

                                // setting up data to update
                                $toUpdate   = array(
                                    'nom_equipe'    => $directorLastName,
                                );
                                $where      = array(
                                    'id_equipe'     => $did,
                                );

                                // updating director last name
                                if ($this->equipe->update($where, $toUpdate)) {
                                    // set the new director last name value
                                    $uDirectorLastName  = $directorLastName;

                                    // set the datas updated status
                                    $dataUpdated    = true;
                                }

                            } else {
                                // set the new director last name value
                                $uDirectorLastName  = $director[0]->nom_equipe;
                            }
                        
                            $this->input->post('txt_firstName');
                            if (!empty($txt_firstName) AND mb_strtolower(trim($txt_firstName)) != $director[0]->prenom_equipe) {

                                // get the new director first name
                                $directorFirstName  = mb_strtolower(trim(addslashes($this->input->post('txt_firstName'))));

                                // setting up data to update
                                $toUpdate   = array(
                                    'prenom_equipe' => $directorFirstName,
                                );
                                $where      = array(
                                    'id_equipe'     => $did,
                                );

                                // updating user director first name
                                if ($this->equipe->update($where, $toUpdate)) {
                                    // set the new director first name value
                                    $uDirectorFirstName = $directorFirstName;

                                    // set the datas updated status
                                    $dataUpdated    = true;
                                }

                            } else {
                                // set the new director first name value
                                $uDirectorFirstName = $director[0]->prenom_equipe;
                            }
                       
                            $txt_role = strtolower($this->input->post('txt_role'));
                            if (!empty($txt_role) AND trim($txt_role) != trim($director[0]->fonction_equipe)) {

                                // get the new director role
                                $directorRole   = trim(addslashes($this->input->post('txt_role')));

                                // setting up data to update
                                $toUpdate   = array(
                                    'fonction_equipe'   => $directorRole,
                                );
                                $where      = array(
                                    'id_equipe'         => $did,
                                );

                                // updating director role
                                if ($this->equipe->update($where, $toUpdate)) {
                                    // set the new director role value
                                    $uDirectorRole  = $directorRole;

                                    // set the data updated status
                                    $dataUpdated    = true;
                                }

                            } else {
                                // set the new director role value
                                $uDirectorRole      = $director[0]->fonction_equipe;
                            }
                       
                            $txt_role_en = strtolower($this->input->post('txt_role_en'));
                            if (!empty($txt_role_en) AND trim($txt_role_en) != trim($director[0]->fonction_equipe_en)) {

                                // get the new director role
                                $directorRoleE  = trim(addslashes($this->input->post('txt_role_en')));

                                // setting up data to update
                                $toUpdate   = array(
                                    'fonction_equipe_en'    => $directorRoleE,
                                );
                                $where      = array(
                                    'id_equipe'             => $did,
                                );

                                // updating director role
                                if ($this->equipe->update($where, $toUpdate)) {
                                    // set the new director role value
                                    $uDirectorRoleE = $directorRoleE;

                                    // set the data updated status
                                    $dataUpdated    = true;
                                }

                            } else {
                                // set the new director role value
                                $uDirectorRoleE     = $director[0]->fonction_equipe_en;
                            }
                        
                            $txt_biography = strtolower($this->input->post('txt_biography'));
                            if (!empty($txt_biography) AND trim($txt_biography) != trim($director[0]->biographie_equipe)) {

                                // get the new director biography
                                $directorBiography  = trim(addslashes($this->input->post('txt_biography')));

                                // setting up data to update
                                $toUpdate   = array(
                                    'biographie_equipe' => $directorBiography,
                                );
                                $where      = array(
                                    'id_equipe'         => $did,
                                );

                                // updating director biography
                                if ($this->equipe->update($where, $toUpdate)) {
                                    // set the new director biography value
                                    $uDirectorBiography = $directorBiography;

                                    // set the datas updated status
                                    $dataUpdated    = true;
                                }

                            } else {
                                // set the new director biography value
                                $uDirectorBiography = $director[0]->biographie_equipe;
                            }
                     
                            $txt_biography_en = strtolower($this->input->post('txt_biography_en'));
                            if (!empty($txt_biography_en) AND trim($txt_biography_en) != trim($director[0]->biographie_equipe_en)) {

                                // get the new director biography
                                $directorBiographyE = trim(addslashes($this->input->post('txt_biography_en')));

                                // setting up data to update
                                $toUpdate   = array(
                                    'biographie_equipe_en'  => $directorBiographyE,
                                );
                                $where      = array(
                                    'id_equipe'             => $did,
                                );

                                // updating director biography
                                if ($this->equipe->update($where, $toUpdate)) {
                                    // set the new director biography value
                                    $uDirectorBiographyE    = $directorBiographyE;

                                    // set the datas updated status
                                    $dataUpdated            = true;
                                }

                            } else {
                                // set the new director biography value
                                $uDirectorBiographyE        = $director[0]->biographie_equipe_en;
                            }
                       
                            if (!empty($_FILES['picture']['name'])) {

                                // create the picture upload folder if not exists
                                if (!is_dir('./upload')) {

                                    mkdir('./upload', 0777, true);

                                }

                                // setting upload preferences
                                $config['upload_path']          = './upload/';
                                $config['allowed_types']        = 'gif|jpg|png';
                                $config['file_name']            = str_replace(' ', '_', trim($_FILES['picture']['name']));
                                $config['max_size']             = 2048;
                                $config['max_width']            = 1024;
                                $config['max_height']           = 1024;

                                // initializing the upload class
                                $this->load->library('upload', $config);

                                if (!$this->upload->do_upload('picture')) { // picture upload failed

                                    // get the error
                                    $error = array('error' => $this->upload->display_errors('', ''));

                                    // warning, an error occur during upload
                                    $retour = array('type' => 'warning', 'message' => $error['error']);

                                    // 
                                    $this->session->set_flashdata('retour', $retour);

                                    // include the view with the all the data requested
                                    redirect('admin/group/director', 'refresh');

                                } else { // picture upload succeed

                                    // get uploaded file name
                                    $data = $this->upload->data('file_name');

                                    // setting up data to update
                                    $toUpdate   = array(
                                        'fichier_equipe'    => $data,
                                    );
                                    $where      = array(
                                        'id_equipe'         => $did,
                                    );

                                    // updating user picture
                                    if ($this->equipe->update($where, $toUpdate)) {

                                        // set the new director picture value
                                        $uPicture   = $data;

                                        // set the data updated status
                                        $dataUpdated    = true;

                                    }

                                }

                            } else {
                                // set the new director picture value
                                $uDirectorPicture   = $director[0]->fichier_equipe;
                            }

                        //---------------------------------

                        // 
                        if ($dataUpdated == true) {
                            // Set the process feedback
                            $retour = array('type' => 'success', 'message' => 'Les informations du directeur ont &eacute;t&eacute; correctement d&eacute;finies!');
                        } else {
                            // 
                            $retour = array('type' => 'success', 'message' => 'Aucune nouvelle information n\'a été renseignée!');
                        } // End if

                    } // End if
                
                } else { // set director informations
                    
                    // Check if all the required data have been posted
                    $txt_lastName = trim($this->input->post('txt_lastName'));
                    $txt_firstName = trim($this->input->post('txt_firstName'));
                    $txt_biography = trim($this->input->post('txt_biography'));
                    $txt_biography_en = trim($this->input->post('txt_biography_en'));
                    if (!empty($txt_lastName) AND !empty($txt_firstName) AND !empty($txt_biography) AND !empty($_FILES['picture']['name'])) {

                        // Get all the required form data
                        $lastName   = (!empty($txt_lastName)) ? mb_strtolower($txt_lastName) : '';
                        $firstName  = (!empty($txt_firstName)) ? mb_strtolower($txt_firstName) : '';
                        $biography  = (!empty($txt_biography)) ? $this->input->post('txt_biography') : '';
                        $biographyE = (!empty($txt_biography_en)) ? $this->input->post('txt_biography_en') : '';

                        // Check if all the required data have been correctly sent
                        if (!empty($lastName) AND !empty($firstName) AND !empty($biography)) {

                            // Get all the others form data
                            $txt_role = $this->input->post('txt_role');
                            $txt_role_en = $this->input->post('txt_role_en');
                            $role       = (!empty($txt_role)) ? $this->input->post('txt_role') : '';
                            $roleE      = (!empty($txt_role_en)) ? $this->input->post('txt_role_en') : '';
                            
                                if (!is_dir('./upload')) {

                                    mkdir('./upload', 0777, true);

                                }

                                // setting upload preferences
                                $config['upload_path']          = './upload/';
                                $config['allowed_types']        = 'gif|jpg|png';
                                $config['file_name']            = str_replace(' ', '_', trim($_FILES['picture']['name']));
                                //$config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                                $config['max_size']             = 2048;
                                $config['max_width']            = 1024;
                                $config['max_height']           = 1024;

                                // initializing the upload class
                                $this->load->library('upload', $config);
                            
                            //-------------------------

                            if ($this->upload->do_upload('picture')) {
                                
                                // get uploaded file name
                                $data = $this->upload->data('file_name');

                                
                                    $toInsert       = array(
                                        'nom_equipe'            => $lastName,
                                        'prenom_equipe'         => $firstName,
                                        'directeur_equipe'      => 1,
                                        'fonction_equipe'       => $role,
                                        'fonction_equipe_en'    => $roleE,
                                        'biographie_equipe'     => $biography,
                                        'biographie_equipe_en'  => $biographyE,
                                        'fichier_equipe'        => $data,
                                        'createdBy'             => $this->session->userdata('user_id'),
                                        'statut_equipe'         => '1',
                                    );

                                    // Stock the insertion id for verification
                                    $inserted   = $this->equipe->create($toInsert);

                                    // inserting data
                                    if ($inserted) {

                                       
                                            $insertedData   = $this->equipe->read('*', array('id_equipe' => $inserted));

                                            $data_log = '';

                                            foreach($insertedData[0] as $key => $value) {
                                                $data_log   .= $key."=>".$value."\n";
                                            }
                                       
                                            $toInsert   = array(
                                                'user_log'  => $this->session->userdata('user_id'),
                                                'table_log' => "equipe",
                                                'data_log'  => "insert|all|$inserted|0|$data_log",
                                            );

                                            // inserting log
                                            $this->log_file->create($toInsert);
                                        //-------------------

                                        // Return a success message (insertion done)
                                        $retour = array('type' => 'success', 'message' => 'Les informations du directeur ont &eacute;t&eacute; enregistr&eacute;e avec succ&egrave;s!');

                                    } else { // Return a warning message (an error occurs)
                                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de d&eacute;finir les informations du directeur');
                                    }
                                //-----------------------------

                            } else { 
                                $error = array('error' => $this->upload->display_errors('', ''));

                                // warning, an error occur during upload
                                $retour = array('type' => 'warning', 'message' => $error['error']);
                            }

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        } // End if

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    } // End if
                    
                } // End if

                // Set the sendback message
                $this->session->set_flashdata('retour', $retour);

                // redirect the user to director informations
                redirect('admin/group/director');

            } else {
                // redirect the user to director informations
                redirect('admin/group/director');
            } // End if

        } // End function
    
        //pas encore fait
        public function addExperience () {
            if (!empty($_POST)) {
                $eid = (int)$this->input->post('eid');
                if (empty($eid)) { 
                    $did = $this->input->post('did');
                    $txt_period = (int)$this->input->post('txt_period');
                    $txt_experience = (int)$this->input->post('txt_experience');
                    $txt_experience_en = (int)$this->input->post('txt_experience_en');
                    if (!empty($did) AND !empty($txt_period) AND !empty($txt_experience) AND !empty($txt_experience_en)) {
                        $did        = ((int)$this->input->post('did') > 0) ? $this->input->post('did') : 0;
                        $period     = (!empty($txt_period)) ? $this->input->post('txt_period') : '';
                        $text       = (!empty($txt_experience)) ? $this->input->post('txt_experience') : '';
                        $textEn     = (!empty($txt_experience_en)) ? $this->input->post('txt_experience_en') : '';
                        if (!empty($did) AND !empty($period) AND !empty($text)) {
                                $toInsert       = array(
                                    'id_equipe'             => $did,
                                    'periode_experience'    => $period,
                                    'texte_experience'      => $text,
                                    'texte_experience_en'   => $textEn,
                                    'createdBy'             => $this->session->userdata('user_id'),
                                    'statut_experience'     => '1',
                                );
                                $inserted   = $this->experience->create($toInsert);
                                if ($inserted) {
                                        $insertedData   = $this->experience->read('*', array('id_experience' => $inserted));
                                        $data_log = '';
                                        foreach($insertedData[0] as $key => $value) {
                                            $data_log   .= $key."=>".$value."\n";
                                        }
                                        $toInsert   = array(
                                            'user_log'  => $this->session->userdata('user_id'),
                                            'table_log' => "experience",
                                            'data_log'  => "insert|all|$inserted|0|$data_log",
                                        );
                                        $this->log_file->create($toInsert);
                                    $retour = array('type' => 'success', 'message' => 'L\'exp&eacute;rience a &eacute;t&eacute; cr&eacute;&eacute;e avec succ&egrave;s!');
                                } else {
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'exp&eacute;rience');
                                }
                        } else { 
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }
                    } else {
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    } // End if

                } else { 
                    $eid = $this->input->post('eid');
                    $did = $this->input->post('did');
                    $txt_period = $this->input->post('txt_period');
                    $txt_experience = $this->input->post('txt_experience');
                    $txt_experience_en = $this->input->post('txt_experience_en');
                    if (!empty($eid) AND !empty($did) AND !empty($txt_period) AND !empty($txt_experience) AND !empty($txt_experience_en)) {

                        // Get all the form data
                        $eid    = ((int)$this->input->post('eid') > 0) ? (int)$this->input->post('eid') : 0;

                        $did    = ((int)$this->input->post('did') > 0) ? $this->input->post('did') : 0;
                        $period = (!empty($txt_period)) ? $this->input->post('txt_period') : '';
                        $text   = (!empty($txt_experience)) ? $this->input->post('txt_experience') : '';
                        $textEn = (!empty($txt_experience_en)) ? $this->input->post('txt_experience_en') : '';
                        if (!empty($eid) AND !empty($did) AND !empty($period) AND !empty($text)) {
                                $toUpdateData   = $this->experience->read('*', array('id_experience' => $eid));
                                $oData_log      = '';
                                foreach($toUpdateData[0] as $key => $value) {
                                    $oData_log  .= $key."=>".$value."\n";
                                }
                                $where          = array(
                                    'id_experience'         => $eid,
                                    'id_equipe'             => $did,
                                    'statut_experience !='  => '3',
                                );
                                $toUpdate       = array(
                                    'periode_experience'    => $period,
                                    'texte_experience'      => $text,
                                    'texte_experience_en'   => $textEn,
                                );
                                $updated    = $this->experience->update($where, $toUpdate);
                                if ($updated) {
                                        $updatedData    = $this->experience->read('*', array('id_experience' => $eid));

                                        $data_log = '';

                                        foreach($updatedData[0] as $key => $value) {
                                            $data_log   .= $key."=>".$value."\n";
                                        }
                                        $toInsert   = array(
                                            'user_log'  => $this->session->userdata('user_id'),
                                            'table_log' => "experience",
                                            'data_log'  => "update|all|$eid|$oData_log|$data_log",
                                        );
                                        $this->log_file->create($toInsert);
                                    $retour = array('type' => 'success', 'message' => 'L\'exp&eacute;rience a &eacute;t&eacute;e modifi&eacute; avec succ&egrave;s!');
                                } else { 
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de modifier l\'exp&eacute;rience');
                                }
                        } else { 
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }
                    } else { 
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    }
                } // End if
            } else { 
                $retour = array('type' => 'info', 'message' => 'Tous les champs du fomulaire doivent &ecirc;tres renseign&eacute;s!');
            }
            $this->session->set_flashdata('retour', $retour);
            redirect('admin/group/director#director_tab_2', 'refresh');
            
        }
   
        public function enableExperience () {

            // Process only if there is an id selected
            $e_eid = $this->input->post('e_eid');
            if (!empty($e_eid)) { // process

                // Get the sent row's id
                $eid    = $this->input->post('e_eid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $eid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_experience'     => $eid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_experience' => '1',
                    );

                    // Stock the update status for test
                    $enabled    = $this->experience->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($enabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "experience",
                            'data_log'  => "enable|statut_experience|$eid|0|1",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Exp&eacute;rience activ&eacute;e avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'exp&eacute;rience!');
                }

            } else { // redirect the user
                redirect('admin/group/director#director_tab_2', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user to the data list
            redirect('admin/group/director#director_tab_2', 'refresh');

        }

        public function enableSelectedExperiences () {
                
            // Process only if there is an id selected
            $e_eids = $this->input->post('e_eids');
            if (!empty($e_eids)) { // process

                // Get the sent row's id
                $eids       = $this->input->post('e_eids');
                $allDone    = true;
                $done       = 0;

                foreach ($eids as $eid) {
                    if ($allDone) {
                            $where      = array(
                                'id_experience'     => $eid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_experience' => '1',
                            );

                            // Stock the update status for test
                            $enable = $this->experience->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($enable) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "experience",
                                    'data_log'  => "disable|statut_experience|$eid|0|1",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($eids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; activ&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/director#director_tab_2', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/director#director_tab_2', 'refresh');
            
        }

        public function disableExperience () {

            // Process only if there is an id selected
            $d_eid = $this->input->post('d_eid');
            if (!empty($d_eid)) { // process

                // Get the sent row's id
                $eid    = $this->input->post('d_eid');

                //----------------------------------------------------------------------------
                // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $eid)
                //----------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_experience'     => $eid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_experience' => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->experience->update($where, $toUpdate);
                //----------------------------------------------------------------------------

                if ($disabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "experience",
                            'data_log'  => "disable|statut_experience|$eid|1|2",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Exp&eacute;rience d&eacute;sactiv&eacute;e avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'exp&eacute;rience!');
                }

            } else { // redirect the user
                redirect('admin/group/director#director_tab_2', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/director#director_tab_2', 'refresh');

        }

        public function disableSelectedExperiences () {
                
            // Process only if there is an id selected
            $d_eids = $this->input->post('d_eids');
            if (!empty($d_eids)) { // process

                // Get the sent row's id
                $eids       = $this->input->post('d_eids');
                $allDone    = true;
                $done       = 0;

                foreach ($eids as $eid) {
                    if ($allDone) {
                        //----------------------------------------------------------------------------
                        // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $eid)
                        //----------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_experience'     => $eid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_experience' => '0',
                            );

                            // Stock the update status for test
                            $disabled   = $this->experience->update($where, $toUpdate);
                        //----------------------------------------------------------------------------

                        if ($disabled) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "experience",
                                    'data_log'  => "disable|statut_experience|$eid|1|2",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($eids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; d&eacute;sactiv&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/director#director_tab_2', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/director#director_tab_2', 'refresh');
            
        }

        public function deleteExperience () {

            // Process only if there is an id selected
            $rm_eid = $this->input->post('rm_eid');
            if (!empty($rm_eid)) { // process

                // Get the sent row's id
                $eid    = $this->input->post('rm_eid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $eid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_experience'     => $eid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_experience' => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->experience->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($deleted) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "experience",
                            'data_log'  => "disable|statut_experience|$eid|0,1,2|3",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Exp&eacute;rience supprim&eacute;e avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer l\'exp&eacute;rience!');
                }

            } else { // redirect the user
                redirect('admin/group/director#director_tab_2', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/director#director_tab_2', 'refresh');

        }

        public function deleteSelectedExperiences () {
                
            // Process only if there is an id selected
            $rm_eids = $this->input->post('rm_eids');
            if (!empty($rm_eids)) { // process

                // Get the sent row's id
                $eids       = $this->input->post('rm_eids');
                $allDone    = true;
                $done       = 0;

                foreach ($eids as $eid) {
                    if ($allDone) {
     
                            $where      = array(
                                'id_experience'     => $eid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_experience' => '3',
                            );

                            // Stock the update status for test
                            $deleted    = $this->experience->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($deleted) { // success, row's status updated

                            $done++;
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "experience",
                                    'data_log'  => "disable|statut_experience|$eid|0,1,2|3",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($eids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/director#director_tab_2', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/director#director_tab_2', 'refresh');
            
        }

        public function team() {

            // set the title of the current page
            $this->data['page_description']         = '&Eacute;quipe';

            // set the active menu item
            $this->data['menu']['group']['team']    = 'active open';
            $this->data['menu']['group']['director']    = '';
            $this->data['menu']['group']['text']    = '';
            $this->data['menu']['image']['image']    = '';
            $this->data['menu']['image']['slider']    = '';
            $this->data['menu']['group']['network']    = '';
            $this->data['menu']['pays']['pays']    = '';
            $this->data['menu']['contact']['contact']    = '';
            $this->data['menu']['filiale']['filiale']    = '';
            $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

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

            //--------------------------------------------
            // Get list of all team mates in the database
            //
            // READ DATA FROM equipe
            //--------------------------------------------

                // array of joins to store one or multiple join condition
                $joins      = array();

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'equipe.directeur_equipe'   => 0,
                    'equipe.statut_equipe !='   => '3',
                );

                // value of rows the query should return
                $limit      = 0;

                // array of all the order condition
                $order      = array();

                // execute the query and return all the required rows
                $this->data['teammates']    = $this->equipe->readJoins('equipe.id_equipe, equipe.nom_equipe, equipe.prenom_equipe, equipe.fonction_equipe, equipe.fonction_equipe_en, equipe.fichier_equipe, equipe.statut_equipe', $joins, $orWhere, $where, $limit, $order);

            //--------------------------------------------

            // include the view with all the data requested
            $this->layer->pages('admin/team', 'admin/include/menu', $this->data);

        }

        public function newTeam () {
                        
            // Get the team mate id
            $tid    = ((int)$this->input->get('tid') > 0) ? (int)$this->input->get('tid') : 0 ;

            // set the title of the current page
            $this->data['page_description']         = '&Eacute;quipe';

            // set the active menu item
            $this->data['menu']['group']['team']    = 'active open';

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
            
            $this->data['teammate'] = '';

            // If the team mate id is not empty
            if (!empty($tid)) {
                    $this->data['teammate'] = $this->equipe->read('*', array('id_equipe' => $tid));
                //------------------------------------

            }
            // end if

            // include the view with all the data requested
            $this->layer->pages('admin/new_team', 'admin/include/menu', $this->data);
            
        }

        public function addTeam () {
            if (!empty($_POST)) {
                $tid    = ((int)$this->input->post('tid') > 0) ? $this->input->post('tid') : 0;
                if (!empty($tid)) {
                        $joins      = array();
                        $orWhere    = array();
                        $where      = array(
                            'equipe.id_equipe'          => $tid,
                            'equipe.directeur_equipe'   => 0,
                            'equipe.statut_equipe !='   => '3',
                        );
                        $limit      = 1;
                        $order      = array();
                        $teammate   = $this->equipe->readJoins('equipe.id_equipe, equipe.nom_equipe, equipe.prenom_equipe, equipe.fonction_equipe, equipe.fonction_equipe_en, equipe.fichier_equipe', $joins, $orWhere, $where, $limit, $order);
                    if (!empty($teammate)) {
                        $dataUpdated    = false;
                            $txt_lastName = $this->input->post('txt_lastName');
                            if (!empty($txt_lastName) AND mb_strtolower(trim($txt_lastName)) != trim($teammate[0]->nom_equipe)) {
                                $teammateLastName   = mb_strtolower(trim(addslashes($this->input->post('txt_lastName'))));
                                $toUpdate   = array(
                                    'nom_equipe'    => $teammateLastName,
                                );
                                $where      = array(
                                    'id_equipe'     => $tid,
                                );
                                if ($this->equipe->update($where, $toUpdate)) {
                                    $uTeammateLastName  = $teammateLastName;
                                    $dataUpdated    = true;
                                }
                            } else {
                                $uTeammateLastName  = $teammate[0]->nom_equipe;
                            }
                            $txt_firstName = $this->input->post('txt_firstName');
                            if (!empty($txt_firstName) AND mb_strtolower(trim($txt_firstName)) != $teammate[0]->prenom_equipe) {
                                $teammateFirstName  = mb_strtolower(trim(addslashes($this->input->post('txt_firstName'))));
                                $toUpdate   = array(
                                    'prenom_equipe' => $teammateFirstName,
                                );
                                $where      = array(
                                    'id_equipe'     => $tid,
                                );
                                if ($this->equipe->update($where, $toUpdate)) {
                                    $uTeammateFirstName = $teammateFirstName;
                                    $dataUpdated    = true;
                                }

                            } else {
                                $uTeammateFirstName = $teammate[0]->prenom_equipe;
                            }
                       
                            $txt_role = strtolower($this->input->post('txt_role'));
                            if (!empty($txt_role) AND trim($txt_role) != trim($teammate[0]->fonction_equipe)) {
                                $teammateRole   = trim(addslashes($this->input->post('txt_role')));
                                $toUpdate   = array(
                                    'fonction_equipe'   => $teammateRole,
                                );
                                $where      = array(
                                    'id_equipe'         => $tid,
                                );
                                if ($this->equipe->update($where, $toUpdate)) {
                                    $uTeammateRole  = $teammateRole;
                                    $dataUpdated    = true;
                                }
                            } else {
                                $uTeammateRole      = $teammate[0]->fonction_equipe;
                            }
                       
                            $txt_role_en = strtolower($this->input->post('txt_role_en'));
                            if (!empty($txt_role_en) AND trim($txt_role_en) != trim($teammate[0]->fonction_equipe_en)) {
                                $teammateRoleE  = trim(addslashes($this->input->post('txt_role_en')));
                                $toUpdate   = array(
                                    'fonction_equipe_en'    => $teammateRoleE,
                                );
                                $where      = array(
                                    'id_equipe'             => $tid,
                                );
                                if ($this->equipe->update($where, $toUpdate)) {
                                    $uTeammateRoleE = $teammateRoleE;
                                    $dataUpdated    = true;
                                }
                            } else {
                                $uTeammateRoleE     = $teammate[0]->fonction_equipe_en;
                            }                        
                            if (!empty($_FILES['picture']['name'])) {
                                if (!is_dir('./upload')) {
                                    mkdir('./upload', 0777, true);
                                }
                                $config['upload_path']          = './upload/';
                                $config['allowed_types']        = 'gif|jpg|png';
                                $config['file_name']            = str_replace(' ', '_', trim($_FILES['picture']['name']));
                                $config['max_size']             = 2048;
                                $config['max_width']            = 1024;
                                $config['max_height']           = 1024;
                                $this->load->library('upload', $config);
                                if (!$this->upload->do_upload('picture')) {
                                    $error = array('error' => $this->upload->display_errors('', ''));
                                    $retour = array('type' => 'warning', 'message' => $error['error']);
                                    $this->session->set_flashdata('retour', $retour);
                                    redirect('admin/group/team', 'refresh');

                                } else {
                                    $data = $this->upload->data('file_name');
                                    $toUpdate   = array(
                                        'fichier_equipe'    => $data,
                                    );
                                    $where      = array(
                                        'id_equipe'         => $tid,
                                    );
                                    if ($this->equipe->update($where, $toUpdate)) {
                                        $uPicture   = $data;
                                        $dataUpdated    = true;
                                    }
                                }
                            } else {
                                $uTeammatePicture   = $teammate[0]->fichier_equipe;
                            }
                        if ($dataUpdated == true) {
                            $retour = array('type' => 'success', 'message' => 'Les informations du membre ont &eacute;t&eacute; correctement d&eacute;finies!');
                        } else {
                            $retour = array('type' => 'success', 'message' => 'Aucune nouvelle information n\'a été renseignée!');
                        } 
                    }                 
                } else {
                    $txt_lastName = trim($this->input->post('txt_lastName'));
                    $txt_firstName = trim($this->input->post('txt_firstName'));
                    $txt_role = $this->input->post('txt_role');
                    $txt_role_en = $this->input->post('txt_role_en');
                    if (!empty($txt_lastName) AND !empty($txt_firstName) AND !empty($txt_role)  AND !empty($_FILES['picture']['name'])) {
                        $lastName   = (!empty($txt_lastName)) ? mb_strtolower($this->input->post('txt_lastName')) : '';
                        $firstName  = (!empty($txt_firstName)) ? mb_strtolower($this->input->post('txt_firstName')) : '';
                        $role       = (!empty($txt_role)) ? $this->input->post('txt_role') : '';
                        $roleE      = (!empty($txt_role_en)) ? $this->input->post('txt_role_en') : '';
                        if (!empty($lastName) AND !empty($firstName) AND !empty($role) AND !empty($roleE)) {                          
                                if (!is_dir('./upload')) {
                                    mkdir('./upload', 0777, true);
                                }
                                $config['upload_path']          = './upload/';
                                $config['allowed_types']        = 'gif|jpg|png';
                                $config['file_name']            = str_replace(' ', '_', trim($_FILES['picture']['name']));
                                $config['max_size']             = 2048;
                                $config['max_width']            = 1024;
                                $config['max_height']           = 1024;
                                $this->load->library('upload', $config);
                            if ($this->upload->do_upload('picture')) {
                                $data = $this->upload->data('file_name');
                                    $toInsert       = array(
                                        'nom_equipe'            => $lastName,
                                        'prenom_equipe'         => $firstName,
                                        'fonction_equipe'       => $role,
                                        'fonction_equipe_en'    => $roleE,
                                        'fichier_equipe'        => $data,
                                        'createdBy'             => $this->session->userdata('user_id'),
                                        'statut_equipe'         => '1',
                                    );
                                    $inserted   = $this->equipe->create($toInsert);
                                    if ($inserted) {
                                            $insertedData   = $this->equipe->read('*', array('id_equipe' => $inserted));
                                            $data_log = '';
                                            foreach($insertedData[0] as $key => $value) {
                                                $data_log   .= $key."=>".$value."\n";
                                            }                   
                                            $toInsert   = array(
                                                'user_log'  => $this->session->userdata('user_id'),
                                                'table_log' => "equipe",
                                                'data_log'  => "insert|all|$inserted|0|$data_log",
                                            );

                                            // inserting log
                                            $this->log_file->create($toInsert);
                                        //-------------------

                                        // Return a success message (insertion done)
                                        $retour = array('type' => 'success', 'message' => 'Le membre a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s!');

                                    } else { // Return a warning message (an error occurs)
                                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible d\'enregistrer le membre');
                                    }
                                //-----------------------------

                            } else { // Return a warning message (upload error)
                                // Get the upload error
                                $error = array('error' => $this->upload->display_errors('', ''));

                                // warning, an error occur during upload
                                $retour = array('type' => 'warning', 'message' => $error['error']);
                            }

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        } // End if

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    } // End if
                    
                } // End if

                // Set the sendback message
                $this->session->set_flashdata('retour', $retour);

                // redirect the user to director informations
                redirect('admin/group/team');

            } else {
                // redirect the user to director informations
                redirect('admin/group/team');
            } // End if

        } // End function

        public function enableTeam () {

            // Process only if there is an id selected
            $e_tid    = $this->input->post('e_tid');
            if (!empty($e_tid)) { // process

                // Get the sent row's id
                $tid    = $this->input->post('e_tid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_equipe'        => $tid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_equipe'    => '1',
                    );

                    // Stock the update status for test
                    $enabled    = $this->equipe->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($enabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "equipe",
                            'data_log'  => "enable|statut_equipe|$tid|0|1",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Membre activ&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer le membre!');
                }

            } else { // redirect the user
                redirect('admin/group/team', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user to the data list
            redirect('admin/group/team', 'refresh');

        }

        public function enableSelectedTeams () {
                
            // Process only if there is an id selected
            $e_tids = $this->input->post('e_tids');
            if (!empty($e_tids)) { // process

                // Get the sent row's id
                $tids       = $this->input->post('e_tids');
                $allDone    = true;
                $done       = 0;

                foreach ($tids as $tid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 1, id == $tid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_equipe'        => $tid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_equipe'    => '1',
                            );

                            // Stock the update status for test
                            $enable = $this->equipe->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($enable) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "equipe",
                                    'data_log'  => "disable|statut_equipe|$tid|0|1",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($tids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; activ&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/team', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/team', 'refresh');
            
        }

        public function disableTeam () {

            // Process only if there is an id selected
            $d_tid = $this->input->post('d_tid');
            if (!empty($d_tid)) { // process

                // Get the sent row's id
                $tid    = $this->input->post('d_tid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_equipe'        => $tid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_equipe'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->equipe->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($disabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "equipe",
                            'data_log'  => "disable|statut_equipe|$tid|1|2",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Membre d&eacute;sactiv&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver le membre!');
                }

            } else { // redirect the user
                redirect('admin/group/team', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/team', 'refresh');

        }

        public function disableSelectedTeams () {
                
            // Process only if there is an id selected
            $d_tids = $this->input->post('d_tids');
            if (!empty($d_tids)) { // process

                // Get the sent row's id
                $tids       = $this->input->post('d_tids');
                $allDone    = true;
                $done       = 0;

                foreach ($tids as $tid) {
                    if ($allDone) {
                        //----------------------------------------------------------------------------
                        // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                        //----------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_equipe'        => $tid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_equipe'    => '0',
                            );

                            // Stock the update status for test
                            $disabled   = $this->equipe->update($where, $toUpdate);
                        //----------------------------------------------------------------------------

                        if ($disabled) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "equipe",
                                    'data_log'  => "disable|statut_equipe|$tid|1|2",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($tids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; d&eacute;sactiv&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/team', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/team', 'refresh');
            
        }

        public function deleteTeam () {

            // Process only if there is an id selected
            $rm_tid = $this->input->post('rm_tid');
            if (!empty($rm_tid)) { // process

                // Get the sent row's id
                $tid    = $this->input->post('rm_tid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $tid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_equipe'        => $tid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_equipe'    => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->equipe->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($deleted) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "equipe",
                            'data_log'  => "disable|statut_equipe|$tid|0,1,2|3",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Membre supprim&eacute; avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer le membre!');
                }

            } else { // redirect the user
                redirect('admin/group/team', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/team', 'refresh');

        }

        public function deleteSelectedTeams () {
                
            // Process only if there is an id selected
            $rm_tids = $this->input->post('rm_tids');
            if (!empty($rm_tids)) { // process

                // Get the sent row's id
                $tids       = $this->input->post('rm_tids');
                $allDone    = true;
                $done       = 0;

                foreach ($tids as $tid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // DELETE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_equipe'        => $tid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_equipe'    => '3',
                            );

                            // Stock the update status for test
                            $deleted    = $this->equipe->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($deleted) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "equipe",
                                    'data_log'  => "disable|statut_equipe|$tid|0,1,2|3",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($tids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/group/team', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/group/team', 'refresh');
            
        }


    public function network() {

        // set the title of the current page
        $this->data['page_description']         = 'R&eacute;seau';

        // set the active menu item
        $this->data['menu']['group']['network']    = 'active open';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';
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

        //--------------------------------------------
        // Get list of all team mates in the database
        //
        // READ DATA FROM equipe
        //--------------------------------------------

        // array of joins to store one or multiple join condition
        $joins      = array();

        // array of all the where condition using OR
        $orWhere    = array();

        // array of all the where condition using AND
        $where      = array(
            'reseau_social.statut_reseau_social !='   => '3',
        );

        // value of rows the query should return
        $limit      = 0;

        // array of all the order condition
        $order      = array();

        //selectionner les element
        $this->data['networks']    = $this->reseau->readReseauSocial("*", $where);
        //--------------------------------------------

        // include the view with all the data requested
        $this->layer->pages('admin/network', 'admin/include/menu', $this->data);

    }

    public function newNetwork () {
        $tid    = ((int)$this->input->get('tid') > 0) ? (int)$this->input->get('tid') : 0 ;
        $this->data['page_description']         = 'R&eacute;seau';
        $this->data['menu']['group']['network']    = 'active open';
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
        $this->data['network'] = '';
        if (!empty($tid)) { 
            $this->data['network'] = $this->reseau->read('*', array('id_reseau_social' => $tid));
        }
        $this->layer->pages('admin/new_network', 'admin/include/menu', $this->data);

    }

    public function addNetwork () {
        if (!empty($_POST)) {
            $tid    = ((int)$this->input->post('tid') > 0) ? $this->input->post('tid') : 0;
            if (!empty($tid)) { 
                $joins      = array();
                $orWhere    = array();
                $where      = array(
                    'reseau_social.id_reseau_social'          => $tid,
                    'reseau_social.statut_reseau_social !='   => '3',
                );
                $limit      = 1;
                $order      = array();
                $network   = $this->reseau->read("*", $where);
                if (!empty($network)) {
                    $dataUpdated    = false;
                    $txt_facebook = $this->input->post('txt_facebook');
                    if (!empty($txt_facebook) AND mb_strtolower(trim($txt_facebook)) != trim($network[0]->facekook)) {
                        $networkFacebook   = mb_strtolower(trim(addslashes($this->input->post('txt_facebook'))));
                        $toUpdate   = array(
                            'facebook'    => $networkFacebook,
                        );
                        $where      = array(
                            'id_reseau_social'     => $tid,
                        );
                        if ($this->reseau->update($where, $toUpdate)) {
                            $uNetworkFacebook  = $networkFacebook;
                            $dataUpdated    = true;
                        }
                    } else {
                        $uNetworkFacebook  = $network[0]->facebook;
                    }
                    $txt_linkedin = $this->input->post('txt_linkedin');
                    if (!empty($txt_linkedin) AND mb_strtolower(trim($txt_linkedin)) != $network[0]->linkedin) {
                        $networkLinkedin  = mb_strtolower(trim(addslashes($this->input->post('txt_linkedin'))));
                        $toUpdate   = array(
                            'linkedin' => $networkLinkedin,
                        );
                        $where      = array(
                            'id_reseau_social'     => $tid,
                        );
                        if ($this->reseau->update($where, $toUpdate)) {
                            $uNetworkLinkedin = $networkLinkedin;
                            $dataUpdated    = true;
                        }
                    } else {
                        $uNetworkLinkedin = $network[0]->linkedin;
                    }
                    $txt_sunu_sante = strtolower($this->input->post('txt_sunu_sante'));
                    if (!empty($txt_sunu_sante) AND trim($txt_sunu_sante) != trim($network[0]->sunu_sante)) {
                        $networkSunuSante   = trim(addslashes($this->input->post('txt_sunu_sante')));
                        $toUpdate   = array(
                            'sunu_sante'   => $networkSunuSante,
                        );
                        $where      = array(
                            'id_reseau_social'         => $tid,
                        );
                        if ($this->reseau->update($where, $toUpdate)) {
                            $uNetworkSunuSante  = $networkSunuSante;
                            $dataUpdated    = true;
                        }
                    } else {
                        $uNetworkSunuSante      = $network[0]->sunu_sante;
                    }
                    if ($dataUpdated == true) {
                        $retour = array('type' => 'success', 'message' => 'Les liens ont &eacute;t&eacute; correctement d&eacute;finies!');
                    } else {
                        $retour = array('type' => 'success', 'message' => 'Aucune nouvelle information n\'a été renseignée!');
                    } 
                } // End if
            } else { 
                $txt_facebook = trim($this->input->post('txt_facebook'));
                $txt_linkedin = trim($this->input->post('txt_linkedin'));
                $txt_sunu_sante = trim($this->input->post('txt_sunu_sante'));

                if (!empty($txt_facebook) AND !empty($txt_linkedin) AND !empty($txt_sunu_sante) ) {
                    $txt_facebook   = (!empty($txt_facebook)) ? mb_strtolower($this->input->post('txt_facebook')) : '';
                    $txt_linkedin  = (!empty($txt_linkedin)) ? mb_strtolower($this->input->post('txt_linkedin')) : '';
                    $txt_sunu_sante  = (!empty($txt_sunu_sante)) ? mb_strtolower($this->input->post('txt_sunu_sante')) : '';
                    if (!empty($txt_facebook) AND !empty($txt_linkedin) AND !empty($txt_sunu_sante) ) {
                        $toInsert       = array(
                            'facebook'            => $txt_facebook,
                            'linkedin'         => $txt_linkedin,
                            'sunu_sante'       => $txt_sunu_sante,
                            'createdBy'             => $this->session->userdata('user_id'),
                            'statut_reseau_social'         => '1',
                        );
                        $inserted   = $this->reseau->create($toInsert);
                        if ($inserted) {
                            $insertedData   = $this->reseau->read('*', array('id_reseau_social' => $inserted));
                            $data_log = '';
                            foreach($insertedData[0] as $key => $value) {
                                $data_log   .= $key."=>".$value."\n";
                            }
                            $toInsert   = array(
                                'user_log'  => $this->session->userdata('user_id'),
                                'table_log' => "reseau_social",
                                'data_log'  => "insert|all|$inserted|0|$data_log",
                            );
                            $this->log_file->create($toInsert);
                            $retour = array('type' => 'success', 'message' => 'Les liens ont &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s!');
                        } else { 
                            $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible d\'enregistrer les liens');
                        }
                    } else {
                        $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                    } // End if

                } else { 
                    $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                } // End if

            } 
            $this->session->set_flashdata('retour', $retour);
            redirect('admin/group/network');
        } else {
            redirect('admin/group/network');
        } // End if

    } // End function

    public function deleteNetwork () {

        // Process only if there is an id selected
        $rm_tid = $this->input->post('rm_tid');
        if (!empty($rm_tid)) { // process

            // Get the sent row's id
            $tid    = $this->input->post('rm_tid');

            //------------------------------------------------------------------------------
            // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $tid)
            //------------------------------------------------------------------------------
            // Where clause for the update
            $where      = array(
                'id_reseau_social'        => $tid,
                'is_active !='        => "1",
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_reseau_social'    => '3',
            );

            // Stock the update status for test
            $deleted    = $this->reseau->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($deleted) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "reseau_social",
                    'data_log'  => "disable|statut_reseau_social|$tid|0,1,2|3",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'Liens supprim&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer les liens!');
            }

        } else { // redirect the user
            redirect('admin/group/network', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/group/network', 'refresh');

    }

    public function enableNetwork () {

        // Process only if there is an id selected
        $e_tid    = $this->input->post('e_tid');

        if (!empty($e_tid)) { // process

            // Get the sent row's id
            $tid    = $this->input->post('e_tid');

            //------------------------------------------------------------------------------
            // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $tid)
            //------------------------------------------------------------------------------
            // Where clause for the update
            $where      = array(
                'id_reseau_social'        => $tid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_reseau_social'    => '1',
                'is_active'    => '1',
            );
            //tout desactive
            $this->reseau->update(array(), array('is_active' => '0'));

            // reactiver la selection
            $enabled    = $this->reseau->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($enabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "reseau_social",
                    'data_log'  => "enable|statut_reseau_social|$tid|0|1",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'Membre activ&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer le membre!');
            }

        } else { // redirect the user
            redirect('admin/group/network', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user to the data list
        redirect('admin/group/network', 'refresh');

    }
    //--------------------

}
?>