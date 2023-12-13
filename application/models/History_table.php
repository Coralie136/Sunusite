<?php
class History_table extends MY_Model {

    protected $ma_table = 'historique';

    function getHistory($where, $params = array()){
        $this->db->select('DISTINCT(annee_historique)');
        $this->db->from('historique');
        $this->db->where($where);
        $this->db->order_by('annee_historique','DESC');

        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'], $params['start']);
        }elseif(!array_key_exists("start", $params) && array_key_exists("limit", $params)){
            $this->db->limit($params['limit']);
        }

        // if (isset($params['limit'])) {
        //     if (isset($params['start'])) {
        //         $this->db->limit($params['limit'], $params['start']);
        //     } else {
        //         $this->db->limit($params['limit']);
        //     }
        // }

        $query = $this->db->get();

        // return ($query->num_rows() > 0)?$query->result_array():FALSE;
        return $query->result();
    }

}
?>