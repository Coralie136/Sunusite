<?php
    class Pays_model extends MY_Model {

        public function __construct() {
            parent::__construct();
            // Chargement du modèle
            $this->load->database();
        }
        
        protected $ma_table = 'pays';
        
    }
?>