<?php

class PessoaTipoModel extends Model {
    
    function inserir($pessoaTipo) {
	$this->db->trans_start();
        $this->db->set('tipo', $pessoaTipo['txtPessoaTipo']);
        $this->db->set('dt_cadastro', 'NOW()', false);
	$this->db->insert('pessoas_tipos');
	$this->db->trans_complete();
        logLastSQL();
	if($this->db->trans_status() === FALSE){
		$this->validate->addError('txtPessoaTipo', lang('registroNaoGravado'));
	return false;
	}

        $this->ajax->addAjaxData('pessoa_tipo', $this->getPessoaTipo($this->db->insert_id('pessoas_tipos', 'id')));
	return true;
    }

    function alterar($pessoaTipo){
	$this->db->trans_start();
	$this->db->set('tipo', $pessoaTipo['txtPessoaTipo']);		
	$this->db->where('id', $pessoaTipo['txtPessoaTipoId']);
	$this->db->update('pessoas_tipos');
	$this->db->trans_complete();
        logLastSQL();
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtPessoaTipoId', lang('registroNaoGravado'));
	return false;
	}
	$this->ajax->addAjaxData('pessoas_tipos', $this->getPessoaTipo($pessoaTipo['txtPessoaTipoId']));
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
	$this->db->delete('pessoas_tipos');
	$this->db->trans_complete();
        if($this->db->trans_status() === FALSE)					
            return false;
	return true;
    }

    function getPessoasTipos($parametros) {
        $this->db->select('id, tipo, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
        $this->db->from('pessoas_tipos');
        if(@$parametros['txtPessoaTipo'] != null )
            $this->db->where('tipo', @$parametros['txtPessoaTipo']);
        $this->db->sendToGrid();
    }

    function getPessoasTiposCombo() {
        $this->db->select('id, tipo as descricao', false);
        $this->db->orderby('tipo', 'asc');
        return $this->db->get('pessoas_tipos')->result_array();
    }

    function getPessoaTipo($pessoaTipoId){
	$this->db->where('id', $pessoaTipoId);
	return $this->db->get('pessoas_tipos')->row();
    }

    function validaPessoaTipo($data) {
        $this->validate->setData($data);
        $this->validate->validateField('txtPessoaTipo', array('required'), lang('pessoaTipoRequerido'));
        return $this->validate->existsErrors();
    }

}
