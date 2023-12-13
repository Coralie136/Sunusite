<?php
	class Contact_table extends MY_Model {
		
		protected $ma_table = 'contact';

        public function readContacts($select = '*', $where = array()){
            return $this->db->select($select)
                ->from($this->ma_table)
                ->join('pays', 'pays.id_pays = contact.id_pays')
                ->where($where)
                ->get()
                ->result();
            //var_dump($query);die();
        }
        
	}
?>