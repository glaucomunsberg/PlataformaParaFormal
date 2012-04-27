<?php

class Pessoa extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('PessoaModel', 'pessoaModel');
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('GrupoModel', 'grupoModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $this->load->view('pessoaFiltroView', $data);
    }

    function listaPessoas() {
        $this->ajax->returnGrid($this->pessoaModel->getPessoas(@$_GET['nomePessoa'], @$_GET['cpf'], $_GET['start'], $_GET['limit']));
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
        $this->load->view('pessoaView');
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
