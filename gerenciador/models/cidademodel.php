<?php

class CidadeModel extends Model {

    function getCidadesCombo() {
        $this->db->select('id, nome_cidade');
        $this->db->where('flg_clima_tempo', 'S');
        $this->db->order_by('nome_cidade', 'asc');
        return $this->db->get('cidades')->result_array();
    }
    
    public function getCidadeByNome($nome, $limit = 20) {
        $this->db->select('id, nome');
        $this->db->from('cidades');
        $this->db->like('nome', $nome);
        $this->db->order_by('nome', 'asc');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    function getCidadeById($cidadeId){
	$this->db->where('id', $cidadeId);
	return $this->db->get('cidades')->row();
    }
    

}
