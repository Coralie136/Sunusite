<?php
    class Assurables_model extends MY_Model {
        
        protected $ma_table = 'assurable';

        public function readAssurable($select = '', $where = ''){
        	return  $this->db->select($select)
						 ->from($this->ma_table)
                         ->join('categorie_assurable', 'categorie_assurable.id_assurable = assurable.id_assurable')
						 ->where($where)
						 ->get()
						 ->result();
        }
        
    }
?>