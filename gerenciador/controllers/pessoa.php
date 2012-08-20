<?php

class Pessoa extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('PessoaModel', 'pessoaModel');
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('GrupoModel', 'grupoModel');
        $this->load->model('PessoaTipoModel', 'pessoaTipoModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $data['cmbPessoaTipo'] = $this->pessoaTipoModel->getPessoasTiposCombo();
        $this->load->view('pessoaFiltroView', $data);
    }

    function listaPessoas() {
        $this->pessoaModel->getPessoas($_GET);
    }

    function salvar() {
        if ($_POST['txtCodigo'] == '') {
            $ret = $this->pessoaModel->inserir($_POST);
        } else {
            $ret = $this->pessoaModel->alterar($_POST);
        }
        if ($ret) {
            $this->ajax->ajaxMessage('sucess', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->pessoaModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function novo() {
        $data['cmbPessoaTipo'] = $this->pessoaTipoModel->getPessoasTiposCombo();
        $data['sexo'] = array (array ("M", lang('pessoaSexoMasc')), array ("F", lang('pessoaSexoFem')));
        $this->load->view('pessoaView',$data);
    }
    
    function editar($id){
        $data['pessoa'] = $this->pessoaModel->getPessoa($id);
        $data['cmbPessoaTipo'] = $this->pessoaTipoModel->getPessoasTiposCombo();
        $data['sexo'] = array (array ("M", lang('pessoaSexoMasc')), array ("F", lang('pessoaSexoFem')));
        $this->load->view('pessoaView', $data);
    }

    function buscar($pessoa) {
        $data['pessoa'] = $this->pessoaModel->getPessoa($pessoa);
        $this->load->view('pessoaView', $data);
    }

    function excluir() {
        $this->pessoaModel->excluir($_POST['id']);
    }

    function listaGrupos() {
        $this->ajax->returnGrid($this->grupoModel->getAllGrupos());
    }

    function listaGruposPessoa() {
        $this->ajax->addAjaxData('pessoaGrupos', $this->pessoaModel->getGruposPessoa($_POST['pessoaId']));
        $this->ajax->returnAjax();
    }

}
