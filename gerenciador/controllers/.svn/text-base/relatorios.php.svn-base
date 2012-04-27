<?php

class Relatorios extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('PerfilModel', 'perfilModel');
        $this->load->model('relatorios/RelatorioModel', 'relatorioModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('relatorios/relatoriosFiltroView', $data);
    }

    function novo() {
        $this->load->view('relatorios/relatoriosView');
    }

    function abrir($relatorio_id) {
        $data['relatorio'] = $this->relatorioModel->getRelatorio($relatorio_id);
        $this->load->view('relatorios/relatoriosView', $data);
    }

    function excluir() {
        $success = $this->relatorioModel->excluir($_POST['id']);

        if ($success) {
            $this->ajax->addAjaxData('success', true);
        } else {
            $this->ajax->addAjaxData('success', false);
        }
        $this->ajax->returnAjax();
    }

    function salvar() {
        if ($_POST['txtRelatorioId'] == '') {
            $ret = $this->relatorioModel->incluir($_POST);
        } else {
            $ret = $this->relatorioModel->alterar($_POST);
        }

        if ($ret) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            $this->ajax->addAjaxData('error', $this->relatorioModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }

    function listaPerfis() {
        $this->ajax->returnGrid($this->perfilModel->getPerfis());
    }

    function listaPerfisRelatorio() {
        $this->ajax->addAjaxData('perfisRelatorio', $this->relatorioModel->getPerfisRelatorio($_POST['relatorioId']));
        $this->ajax->returnAjax();
    }

    function listaRelatorios() {
        $this->ajax->returnGrid($this->relatorioModel->getRelatorios());
    }

}
