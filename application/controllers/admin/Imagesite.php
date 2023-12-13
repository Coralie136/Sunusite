<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagesite extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model('imageautrepage_table', 'image'); // load the pays_table model as 'image'
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
        $this->data['page_title']       = 'image';
        $this->data['page_description'] = 'gestion des images';

        // get the class menu property
        $this->data['menu']             = $this->fonctions->menu;

        // set the active menu item
        $this->data['menu']['image']['image']   = 'active open';

        //-----------------------------------------------

        // get all chars arrays
        $this->data['signed_letters']   = unserialize(SIGNED_LETTERS);
        $this->data['signs']            = unserialize(SIGNS);
    }

    //----------------------------------------------
    // THE INDEX FUNCTION THAT WILL BE CALLED FIRST
    //----------------------------------------------
    public function index() {

        // call to the image method
        $this->imageautrepage();

    }
    //----------------------------------------------

    //-----------------------------------
    // DISPLAY ALL THE paysS INSERTED
    //-----------------------------------
    public function imageautrepage() {

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
        // READ DATA FROM image
        //------------------------------------------

        // array of joins to store one or multiple join condition
        $joins      = array();

        // array of all the where condition using OR
        $orWhere    = array();

        // array of all the where condition using AND
        $where      = array(
            'image_site.statut_image_site !='     => '3',
            'image_site.famille_image !='     => 'slider',
        );

        // value of rows the query should return
        $limit      = 0;

        // array of all the order condition
        $order      = array(
            'image_site.dateCreated_image_site'   => 'DESC',
        );

        // execute the query and return all the required rows
        //var_dump($this->image->read('*', $joins, $orWhere, $where, $limit, $order)); die();
        $this->data['imagesites'] = $this->image->read('*', $where, $order);        
        $this->data['menu']['image']['image']    = 'active open';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';


        //----------------------------------------------------
    //var_dump("ok"); die();
        // include the view with all the data requested
        $this->layer->pages('admin/imagesite', 'admin/include/menu', $this->data);

    }
    //-----------------------------------

    //-----------------------------------------
    // DISPLAY AN EMPTY FORM TO ADD AN image
    //-----------------------------------------
    public function newImage () {

        // Get the image's id
        $aid    = ((int)$this->input->get('aid') > 0) ? (int)$this->input->get('aid') : 0 ;

        // set the title of the current page
//            $this->data['page_description']             = 'Ajouter un image';

        // set the active menu item
        

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

        $this->data['images']  = '';

        // If the image's id is not empty
        if (!empty($aid)) { // image's data for update form

            // set the title of the current page
//                $this->data['page_description'] = 'Modifier l\'image';

            //----------------------------------
            // GET ALL THE image INFORMATIONS
            //----------------------------------
            // Execute the query and return all the required rows
            $this->data['images']      = $this->image->read('*', array('id_image_site' => $aid));
            //----------------------------------

        }
        // end if
        $this->data['menu']['image']['image']   = 'active open';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';
        // include the view with all the data requested
        $this->layer->pages('admin/new_image', 'admin/include/menu', $this->data);

    }
    //-----------------------------------------

    //----------------------------------------------
    // ADD (id == 0) OR UPDATE (id != 0) AN image
    //----------------------------------------------
    public function addImages () {

   

        // Check if there are posted data and then process
        if (!empty($_POST)) {

            // var_dump($_POST);
            // die();
            // var_dump($_FILES['import-file']['name']); exit;
            // Check if we have to insert or update data, the id is defined and not null
            $aid = $this->input->post('aid');
            if (empty($aid)) { // insert data

                // Check if all the required data have been posted
                $txt_fammille_image = $this->input->post('fammille_image');
                $files = $_FILES['import-file']['name'];
                if (!empty($txt_fammille_image) AND !empty($files)) {

                    // Get all the form data
                    $fammille_image  = (!empty($txt_fammille_image)) ? $this->input->post('fammille_image') : '';

                    // var_dump(2147483648 + mt_rand( -2147482448, 2147483647 )); exit;
                    if (!empty($fammille_image) ) {

                        $dt_date = $this->input->post('dt_date');
                        $date   = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                        $date   = DateTime::createFromFormat('d-m-Y', $date);
                        $date   = $date->format('Y-m-d H:i:s');

                        //-------------------------
                        // PROCESS THE FILE UPLOAD
                        //-------------------------

                        // create the file upload folder if not exists
                        if (!is_dir('./upload/image_site')) {

                            mkdir('./upload/image_site', 0777, true);

                        }

                        // setting upload preferences
                        $config['upload_path']          = './upload/image_site/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();

                        //definition de la taille exigé.
                        /*
                                             $config['max_size']             = 2048;
                                             $config['max_width']            = 1024;
                                             $config['max_height']           = 1024;
                        */
                        $config['max_height']           = 510;
                        // initializing the upload class
                        $this->load->library('upload', $config);

                        //-------------------------
                        //var_dump("avant upload"); die();
                        if ($this->upload->do_upload('import-file')) {

                            // Get uploaded file name
                            $data   = $this->upload->data('file_name');


                            //--------------------------
                            // PROCESS chiffre_cle'S CREATION
                            //--------------------------

                            // setting up data to insert
                            //var_dump($fammille_image); die();
                            $toInsert       = array(
                                'fichier_image'         => $data,
                                'famille_image'       => $fammille_image,
                                'dateCreated_image'   => $date,
                                'createdBy'             => $this->session->userdata('user_id'),
                                'statut_image_site'        => '0',
                            );

                            // Stock the insertion id for verification
                            $inserted   = $this->image->create($toInsert);
                            //var_dump($inserted); die();
                            // inserting data
                            if ($inserted) {

                                //----------------------------
                                // Get the data just inserted
                                //
                                // READ DATA FROM chiffre_cle
                                //----------------------------
                                // execute the query and return all the required rows
                                $insertedData   = $this->image->read('*', array('id_image_site' => $inserted));

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
                                    'table_log' => "image_site",
                                    'data_log'  => "insert|all|$inserted|0|$data_log",
                                );

                                // inserting log
                                $this->log_file->create($toInsert);
                                //-------------------

                                // Return a success message (insertion done)
                                $retour = array('type' => 'success', 'message' => 'Le fichier a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s!');

                            } else { // Return a warning message (the data already exists)
                                $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de cr&eacute;er de l\'chiffre_cle');
                            }
                            //-------------------------

                        } else { // Return a warning message (the data already exists)
                        // $retour = array('type' => 'warning', 'message' => '<strong>Erreur</strong>, impossible d\'enregistrer le fichier image associ&eacute;!');
                            //var_dump("erreur"); die();
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

            }
            else { // update data

                // Check if all the required data have been posted
                $txt_fammille_image = $this->input->post('fammille_image');
                if (!empty($txt_fammille_image)) {

                    // Get all the form data
                    $aid    = ((int)$this->input->post('aid') > 0) ? (int)$this->input->post('aid') : 0;

                    // Get all the form data
                    $fammille_image  = (!empty($txt_fammille_image)) ? $this->input->post('fammille_image') : '';

                    if (!empty($aid) AND !empty($fammille_image) ) {

                        $dt_date = $this->input->post('dt_date');
                        $date   = (!empty($dt_date)) ? $this->input->post('dt_date') : date('d-m-Y');
                        $date   = DateTime::createFromFormat('d-m-Y', $date);
                        $date   = $date->format('Y-m-d H:i:s');

                        // Check if we have to update the file
                        $files = $_FILES['import-file']['name'];
                        if (!empty($files)) {

                            //-------------------------
                            // PROCESS THE FILE UPLOAD
                            //-------------------------

                            // create the file upload folder if not exists
                            if (!is_dir('./upload/image_site')) {

                                mkdir('./upload/image_site', 0777, true);

                            }

                            // setting upload preferences
                            $config['upload_path']          = './upload/image_site/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            // $config['file_name']            = 2147483648 + mt_rand( -2147482448, 2147483647 ).time();
                            /*$config['max_size']             = 2048;
                            $config['max_width']            = 1024;
                            $config['max_height']           = 1024;*/
                            $config['max_height']           = 510;

                            // initializing the upload class
                            $this->load->library('upload', $config);

                            //-------------------------

                            if ($this->upload->do_upload('import-file')) { // upload file

                                // get uploaded file name
                                $data = $this->upload->data('file_name');

                                //-------------------------------
                                // Get the row we have to update
                                //
                                // READ DATA FROM chiffre_cle
                                //-------------------------------
                                // execute the query and return all the required rows
                                $toUpdateData   = $this->image->read('*', array('id_image_site' => $aid));

                                $oData_log  = '';

                                foreach($toUpdateData[0] as $key => $value) {
                                    $oData_log  .= $key."=>".$value."\n";
                                }
                                //-------------------------------

                                //--------------------------
                                // PROCESS chiffre_cle'S UPDATE
                                //--------------------------

                                // setting up data to update
                                $toUpdate   = array(
                                    'famille_image'         => $fammille_image,
                                    'fichier_image'       => $data,
                                    'dateCreated_image'   => $date
                                );

                                // setting up where clause
                                $where      = array(
                                    'id_image_site'            => $aid,
                                );

                                // Stock the update status for test
                                $updated    = $this->image->update($where, $toUpdate);

                                // updating data
                                if ($updated) {

                                    //--------------------------
                                    // Get the row just updated
                                    //
                                    // READ DATA FROM chiffre_cle
                                    //--------------------------
                                    // execute the query and return all the required rows
                                    $updatedData    = $this->image->read('*', array('id_image_site' => $aid));

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
                                        'table_log' => "image_site",
                                        'data_log'  => "update|all|$aid|$oData_log|$data_log",
                                    );

                                    // inserting log
                                    $this->log_file->create($toInsert);
                                    //-------------------

                                    // Return a success message (update done)
                                    $retour = array('type' => 'success', 'message' => 'Le fichier a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');

                                } else { // Return a warning message (can't update data)
                                    $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour l\'chiffre_cle');
                                }
                                //---------------------------

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
                            // READ DATA FROM chiffre_cle
                            //-------------------------------
                            // execute the query and return all the required rows
                            $toUpdateData   = $this->image->read('*', array('id_image_site' => $aid));

                            $oData_log  = '';

                            foreach($toUpdateData[0] as $key => $value) {
                                $oData_log  .= $key."=>".$value."\n";
                            }
                            //-------------------------------

                            //--------------------------
                            // PROCESS chiffre_cle'S UPDATE
                            //--------------------------

                            // setting up data to update
                            $toUpdate   = array(
                                'famille_image'         => $fammille_image,
                                'dateCreated_image'   => $date
                            );

                            // setting up where clause
                            $where      = array(
                                'id_image_site'            => $aid,
                            );

                            // Stock the update status for test
                            $updated    = $this->image->update($where, $toUpdate);

                            // updating data
                            if ($updated) {

                                //--------------------------
                                // Get the row just updated
                                //
                                // READ DATA FROM chiffre_cle
                                //--------------------------
                                // execute the query and return all the required rows
                                $updatedData    = $this->image->read('*', array('id_image_site' => $aid));

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
                                    'table_log' => "image_site",
                                    'data_log'  => "update|all|$aid|$oData_log|$data_log",
                                );

                                // inserting log
                                $this->log_file->create($toInsert);
                                //-------------------

                                // Return a success message (update done)
                                $retour = array('type' => 'success', 'message' => 'Le fichier a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');

                            } else { // Return a warning message (can't update data)
                                $retour = array('type' => 'warning', 'message' => 'Une erreur est survenue, impossible de mettre &agrave; jour l\'chiffre_cle');
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
        redirect('admin/imagesite', 'refresh');

    }
    //----------------------------------------------

    //-------------------
    // ENABLE AN image
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
                'id_image_site'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_pays'    => '1',
            );

            // Stock the update status for test
            $enabled    = $this->image->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($enabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "image",
                    'data_log'  => "enable|statut_pays|$aid|0|1",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'image activ&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible d\'activer l\'image!');
            }

        } else { // redirect the user
            redirect('admin/image', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user to the data list
        redirect('admin/image', 'refresh');

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
                        'id_image_site'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_pays'    => '1',
                    );

                    // Stock the update status for test
                    $enable = $this->image->update($where, $toUpdate);
                    //---------------------------------------------------------------------------

                    if ($enable) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "image",
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
            redirect('admin/image', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/image', 'refresh');

    }
    //------------------------------

    //-------------------
    // DISABLE A image
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
                'id_image_site'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_pays'    => '0',
            );

            // Stock the update status for test
            $disabled   = $this->image->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($disabled) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "image",
                    'data_log'  => "disable|statut_pays|$aid|1|2",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'image d&eacute;sactiv&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de d&eacute;sactiver l\'image!');
            }

        } else { // redirect the user
            redirect('admin/image', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/image', 'refresh');

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
                        'id_image_site'        => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_pays'    => '0',
                    );

                    // Stock the update status for test
                    $disabled   = $this->image->update($where, $toUpdate);
                    //----------------------------------------------------------------------------

                    if ($disabled) { // success, row's status updated

                        $done++;

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "image",
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
            redirect('admin/image', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/image', 'refresh');

    }
    //-------------------------------

    //------------------
    // DELETE A image
    //------------------
    public function deleteImage () {

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
                'id_image_site'        => $aid,
            );

            // Set fields to be update
            $toUpdate   = array(
                'statut_image_site'    => '3',
            );

            // Stock the update status for test
            $deleted    = $this->image->update($where, $toUpdate);
            //------------------------------------------------------------------------------

            if ($deleted) { // success, row's status updated

                //-------------------
                // UPDATE LOG'S DATA
                //-------------------
                // setting up data to insert
                $toInsert   = array(
                    'user_log'  => $this->session->userdata('user_id'),
                    'table_log' => "image_site",
                    'data_log'  => "disable|statut_image_site|$aid|0,1,2|3",
                );

                // inserting log
                $this->log_file->create($toInsert);
                //-------------------

                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'success', 'message' => 'image supprim&eacute; avec succ&egrave;s!');

            } else { // warning, can't update row's status
                // set the sendback, 'message' and 'type'
                $retour = array('type' => 'warning', 'message' => 'Impossible de supprimer l\'image!');
            }

        } else { // redirect the user
            redirect('imagesite', 'refresh');
        }

        // Set the sendback message
        $this->session->set_flashdata('retour', $retour);

        // Redirect the user the data list
        redirect('admin/imagesite', 'refresh');

    }
    //------------------

    //----------------------------------------
}
?>