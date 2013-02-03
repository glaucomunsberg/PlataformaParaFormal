<?php

class PessoaModel extends Model {

    function inserir($pessoa) {
        $retErro = $this->validaPessoa($pessoa);
        if ($retErro) {
            return false;
        }
        $this->db->trans_start();
        $this->db->set('nome', $pessoa['txtNome']);
        $this->db->set('pessoa_tipo_id', $pessoa['cmbPessoaTipo']);
        $this->db->set('sexo', $pessoa['cmbSexo']);
        $this->db->set('dt_nascimento', ($pessoa['txtDtNascimento'] == '' ? 'NULL' : 'to_date(\''.$pessoa['txtDtNascimento'].'\', \'dd/mm/yyyy\')'), false);
        if($pessoa['txtTelefone'] != '')
            $this->db->set('telefone', $pessoa['txtTelefone']);
        $this->db->set('email', $pessoa['txtEmail']);
        $this->db->set('dt_cadastro', 'NOW()', false);
        $this->db->insert('pessoas');
	$this->db->trans_complete();
        
	if($this->db->trans_status() === FALSE){
		$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
	return false;
	}

        $this->ajax->addAjaxData('pessoa', $this->getPessoa($this->db->insert_id('pessoas', 'id')));
	return true;
    }

    function alterar($pessoa) {
        $retErro = $this->validaPessoa($pessoa);
        if ($retErro) {
            return false;
        }

        $this->db->trans_start();
        
        $this->db->set('nome', $pessoa['txtNome']);
        $this->db->set('pessoa_tipo_id', $pessoa['cmbPessoaTipo']);
        $this->db->set('sexo', $pessoa['cmbSexo']);
        $this->db->set('dt_nascimento', ($pessoa['txtDtNascimento'] == '' ? 'NULL' : 'to_date(\''.$pessoa['txtDtNascimento'].'\', \'dd/mm/yyyy\')'), false);
        if($pessoa['txtTelefone'] != '')
            $this->db->set('telefone', $pessoa['txtTelefone']);
        $this->db->set('email', $pessoa['txtEmail']);

        $this->db->where('id', $pessoa['txtCodigo']);
        $this->db->update('pessoas');
        $this->ajax->addAjaxData('pessoa', $this->getPessoa($pessoa['txtCodigo']));

	$this->db->trans_complete();
        
	if($this->db->trans_status() === FALSE){
            $this->validate->addError('txtCodigo', lang('registroNaoGravado'));
	return false;
	}
	$this->ajax->addAjaxData('pessoa', $this->getPessoa($pessoa['txtCodigo']));
            return true;
    }

    function excluir($id) {
        $this->db->where('id', $id);
        $this->db->delete('pessoas');
        return true;
    }

    function getPessoas($parametros) {
        $this->db->select('p.id, p.nome, pt.tipo, p.dt_cadastro, p.sexo',false);
        $this->db->from('public.pessoas as p');
        $this->db->join('public.pessoas_tipos as pt','p.pessoa_tipo_id = pt.id', 'left');
        if(@$parametros['txtNome'] != '')
              $this->db->like('upper(p.nome)', strtoupper(@$parametros['txtNome']));
        if(@$parametros['cmbComboTipoPessoa'] != '')
              $this->db->where('pt.id', @$parametros['cmbComboTipoPessoa']);
        $this->db->where('p.pessoa_tipo_id is not null');
        $this->db->sendToGrid();
    }

    function getPessoasCombo() {
        $this->db->select('id, nome as nome', false);
        $this->db->orderby('nome', 'asc');
        return $this->db->get('pessoas')->result_array();
    }

    function getPessoa($id) {
        $this->db->select('id, nome, sexo, dt_cadastro, dt_nascimento, email, telefone, pessoa_tipo_id', false);
        $this->db->where('id', $id);
        return $this->db->get('pessoas')->row();
    }

    function getPessoaByRg($rg) {
        $this->db->where('rg', $rg);
        return $this->db->get('pessoas')->row();
    }

    function getPessoaByCpf($cpf) {
        $this->db->where('cpf', str_ireplace('-', '', str_ireplace('.', '', $cpf)));
        return $this->db->get('pessoas')->row();
    }

    function getGruposPessoa($idPessoa) {
        $this->db->where('pessoa_id', $idPessoa);
        return $this->db->get('pessoas_grupos')->result();
    }
    
    public function getPessoaByNome($nome) {
        $this->db->select('p.id, p.nome');
        $this->db->from('pessoas as p');
        if($nome != '')
            $this->db->like('upper(p.nome)', strtoupper($nome));
        $this->db->order_by('p.nome', 'asc');
        $this->db->limit('20');
        return $this->db->get('')->result();
    }
    function validaPessoa($data) {
        $this->validate->setData($data);
        $this->validate->validateField('txtNome', array('required'), lang('pessoaNomeRequerido'));
        $this->validate->validateField('cmbPessoaTipo', array('required'), lang('pessoaTipoRequerido'));
        $this->validate->validateField('cmbSexo', array('required'), lang('pessoaSexoRequerido'));
        $this->validate->validateField('txtEmail', array('required'), lang('pessoaEmailRequerido'));
        return $this->validate->existsErrors();
    }

}
