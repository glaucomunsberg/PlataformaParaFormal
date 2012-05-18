<?php

class CidadeModel extends Model {

    function getCidadesCombo() {
        $this->db->select('id, nome_cidade');
        $this->db->where('flg_clima_tempo', 'S');
        $this->db->order_by('nome_cidade', 'asc');
        return $this->db->get('cidades')->result_array();
    }
    
    public function getCidadeByNome($nome) {
        $this->db->select('id, nome');
        $this->db->from('cidades');
        if($nome != '')
            $this->db->like('upper(nome)', strtoupper($nome));
        $this->db->order_by('nome', 'asc');
        $this->db->limit('20');
        return $this->db->get('')->result();
    }
    
    function getCidadeById($cidadeId){
	$this->db->where('id', $cidadeId);
	return $this->db->get('cidades')->row();
    }
    

}
