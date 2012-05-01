<?php

class ColaboradorModel extends Model {
    
    function inserir($colaborador) {
	$this->db->trans_start();
        $this->db->set('nome', $colaborador['txtColaboradorNome']);
        $this->db->set('email', $colaborador['txtColaboradorEmail']);
        $this->db->set('sexo', $colaborador['cmbColaboradorSexo']);
        $this->db->set('cidade_id', $colaborador['txtColaboradorCidadeId']);
        $this->db->set('dt_cadastro', 'NOW()', false);
        $this->db->set('pessoa_tipo_id', 11);
	$this->db->insert('pessoas');
	$this->db->trans_complete();
        logLastSQL();
	if($this->db->trans_status() === FALSE){
		$this->validate->addError('txtColaboradorId', lang('registroNaoGravado'));
	return false;
	}

        $this->ajax->addAjaxData('pessoa', $this->getPessoaTipo($this->db->insert_id('pessoas', 'id')));
	return true;
    }

    function alterar($colaborador){
	$this->db->trans_start();
	$this->db->set('nome', $colaborador['txtColaboradorNome']);
        $this->db->set('email', $colaborador['txtColaboradorEmail']);
        $this->db->set('cidade_id', $colaborador['txtColaboradorCidadeId']);
        $this->db->set('sexo', $colaborador['cmbColaboradorSexo']);
	$this->db->where('id', $colaborador['txtColaboradorId']);
	$this->db->update('pessoas');
	$this->db->trans_complete();
        logLastSQL();
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtColaboradorNomeId', lang('registroNaoGravado'));
	return false;
	}
	$this->ajax->addAjaxData('colaborador', $this->getColaborador($colaborador['txtColaboradorId']));
        return true;
    }

    function excluir($id) {
	$this->db->trans_start();
	$aNotasTipos = explode(',', $id);
	$aExcluirNotasTipos = array();
	for($i = 0; $i < count($aNotasTipos); $i++)
            if($aNotasTipos[$i] != 'undefined')
                array_push($aExcluirNotasTipos, $aNotasTipos[$i]);
	$this->db->where_in('id', $aExcluirNotasTipos);
	$this->db->delete('pessoas');
	$this->db->trans_complete();
        if($this->db->trans_status() === FALSE)					
            return false;
	return true;
    }

    function getColaboradores($parametros) {
        $this->db->select('p.id, p.nome, p.sexo, p.email,c.id as cidadeId, c.nome as cidadeNome, p.dt_cadastro', false);
        $this->db->from('pessoas as p');
        $this->db->join('cidades as c','p.cidade_id = c.id', 'left');
        if(@$parametros['txtColaboradorNome'] != null )
            $this->db->like('p.nome', @$parametros['txtColaboradorNome']);
        if(@$parametros['cmbColaboradorSexo'] != null )
            $this->db->where('p.sexo', @$parametros['cmbColaboradorSexo']);
        if(@$parametros['txtColaboradorEmail'] != null )
            $this->db->like('p.email', @$parametros['txtColaboradorEmail']);
        if(@$parametros['txtColaboradorCidadeId'] != null )
            $this->db->like('cidade_id', @$parametros['txtColaboradorCidadeId']);
        $this->db->where('p.pessoa_tipo_id = 11');
        $this->db->sendToGrid();
    }

    function getColaborador($colabordorId){
	$this->db->where('id', $colabordorId);
	return $this->db->get('pessoas')->row();
    }

    function validaColaborador($data) {
        $this->validate->setData($data);
        $this->validate->validateField('txtPessoaTipo', array('required'), lang('pessoaTipoRequerido'));
        return $this->validate->existsErrors();
    }

}