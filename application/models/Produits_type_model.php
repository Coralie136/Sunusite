<?php
    class Produits_type_model extends MY_Model {
        
        protected $ma_table = 'type_produit';

        public function readProd($select = '', $where = ''){
        	return  $this->db->select($select)
						 ->from($this->ma_table)
                         ->join('pays_type_produit', 'pays_type_produit.id_type_produit = type_produit.id_type_produit')
						 ->where($where)
						 ->get()
						 ->result();
        }
        
    }
?>