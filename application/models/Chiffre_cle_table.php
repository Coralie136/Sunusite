<?php
class Chiffre_cle_table extends MY_Model {

    protected $ma_table = 'chiffre_cle';

    function getLastChiffre($where, $select, $params = array()){
        $this->db->select($select);
        $this->db->from('chiffre_cle');
        $this->db->where($where);
        $this->db->order_by('dateCreated_chiffre_cle','DESC');

        /*if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'], $params['start']);
        }elseif(!array_key_exists("start", $params) && array_key_exists("limit", $params)){
            $this->db->limit($params['limit']);
        }*/

        $query = $this->db->get();

        // return ($query->num_rows() > 0)?$query->result_array():FALSE;
        return $query->result();
    }

}
?>