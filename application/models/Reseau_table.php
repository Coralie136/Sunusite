<?php
class Reseau_table extends MY_Model {

    protected $ma_table = 'reseau_social';

    public function readReseauSocial($select = '*', $where = array()){
        return $this->db->select($select)
            ->from($this->ma_table)
            //->join('pays', 'pays.id_pays = contact.id_pays')
            ->where($where)
            ->get()
            ->result();
        //var_dump($query);die();
    }

}
?>