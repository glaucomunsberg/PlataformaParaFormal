<?php

class CidadeModel extends Model {

    function getCidadesCombo() {
        $this->db->select('id, nome_cidade');
        $this->db->where('flg_clima_tempo', 'S');
        $this->db->order_by('nome_cidade', 'asc');
        return $this->db->get('cidades')->result_array();
    }
    
    function inserir($cidade) {
	$this->db->trans_start();
        $this->db->set('nome', $cidade['txtCidade']);
        $this->db->set('unidade_federativa_id', $cidade['cmbEstado']);
        $this->db->set('geo_latitude', $cidade['txtCidadeLat']);
        $this->db->set('geo_longitude', $cidade['txtCidadeLng']);
        $this->db->set('dt_cadastro', 'NOW()', false);
	$this->db->insert('cidades');
	$this->db->trans_complete();
        logLastSQL();
	if($this->db->trans_status() === FALSE){
		$this->validate->addError('txtPessoaTipo', lang('registroNaoGravado'));
	return false;
	}

        $this->ajax->addAjaxData('cidade', $this->getCidadeById($this->db->insert_id('cidades', 'id')));
	return true;
    }
    
    function alterar($cidade){
	$this->db->trans_start();
	$this->db->set('nome', $cidade['txtCidade']);
        $this->db->set('unidade_federativa_id', $cidade['cmbEstado']);
        $this->db->set('geo_latitude', $cidade['txtCidadeLat']);
        $this->db->set('geo_longitude', $cidade['txtCidadeLng']);		
	$this->db->where('id', $cidade['txtCidadeId']);
	$this->db->update('cidades');
	$this->db->trans_complete();
        logLastSQL();
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtCidadeId', lang('registroNaoGravado'));
	return false;
	}
	$this->ajax->addAjaxData('cidade', $this->getCidadeById($cidade['txtCidadeId']));
            return true;
    }
    
    
    public function getCidades($parametros){
         $this->db->select('c.id, c.nome as cidade, u.nome as estado, to_char(c.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
        $this->db->from('cidades as c');
        $this->db->join('unidades_federativas as u','c.unidade_federativa_id = u.id');
        if(@$parametros['txtCidade'] != null )
                $this->db->like('upper(c.nome)', @$parametros['txtCidade']);
        if(@$parametros['cmbEstado'] != null )
                $this->db->where('u.id', @$parametros['cmbEstado']);
        $this->db->sendToGrid();
        
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
    
    function getEstadosCombo(){
        $this->db->select('id, nome as descricao');
        $this->db->order_by('nome', 'asc');
        return $this->db->get('unidades_federativas')->result_array();
    }

}
