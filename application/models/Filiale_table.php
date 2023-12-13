<?php
class Filiale_table extends MY_Model {

    protected $ma_table = 'description';

    public function readFiliales($select = '*', $where = array()){
        return $this->db->select($select)
            ->from($this->ma_table)
            ->join('pays', 'pays.id_pays = description.id_pays')
            ->where($where)
            ->get()
            ->result();
        //var_dump($query);die(); 
    }

}
?>