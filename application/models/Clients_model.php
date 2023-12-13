<?php
    class Clients_model extends MY_Model {
        
        protected $ma_table = 'clients';

        public function readClients($select = '*', $where = array()){
        	return  $this->db->select($select)
						 ->from($this->ma_table)
                         ->join('pays', 'pays.id_pays = clients.id_pays')
                         ->join('souscription', 'souscription.id_souscription = clients.id_souscription')
                         ->join('categorie', 'categorie.id_categorie = clients.id_categorie')
                         ->join('age', 'age.id_age = clients.id_age')
						 ->where($where)
						 ->get()
						 ->result();
        }
        
    }
?>