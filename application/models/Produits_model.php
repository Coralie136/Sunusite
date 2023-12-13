<?php
    class Produits_model extends MY_Model {
        
        protected $ma_table = 'produit';

        public function readProd($select = '', $where = ''){
        	return  $this->db->select($select)
						 ->from($this->ma_table)
                         ->join('pays_type_produit', 'pays_type_produit.id_produit = produits.id_produit')
						 ->where($where)
						 ->get()
						 ->result();
        }
        
    }
?>