<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller{
    
    public function __construct(){
        
        parent::__construct();
        
        $this->load->model('post_table', 'publication'); // load the post_table model as 'publication'
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'
        
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
            $this->data['page_title']       = 'Publications';
            $this->data['page_description'] = 'gestion des publications';

            // get the class menu property
            $this->data['menu']             = $this->fonctions->menu;

            // set the active menu item
            $this->data['menu']['post']['post'] = 'active open';
        
        //-----------------------------------------------
        
    }
    
    //----------------------------------------------
    // THE INDEX FUNCTION THAT WILL BE CALLED FIRST
    //----------------------------------------------
        public function index() {
            
            // call to the post method
            $this->post();
            
        }
    //----------------------------------------------
    
    //-------------------------------
    // DISPLAY ALL THE POST INSERTED
    //-------------------------------
        public function post() {

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
                    
                    'js/plugins/uploaders/fileinput.min.js',
                    'js/pages/uploader_bootstrap.js',
                    
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
                    
                    'css/icons/icomoon/styles.css',
                    'css/bootstrap.css',
                    'css/core.css',
                    'css/components.css',
                    
                    'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                );

            //------------------------------------------------------

            //---------------------------------------
            // get list of all posts in the database
            //
            // READ DATA FROM publication
            //---------------------------------------

                // array of joins to store one or multiple join condition
                $joins      = array();

                // array of all the where condition using OR
                $orWhere    = array();

                // array of all the where condition using AND
                $where      = array(
                    'publication.statut_publication !='     => '3',
                );

                // value of rows the query should return
                $limit      = 0;

                // array of all the order condition
                $order      = array(
                    'publication.dateCreated_publication'   => 'DESC',
                );

                // execute the query and return all the required rows
                $this->data['publications'] = $this->publication->readJoins('publication.id_publication, publication.titre_publication, publication.texte_publication, publication.fichier_publication, publication.dateCreated_publication, publication.statut_publication', $joins, $orWhere, $where, $limit, $order);
                $this->data['menu']['filiale']['filiale']    = '';
                $this->data['menu']['contact']['contact']    = '';
                $this->data['menu']['group']['network']    = '';
                $this->data['menu']['group']['director']    = '';
                $this->data['menu']['group']['text']    = '';
                $this->data['menu']['image']['image']    = '';
                $this->data['menu']['image']['slider']    = '';
                $this->data['menu']['pays']['pays']    = '';
                $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

            //---------------------------------------

            // include the view with all the data requested
            $this->layer->pages('admin/post', 'admin/include/menu', $this->data);

        }
    //-------------------------------
    
    //-------------------------------------
    // DISPLAY AN EMPTY FORM TO ADD A POST
    //-------------------------------------
        public function newPost () {
                        
            // Get the post's id
            $pid    = ((int)$this->input->get('pid') > 0) ? (int)$this->input->get('pid') : 0 ;

            // set the active menu item
            $this->data['menu']['post']['post']   = 'active open';

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
            
            $this->data['publication']  = '';

            // If the post's id is not empty
            if (!empty($pid)) { // post's data for update form

                //-------------------------------
                // GET ALL THE POST INFORMATIONS
                //-------------------------------
                    // Execute the query and return all the required rows
                    $this->data['publication']  = $this->publication->read('*', array('id_publication' => $pid));
                //-------------------------------

            }
            // end if

            // include the view with all the data requested
            $this->layer->pages('admin/new_post', 'admin/include/menu', $this->data);
            
        }
    //-------------------------------------
    
    //------------------------------------------
    // ADD (id == 0) OR UPDATE (id != 0) A POST
    //------------------------------------------
        public function addPost () {

            // Check if there are posted data and then process
            if (!empty($_POST)) {

                // Check if we have to insert or update data, the id is defined and not null
                $pid = $this->input->post('pid');
                if (empty($pid)) { // insert data

                    // Check if all the required data have been posted
                    $txt_title = $this->input->post('txt_title');
                    $txt_text = $this->input->post('txt_text');
                    $txt_title_en = $this->input->post('txt_title_en');
                    $txt_text_en = $this->input->post('txt_text_en');
                    if (!empty($txt_title) AND !empty($txt_title_en) AND !empty($txt_text) AND !empty($txt_text_en) AND !empty($_FILES['import-file']['name'])) {

                        // Get all the form data
                        $title  = (!empty($txt_title)) ? $this->input->post('txt_title') : '';
                        $titleE = (!empty($txt_title_en)) ? $this->input->post('txt_title_en') : '';
                        $text   = (!empty($txt_text)) ? $this->input->post('txt_text') : '';
                        $textE  = (!empty($txt_text_en)) ? $this->input->post('txt_text_en') : '';

                        if (!empty($title) AND !empty($titleE) AND !empty($text) AND !empty($textE)) {
                            $dt_date = $this->input->post('dt_date');
                            $date   = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                            $date   = DateTime::createFromFormat('d-m-Y', $date);
                            $date   = $date->format('Y-m-d H:i:s');
                            
                            //-------------------------
                            // PROCESS THE FILE UPLOAD
                            //-------------------------
                                
                                // create the file upload folder if not exists
                                if (!is_dir('./upload/post')) {

                                    mkdir('./upload/post', 0777, true);

                                }

                                // setting upload preferences
                                $config['upload_path']          = './upload/post/';
                                $config['allowed_types']        = 'pdf'; //'';
                                // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                                // $config['max_size']             = 40960;
                                // $config['max_width']            = 1024;
                                // $config['max_height']           = 1024;

                                // initializing the upload class
                                $this->load->library('upload', $config);
                            
                            //-------------------------

                            if ($this->upload->do_upload('import-file')) {
                                
                                // Get uploaded file name
                                $data   = $this->upload->data('file_name');
                                
                                // Get the english file upload name
                                $dataE  = (!empty($_FILES['import-file2']['name']) AND $this->upload->do_upload('import-file2')) ? $this->upload->data('file_name') : '';

                                //-------------------------
                                // PROCESS POST'S CREATION
                                //-------------------------

                                    // setting up data to insert
                                    $toInsert       = array(
                                        'titre_publication'         => $title,
                                        'titre_publication_en'      => $titleE,
                                        'texte_publication'         => $text,
                                        'texte_publication_en'      => $textE,
                                        'fichier_publication'       => $data,
                                        'fichier_publication_en'    => $dataE,
                                        'dateCreated_publication'   => $date,
                                        'createdBy'                 => $this->session->userdata('user_id'),
                                        'statut_publication'        => '1',
                                    );

                                    // Stock the insertion id for verification
                                    $inserted   = $this->publication->create($toInsert);

                                    // inserting data
                                    if ($inserted) {

                                        //----------------------------
                                        // Get the data just inserted
                                        //
                                        // READ DATA FROM publication
                                        //----------------------------
                                            // execute the query and return all the required rows
                                            $insertedData   = $this->publication->read('*', array('id_publication' => $inserted));

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
                                                'table_log' => "publication",
                                                'data_log'  => "insert|all|$inserted|0|$data_log",
                                            );

                                            // inserting log
                                            $this->log_file->create($toInsert);
                                        //-------------------

                                        // Return a success message (insertion done)
                                        $retour = array('type' => 'success', 'message' => 'La publication a &eacute;t&eacute; cr&eacute;&eacute;e avec succ&egrave;s!');

                                    } else { // Return a warning message (the data already exists)
                                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de la publication');
                                    }
                                //------------------------

                            } else { // Return a warning message (the data already exists)
                                // get the error
                                $error = array('error' => $this->upload->display_errors('', ''));

                                // warning, an error occur during upload
                                $retour = array('type' => 'warning', 'message' => $error['error']);
                            }

                        } else { // Return a danger message (data are not correct)
                            $retour = array('type' => 'danger', 'message' => 'Entrez des valeurs correctes!');
                        }

                    } else { // Return an info message (you must fill in all the required fields)
                        $retour = array('type' => 'info', 'message' => 'Tous les champs obligatoires du fomulaire doivent &ecirc;tres renseign&eacute;s!');
                    }

                } else { // update data

                    // Check if all the required data have been posted
                    $txt_title = $this->input->post('txt_title');
                    $txt_text = $this->input->post('txt_text');
                    $txt_title_en = $this->input->post('txt_title_en');
                    $txt_text_en = $this->input->post('txt_text_en');
                    if (!empty($txt_title) AND !empty($txt_title_en) AND !empty($txt_text) AND !empty($txt_text_en)) {

                        // Get all the form data
                        $pid    = ((int)$this->input->post('pid') > 0) ? (int)$this->input->post('pid') : 0;

                        // Get all the form data
                        $title  = (!empty($txt_title)) ? $this->input->post('txt_title') : '';
                        $titleE = (!empty($txt_title_en)) ? $this->input->post('txt_title_en') : '';
                        $text   = (!empty($txt_text)) ? $this->input->post('txt_text') : '';
                        $textE  = (!empty($txt_text_en)) ? $this->input->post('txt_text_en') : '';

                        if (!empty($pid) AND !empty($title) AND !empty($titleE) AND !empty($text) AND !empty($textE)) {
                            
                            $dt_date = $this->input->post('dt_date');
                            $date   = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                            $date   = DateTime::createFromFormat('d-m-Y', $date);
                            $date   = $date->format('Y-m-d H:i:s');
                            
                            // Check if we have to update the file
                            if (!empty($_FILES['import-file']['name'])) {
                            
                                //-------------------------
                                // PROCESS THE FILE UPLOAD
                                //-------------------------

                                    // create the file upload folder if not exists
                                    if (!is_dir('./upload/post')) {

                                        mkdir('./upload/post', 0777, true);

                                    }

                                    // setting upload preferences
                                    $config['upload_path']          = './upload/post/';
                                    $config['allowed_types']        = 'pdf';
                                    // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                                    // $config['max_size']             = 0;
                                    // $config['max_width']            = 1024;
                                    // $config['max_height']           = 1024;

                                    // initializing the upload class
                                    $this->load->library('upload', $config);

                                //-------------------------

                                //var_dump($this->upload->do_upload('import-file')); die();
                                if ($this->upload->do_upload('import-file')) { // upload file

                                    // Get uploaded file name
                                    $data = $this->upload->data('file_name');
                                
                                    // Get the english file upload name
                                    $dataE  = (!empty($_FILES['import-file2']['name']) AND $this->upload->do_upload('import-file2')) ? $this->upload->data('file_name') : '';

                                    //-------------------------------
                                    // Get the row we have to update
                                    //
                                    // READ DATA FROM publication
                                    //-------------------------------
                                        // execute the query and return all the required rows
                                        $toUpdateData   = $this->publication->read('*', array('id_publication' => $pid));

                                        $oData_log  = '';

                                        foreach($toUpdateData[0] as $key => $value) {
                                            $oData_log  .= $key."=>".$value."\n";
                                        }
                                    //-------------------------------

                                    //-----------------------
                                    // PROCESS POST'S UPDATE
                                    //-----------------------

                                        // setting up data to update
                                        $toUpdate   = array(
                                            'titre_publication'         => $title,
                                            'titre_publication_en'      => $titleE,
                                            'texte_publication'         => $text,
                                            'texte_publication_en'      => $textE,
                                            'fichier_publication'       => $data,
                                            'fichier_publication_en'    => $dataE,
                                            'dateCreated_publication'   => $date,
                                        );

                                        // setting up where clause
                                        $where      = array(
                                            'id_publication'            => $pid,
                                        );

                                        // Stock the update status for test
                                        $updated    = $this->publication->update($where, $toUpdate);

                                        // updating data
                                        if ($updated) {

                                            //----------------------------
                                            // Get the row just updated
                                            //
                                            // READ DATA FROM publication
                                            //----------------------------
                                                // execute the query and return all the required rows
                                                $updatedData    = $this->publication->read('*', array('id_publication' => $pid));

                                                $data_log = '';

                                                foreach($updatedData[0] as $key => $value) {
                                                    $data_log   .= $key."=>".$value."\n";
                                                }
                                            //----------------------------

                                            //-------------------
                                            // UPDATE LOG'S DATA
                                            //-------------------
                                                // setting up data to insert
                                                $toInsert   = array(
                                                    'user_log'  => $this->session->userdata('user_id'),
                                                    'table_log' => "publication",
                                                    'data_log'  => "update|all|$pid|$oData_log|$data_log",
                                                );

                                                // inserting log
                                                $this->log_file->create($toInsert);
                                            //-------------------

                                            // Return a success message (update done)
                                            $retour = array('type' => 'success', 'message' => 'La publication a &eacute;t&eacute; modifi&eacute;e avec succ&egrave;s!');

                                        } else { // Return a warning message (can't update data)
                                            $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour la publication');
                                        }
                                    //-----------------------

                                } else { // Return a warning message (the data already exists)
                                    // get the error
                                    $error = array('error' => $this->upload->display_errors('', ''));

                                    // warning, an error occur during upload
                                    $retour = array('type' => 'warning', 'message' => $error['error']);
                                }
                            
                            } else {

                                //-------------------------------
                                // Get the row we have to update
                                //
                                // READ DATA FROM publication
                                //-------------------------------
                                    // execute the query and return all the required rows
                                    $toUpdateData   = $this->publication->read('*', array('id_publication' => $pid));

                                    $oData_log  = '';

                                    foreach($toUpdateData[0] as $key => $value) {
                                        $oData_log  .= $key."=>".$value."\n";
                                    }
                                //-------------------------------

                                // setting upload preferences
                                $config['upload_path']          = './upload/post/';
                                $config['allowed_types']        = 'pdf';
                                // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                                // $config['max_size']             = 40960;
                                // $config['max_width']            = 1024;
                                // $config['max_height']           = 1024;

                                // initializing the upload class
                                $this->load->library('upload', $config);
                                
                                // Get the english file upload name
                                $dataE  = (!empty($_FILES['import-file2']['name']) AND $this->upload->do_upload('import-file2')) ? $this->upload->data('file_name') : '';

                                //-----------------------
                                // PROCESS POST'S UPDATE
                                //-----------------------

                                    // setting up data to update
                                    $toUpdate   = array(
                                        'titre_publication'         => $title,
                                        'titre_publication_en'      => $titleE,
                                        'texte_publication'         => $text,
                                        'texte_publication_en'      => $textE,
                                        'fichier_publication_en'    => $dataE,
                                        'dateCreated_publication'   => $date,
                                    );

                                    // setting up where clause
                                    $where      = array(
                                        'id_publication'            => $pid,
                                    );

                                    // Stock the update status for test
                                    $updated    = $this->publication->update($where, $toUpdate);

                                    // updating data
                                    if ($updated) {

                                        //----------------------------
                                        // Get the row just updated
                                        //
                                        // READ DATA FROM publication
                                        //----------------------------
                                            // execute the query and return all the required rows
                                            $updatedData    = $this->publication->read('*', array('id_publication' => $pid));

                                            $data_log = '';

                                            foreach($updatedData[0] as $key => $value) {
                                                $data_log   .= $key."=>".$value."\n";
                                            }
                                        //----------------------------

                                        //-------------------
                                        // UPDATE LOG'S DATA
                                        //-------------------
                                            // setting up data to insert
                                            $toInsert   = array(
                                                'user_log'  => $this->session->userdata('user_id'),
                                                'table_log' => "publication",
                                                'data_log'  => "update|all|$pid|$oData_log|$data_log",
                                            );

                                            // inserting log
                                            $this->log_file->create($toInsert);
                                        //-------------------

                                        // Return a success message (update done)
                                        $retour = array('type' => 'success', 'message' => 'La publication a &eacute;t&eacute; modifi&eacute;e avec succ&egrave;s!');

                                    } else { // Return a warning message (can't update data)
                                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour la publication');
                                    }
                                //---------------------------
                                
                            }

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
            redirect('admin/post', 'refresh');
            
        }
    //------------------------------------------
    
    //---------------
    // ENABLE A POST
    //---------------
        public function enablePost () {

            // Process only if there is an id selected
            $e_pid = $this->input->post('e_pid');
            if (!empty($e_pid)) { // process

                // Get the sent row's id
                $pid    = $this->input->post('e_pid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $pid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_publication'        => $pid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_publication'    => '1',
                    );

                    // Stock the update status for test
                    $enabled    = $this->publication->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($enabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "publication",
                            'data_log'  => "enable|statut_publication|$pid|0|1",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Publication activ&eacute;e avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer la publication!');
                }

            } else { // redirect the user
                redirect('admin/post', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user to the data list
            redirect('admin/post', 'refresh');

        }
    //---------------
    
    //---------------------------
    // ENABLE ALL SELECTED POSTS
    //---------------------------
        public function enableSelectedPosts () {
                
            // Process only if there is an id selected
            $e_pids = $this->input->post('e_pids');
            if (!empty($e_pids)) { // process

                // Get the sent row's id
                $pids       = $this->input->post('e_pids');
                $allDone    = true;
                $done       = 0;

                foreach ($pids as $pid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 1, id == $pid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_publication'        => $pid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_publication'    => '1',
                            );

                            // Stock the update status for test
                            $enable = $this->publication->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($enable) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "publication",
                                    'data_log'  => "disable|statut_publication|$pid|0|1",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($pids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; activ&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/post', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/post', 'refresh');
            
        }
    //---------------------------
    
    //----------------
    // DISABLE A POST
    //----------------
        public function disablePost () {

            // Process only if there is an id selected
            $d_pid = $this->input->post('d_pid');
            if (!empty($d_pid)) { // process

                // Get the sent row's id
                $pid    = $this->input->post('d_pid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $pid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_publication'        => $pid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_publication'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->publication->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($disabled) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "publication",
                            'data_log'  => "disable|statut_publication|$pid|1|2",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Publication d&eacute;sactiv&eacute;e avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver la publication!');
                }

            } else { // redirect the user
                redirect('admin/post', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/post', 'refresh');

        }
    //----------------
    
    //----------------------------
    // DISABLE ALL SELECTED POSTS
    //----------------------------
        public function disableSelectedPosts () {
                
            // Process only if there is an id selected
            $d_pids = $this->input->post('d_pids');
            if (!empty($d_pids)) { // process

                // Get the sent row's id
                $pids       = $this->input->post('d_pids');
                $allDone    = true;
                $done       = 0;

                foreach ($pids as $pid) {
                    if ($allDone) {
                        //----------------------------------------------------------------------------
                        // DISABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $pid)
                        //----------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_publication'        => $pid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_publication'    => '0',
                            );

                            // Stock the update status for test
                            $disabled   = $this->publication->update($where, $toUpdate);
                        //----------------------------------------------------------------------------

                        if ($disabled) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "publication",
                                    'data_log'  => "disable|statut_publication|$pid|1|2",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($pids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; d&eacute;sactiv&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/post', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/post', 'refresh');
            
        }
    //----------------------------
    
    //---------------
    // DELETE A POST
    //---------------
        public function deletePost () {

            // Process only if there is an id selected
            $rm_pid = $this->input->post('rm_pid');
            if (!empty($rm_pid)) { // process

                // Get the sent row's id
                $pid    = $this->input->post('rm_pid');

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $pid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_publication'        => $pid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_publication'    => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->publication->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($deleted) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "publication",
                            'data_log'  => "disable|statut_publication|$pid|0,1,2|3",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'Publication supprim&eacute;e avec succ&egrave;s!');

                } else { // warning, can't update row's status
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer la publication!');
                }

            } else { // redirect the user
                redirect('admin/post', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/post', 'refresh');

        }
    //---------------
    
    //---------------------------
    // DELETE ALL SELECTED POSTS
    //---------------------------
        public function deleteSelectedPosts () {
                
            // Process only if there is an id selected
            $rm_pids = $this->input->post('rm_pids');
            if (!empty($rm_pids)) { // process

                // Get the sent row's id
                $pids       = $this->input->post('rm_pids');
                $allDone    = true;
                $done       = 0;

                foreach ($pids as $pid) {
                    if ($allDone) {
                        //---------------------------------------------------------------------------
                        // DELETE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 0, id == $pid)
                        //---------------------------------------------------------------------------
                            // Where clause for the update
                            $where      = array(
                                'id_publication'        => $pid,
                            );

                            // Set fields to be update
                            $toUpdate   = array(
                                'statut_publication'    => '3',
                            );

                            // Stock the update status for test
                            $deleted    = $this->publication->update($where, $toUpdate);
                        //---------------------------------------------------------------------------

                        if ($deleted) { // success, row's status updated

                            $done++;

                            //-------------------
                            // UPDATE LOG'S DATA
                            //-------------------
                                // setting up data to insert
                                $toInsert   = array(
                                    'user_log'  => $this->session->userdata('user_id'),
                                    'table_log' => "publication",
                                    'data_log'  => "disable|statut_publication|$pid|0,1,2|3",
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
                        $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, '.$done.'/'.count($pids).' donn&eacute;e(s) trait&eacute;e(s)!');
                        break;
                    }

                }

                if ($allDone) {
                    // set the sendback, 'message' and 'type'
                    $retour = array('type' => 'success', 'message' => 'La s&eacute;lection a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!');
                }

            } else { // redirect the user
                redirect('admin/post', 'refresh');
            }

            // Set the sendback message
            $this->session->set_flashdata('retour', $retour);

            // Redirect the user the data list
            redirect('admin/post', 'refresh');
            
        }
    //---------------------------
    
}
?>