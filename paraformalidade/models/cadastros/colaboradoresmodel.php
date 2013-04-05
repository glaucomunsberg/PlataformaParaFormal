<?php

class ColaboradoresModel extends Model {
    
    function inserir($colaborador) {
	$this->db->trans_start();
        $this->db->set('nome', $colaborador['txtColaboradorNome']);
        $this->db->set('email', $colaborador['txtColaboradorEmail']);
        $this->db->set('sexo', $colaborador['cmbColaboradorSexo']);
        if($colaborador['txtColaboradorCidadeId'] != '')
            $this->db->set('cidade_id', $colaborador['txtColaboradorCidadeId']);
        if($colaborador['txtColaboradorProfissao'] != '')
            $this->db->set('profissao', $colaborador['txtColaboradorProfissao']);
        $this->db->set('dt_nascimento', ($colaborador['txtDtNascimento'] == '' ? 'NULL' : 'to_date(\''.$colaborador['txtDtNascimento'].'\', \'dd/mm/yyyy\')'), false);
        $this->db->set('dt_cadastro', 'NOW()', false);
	$this->db->insert('pessoas');
	$this->db->trans_complete();
	if($this->db->trans_status() === FALSE){
		$this->validate->addError('txtColaboradorId', lang('registroNaoGravado'));
	return false;
	}

        $this->ajax->addAjaxData('pessoa', $this->getColaborador($this->db->insert_id('pessoas', 'id')));
	return true;
    }

    function alterar($colaborador){
	$this->db->trans_start();
	$this->db->set('nome', $colaborador['txtColaboradorNome']);
        $this->db->set('email', $colaborador['txtColaboradorEmail']);
        $this->db->set('pessoa_tipo_id', $colaborador['cmbTipoPessoa']);
        if($colaborador['txtColaboradorCidadeId'] != '')
            $this->db->set('cidade_id', $colaborador['txtColaboradorCidadeId']);
        if($colaborador['txtColaboradorProfissao'] != '')
            $this->db->set('profissao', $colaborador['txtColaboradorProfissao']);
        $this->db->set('dt_nascimento', ($colaborador['txtDtNascimento'] == '' ? 'NULL' : 'to_date(\''.$colaborador['txtDtNascimento'].'\', \'dd/mm/yyyy\')'), false);
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
        $this->db->select('p.id, p.nome, p.sexo,p.profissao, p.email, c.id as cidadeId, c.nome as nomecidade, to_char(p.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
        $this->db->from('pessoas as p');
        $this->db->join('cidades as c','p.cidade_id = c.id', 'left');
        if(@$parametros['txtColaboradorNome'] != null )
            $this->db->like('upper(p.nome)', strtoupper(@$parametros['txtColaboradorNome']));
        if(@$parametros['cmbColaboradorSexo'] != null )
            $this->db->where('p.sexo', @$parametros['cmbColaboradorSexo']);
        if(@$parametros['txtColaboradorEmail'] != null )
            $this->db->like('p.email', @$parametros['txtColaboradorEmail']);
        if(@$parametros['txtColaboradorCidadeId'] != null )
            $this->db->where('p.cidade_id', @$parametros['txtColaboradorCidadeId']);
        $this->db->where('p.id != 1');
        $this->db->sendToGrid();
    }

    function getColaborador($colabordorId){
        $this->db->select('p.id, p.nome, p.cidade_id, p.sexo, p.pessoa_tipo_id, p.profissao, p.email, to_char(p.dt_nascimento, \'dd/mm/yyyy hh24:mi:ss\') as dt_nascimento',false);
        $this->db->from('pessoas as p');
	$this->db->where('id', $colabordorId);
	return $this->db->get('')->row();
    }
    
    public function getColaboradorByNome($nome) {
        $this->db->select('p.id, p.nome');
        $this->db->from('pessoas as p');
        $this->db->where('p.pessoa_tipo_id = 1');
        if($nome != '')
            $this->db->like('upper(p.nome)', strtoupper($nome));
        $this->db->order_by('p.nome', 'asc');
        $this->db->limit('20');
        return $this->db->get('')->result();
    }

    function validaColaborador($data) {
        $this->validate->setData($data);
        $this->validate->validateField('txtPessoaTipo', array('required'), lang('pessoaTipoRequerido'));
        return $this->validate->existsErrors();
    }

}
