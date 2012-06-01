<?php

class CidadeModel extends Model {

    function getCidadesCombo() {
        $this->db->select('id, nome_cidade');
        $this->db->where('flg_clima_tempo', 'S');
        $this->db->order_by('nome_cidade', 'asc');
        return $this->db->get('cidades')->result_array();
    }
    
    public function getCidadeByNome($nome) {
        $this->db->select('c.id, c.nome || \' - \' || uf.sigla');
        $this->db->from('cidades as c');
        $this->db->join('unidades_federativas as uf','c.unidade_federativa_id = uf.id');
        if($nome != '')
            $this->db->like('upper(c.nome)', strtoupper($nome));
        $this->db->order_by('c.nome', 'asc');
        $this->db->limit('20');
        return $this->db->get('')->result();
    }
    
    function getCidadeById($cidadeId){
	$this->db->where('id', $cidadeId);
	return $this->db->get('cidades')->row();
    }
    

}
