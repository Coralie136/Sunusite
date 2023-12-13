<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller{
    public function __construct(){
        parent::__construct();
        
        $this->load->model('experience_table', 'experience'); // load the experience_table model as 'experience'
        $this->load->model('history_table', 'historique'); // load the history_table model as 'historique'
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'
        $this->load->model('photo_table', 'photo'); // load the photo_table model as 'photo'
        $this->load->model('Image_site_table', 'slider'); // load the photo_table model as 'photo'

    }
    
    public function loadRequester() {
        
        // get required variables and create new object date from them
        $startDate  = DateTime::createFromFormat('d/m/Y', $this->input->get('startDate'));
        $endDate    = DateTime::createFromFormat('d/m/Y', $this->input->get('endDate'));
        
        // parse the dates in the right sql format for queries
        $startDate  = $startDate->format('Y-m-d');
        $endDate    = $endDate->format('Y-m-d');
        
        //--------------------------------------------------------------------------------------------
        // Get list of all requester's sites in database (LIMIT NONE) BETWEEN $startDate AND $endDate
        //
        // READ DATA FROM requester
        //--------------------------------------------------------------------------------------------

            $select = '*';
            $where  = array(
                'startDate_requester BETWEEN \''.$startDate.'\' AND'    => $endDate
            );

            $this->data['sites']    = $this->db->select($select)
                ->from('requester')
                ->where($where)
                ->order_by('code_requester', 'ASC')
                ->get()
                ->result();

        //--------------------------------------------------------------------------------------------
        
        $this->data['startDate']    = $startDate;
        $this->data['endDate']      = $endDate;
        
        // load and feel the right view with data
        $this->load->view('admin/load_requester', $this->data);
        
    }
    //--------------------------------------------------------------------------------
    // LOAD HISTORY INFORMATIONS AND/OR DISPLAY A FORM (FILLED OR EMPTY) IF NECESSARY
    //--------------------------------------------------------------------------------
        public function loadHistory () {

            //-----------------------------------------------------------------
            // SET ALL THE CSS, JS AND FUNCTIONS REQUIRED FOR THE CURRENT PAGE
            //-----------------------------------------------------------------

                // all the js required
                $this->data['javascripts'] = array(
                    'global/plugins/select2/js/select2.full.min.js',
                    'pages/scripts/components-select2.min.js',
                    
                    'global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js',
                    'pages/scripts/components-bootstrap-multiselect.min.js',
                );
                // all the css required
                $this->data['css'] = array(
                    'global/plugins/select2/css/select2.min.css',
                    'global/plugins/select2/css/select2-bootstrap.min.css',
                    
                    'global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css',
                );

            //-----------------------------------------------------------------

            // Required variables
            $hid                    = (int)$this->input->get('hid');
            $this->data['readOnly'] = $this->input->get('readOnly');
            $this->data['history']  = '';
            $this->data['color']    = 'blue-steel';

            if (!empty($hid)) { // return data only if the sent id is not empty or null
                
                $this->data['color']    = 'yellow-crusta';

                //-----------------------------------------------------
                // GET ALL THE CLASSROOMS THOSE TOOK PART AT THIS EXAM
                //-----------------------------------------------------
                
                    // Array of where clauses
                    $where  = array(
                        'id_historique'         => $hid,
                        'statut_historique !='  => '3',
                    );

                    // execute the query and return all the required rows
                    $this->data['history']      = $this->historique->read('*', $where);

                //-----------------------------------------------------

            }

            // Load and feed the right view with data
            $this->load->view('admin/load_frmHistory', $this->data);

        }
    //--------------------------------------------------------------------------------
    
    //-----------------------------------------------------------------------------------
    // LOAD EXPERIENCE INFORMATIONS AND/OR DISPLAY A FORM (FILLED OR EMPTY) IF NECESSARY
    //-----------------------------------------------------------------------------------
        public function loadExperience () {

            //-----------------------------------------------------------------
            // SET ALL THE CSS, JS AND FUNCTIONS REQUIRED FOR THE CURRENT PAGE
            //-----------------------------------------------------------------

                // all the js required
                $this->data['javascripts'] = array(
                    'global/plugins/select2/js/select2.full.min.js',
                    'pages/scripts/components-select2.min.js',
                    
                    'global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js',
                    'pages/scripts/components-bootstrap-multiselect.min.js',
                );
                // all the css required
                $this->data['css'] = array(
                    'global/plugins/select2/css/select2.min.css',
                    'global/plugins/select2/css/select2-bootstrap.min.css',
                    
                    'global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css',
                );

            //-----------------------------------------------------------------

            // Required variables
            $eid                        = (int)$this->input->get('eid');
            $this->data['did']          = (int)$this->input->get('did');
            $this->data['readOnly']     = $this->input->get('readOnly');
            $this->data['experience']   = '';
            $this->data['color']        = 'blue-steel';

            if (!empty($eid)) { // return data only if the sent id is not empty or null
                
                $this->data['color']    = 'yellow-crusta';

                //-----------------------------------------------------
                // GET ALL THE CLASSROOMS THOSE TOOK PART AT THIS EXAM
                //-----------------------------------------------------
                
                    // Array of where clauses
                    $where  = array(
                        'id_experience'         => $eid,
                        'id_equipe'             => $this->data['did'],
                        'statut_experience !='  => '3',
                    );

                    // execute the query and return all the required rows
                    $this->data['experience']   = $this->experience->read('*', $where);

                //-----------------------------------------------------

            }
            
//            var_dump($this->data['experience']);
//            exit;

            // Load and feed the right view with data
            $this->load->view('admin/load_frmExperience', $this->data);

        }
    //-----------------------------------------------------------------------------------
    
    
    
    //--------------------------------------------------------------------------------
    // LOAD ARTICLE INFORMATIONS AND/OR DISPLAY A FORM (FILLED OR EMPTY) IF NECESSARY
    //--------------------------------------------------------------------------------
        public function loadArticlePhoto () {

            // Required variables
            $this->data['aid']              = (int)$this->input->get('aid');
            $this->data['articlePhotos']    = '';

            if (!empty($this->data['aid'])) { // return data only if the sent id is not empty or null
                
                //-----------------------------------------------------
                // GET ALL THE CLASSROOMS THOSE TOOK PART AT THIS EXAM
                //-----------------------------------------------------
                
                    // array of joins to store one or multiple join condition
                    $joins      = array(
                        'join0' => array(
                            'table'     => 'article',
                            'condition' => 'article.id_article = photo.id_article',
                            'type'      => 'inner',
                        ),
                    );

                    // array of all the where condition using OR
                    $orWhere    = array();

                    // array of all the where condition using AND
                    $where      = array(
                        'article.id_article'        => $this->data['aid'],
                        'article.statut_article !=' => '3',
                        'photo.statut_photo'        => '1',
                    );

                    // value of rows the query should return
                    $limit      = 0;

                    // array of all the order condition
                    $order      = array(
                        'photo.dateCreated_photo'   => 'DESC',
                    );

                    // execute the query and return all the required rows
                    $this->data['articlePhotos']    = $this->photo->readJoins('photo.id_photo, photo.fichier_photo, photo.statut_photo', $joins, $orWhere, $where, $limit, $order);

                //-----------------------------------------------------

            }

            // Load and feed the right view with data
            $this->load->view('admin/load_articlePhoto', $this->data);

        }
    //--------------------------------------------------------------------------------
    // LOAD ARTICLE INFORMATIONS AND/OR DISPLAY A FORM (FILLED OR EMPTY) IF NECESSARY
    //--------------------------------------------------------------------------------
        public function loadSliderPhoto () {

            // Required variables
            //$this->data['aid']              = (int)$this->input->get('aid');
            $this->data['sliderImages']    = '';

                //-----------------------------------------------------
                // GET ALL THE CLASSROOMS THOSE TOOK PART AT THIS EXAM
                //-----------------------------------------------------


            // array of all the where condition using OR
            $orWhere    = array();

            // array of all the where condition using AND
            $where      = array(
                'image_site.statut_image_site'        => '1',
            );

            // value of rows the query should return
            $limit      = 0;

            // array of all the order condition
            $order      = array(
                'image_site.dateCreated_image'   => 'DESC',
            );

            // execute the query and return all the required rows
            $this->data['sliderImages']    = $this->slider->read('*', $where, $limit, $order);

                //-----------------------------------------------------



            // Load and feed the right view with data
            $this->load->view('admin/load_sliderPhoto', $this->data);

        }
    //--------------------------------------------------------------------------------

    //------------------------
    // DELETE A ARTICLE PHOTO
    //------------------------
        public function deleteArticlePhoto () {

            // Process only if there is an id selected
            $aid = $this->input->get('aid');
            if (!empty($aid)) { // process

                // Get the sent row's id
                $pid    = ((int)$this->input->get('pid') > 0) ? (int)$this->input->get('pid') : 0;
                
                if (!empty($pid)) {

                    //------------------------------------------------------------------------------
                    // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $aid)
                    //------------------------------------------------------------------------------
                        // Where clause for the update
                        $where      = array(
                            'id_photo'      => $pid,
                        );

                        // Set fields to be update
                        $toUpdate   = array(
                            'statut_photo'  => '3',
                        );

                        // Stock the update status for test
                        $deleted    = $this->photo->update($where, $toUpdate);
                    //------------------------------------------------------------------------------

                    if ($deleted) { // success, row's status updated

                        //-------------------
                        // UPDATE LOG'S DATA
                        //-------------------
                            // setting up data to insert
                            $toInsert   = array(
                                'user_log'  => $this->session->userdata('user_id'),
                                'table_log' => "photo",
                                'data_log'  => "disable|statut_photo|$pid|0,1,2|3",
                            );

                            // inserting log
                            $this->log_file->create($toInsert);
                        //-------------------

                    } // End if
                    
                } // End if

            } // End if

        }
    //------------------------
    //------------------------
    // DELETE A ARTICLE PHOTO
    //------------------------
        public function deleteSliderPhoto () {

            // Process only if there is an id selected
            $aid = $this->input->get('delete');
            //var_dump($aid); die();
            if (!empty($aid)) { // process

                //------------------------------------------------------------------------------
                // ENABLE THE ROW THAT'S CORRESPOND TO THE SENT ID (statut == 3, id == $aid)
                //------------------------------------------------------------------------------
                    // Where clause for the update
                    $where      = array(
                        'id_image_site'      => $aid,
                    );

                    // Set fields to be update
                    $toUpdate   = array(
                        'statut_image_site'  => '3',
                    );

                    // Stock the update status for test
                    $deleted    = $this->slider->update($where, $toUpdate);
                //------------------------------------------------------------------------------

                if ($deleted) { // success, row's status updated

                    //-------------------
                    // UPDATE LOG'S DATA
                    //-------------------
                        // setting up data to insert
                        $toInsert   = array(
                            'user_log'  => $this->session->userdata('user_id'),
                            'table_log' => "photo",
                            'data_log'  => "disable|statut_image_site|$pid|0,1,2|3",
                        );

                        // inserting log
                        $this->log_file->create($toInsert);
                    //-------------------

                } // End if

            } // End if

        }
    //------------------------
    
}
    
?>