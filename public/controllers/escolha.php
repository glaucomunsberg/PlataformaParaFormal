<?php

class Escolha extends Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('../../paraformalidade/models/cadastros/gruposAtividadesModel', 'grupoAtividadeModel');
        $this->load->model('../../paraformalidade/models/cadastros/paraformalidadeModel', 'paraformalidadeModel');
    }
    
    function index(){
        $data['cidades_atividades'] = $this->grupoAtividadeModel->getGrupoAtividadeCombo();
        $this->load->view('escolhaFiltroView', $data);
    }
    
    function exibir($GrupoAtividadeId){
        $data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($GrupoAtividadeId);
        $data['paraformalidadesToMaps'] = $this->paraformalidadeModel->getParaformalidadeToMaps($GrupoAtividadeId);
        $this->load->view('paraformalidadesView', $data);
    }
    
    function exibirCena(){
        $this->ajax->addAjaxData('paraformalidade', $this->paraformalidadeModel->getCenaParaExibir($_POST['id']) );
	$this->ajax->returnAjax();
    }
    function exibirCenaGet($id){
        $this->ajax->addAjaxData('paraformalidade', $this->paraformalidadeModel->getCenaParaExibir($id) );
	$this->ajax->returnAjax();
    }
    
    function carregaColaboradores(){
        $this->ajax->addAjaxData('colaboradores', $this->paraformalidadeModel->getColaboradorParaExibir($_POST['id']) );
	$this->ajax->returnAjax();
    }
    function carregaSentidos(){
        $this->ajax->addAjaxData('sentidos', $this->paraformalidadeModel->getSentidosParaExibir($_POST['id']) );
	$this->ajax->returnAjax();
    }
    function carregaClimas(){
        $this->ajax->addAjaxData('climas', $this->paraformalidadeModel->getClimasParaExibir($_POST['id']) );
	$this->ajax->returnAjax();
    }
    function carregaInstalacoes(){
        $this->ajax->addAjaxData('instalacoes', $this->paraformalidadeModel->getInstalacoesParaExibir($_POST['id']) );
	$this->ajax->returnAjax();
    }
    function carregarParaformalides(){
        $this->ajax->addAjaxData('paraformalidades', $this->paraformalidadeModel->getParaformalidadesParaPaginar($_POST['id']) );
	$this->ajax->returnAjax();
    }
}