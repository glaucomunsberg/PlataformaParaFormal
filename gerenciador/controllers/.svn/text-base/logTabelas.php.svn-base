<?php

class LogTabelas extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('LogTabelaModel', 'logTabelaModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('logTabelasFiltroView', $data);
    }

    function listaTabelas() {
        $this->logTabelaModel->getTabelas($_GET);
    }

    function editar($esquema, $tabela) {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']) . ' / Editar / ' . $esquema . '.' . $tabela;
        $data['esquema'] = $esquema;
        $data['tabela'] = $tabela;
        $this->load->view('logTabelasView', $data);
    }

    function listaColunas($esquema, $tabela) {
        $this->logTabelaModel->getColunas($_GET, $esquema, $tabela);
    }

    function salvarLogTabela() {
        $isSucess = $this->logTabelaModel->salvarLogTabela($_POST);

        if ($isSucess) {
            $this->ajax->addAjaxData('success', true);
        } else {
            $this->ajax->addAjaxData('success', false);
        }
        $this->ajax->returnAjax();
    }

    function buscaColunasLogTabela() {
        $this->ajax->AddAjaxData('colunas', $this->logTabelaModel->getColunasLogTabela($_POST['tabela']));
        $this->ajax->returnAjax();
    }

    function listaLogTabela($esquema, $tabela) {
        $this->logTabelaModel->getLogTabela($_GET, $esquema, $tabela);
    }

}
