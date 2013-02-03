<?php

class Escolha extends Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('../../paraformalidade/models/cadastros/gruposAtividadesModel', 'grupoAtividadeModel');
        $this->load->model('../../paraformalidade/models/cadastros/paraformalidadeModel', 'paraformalidadeModel');
    }
    
    function index(){
        $data['cmbCidades'] = $this->grupoAtividadeModel->getGrupoAtividadeCombo();
        $this->load->view('escolhaFiltroView', $data);
    }
    
    function exibir($GrupoAtividadeId){
        $data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($GrupoAtividadeId);
        $data['paraformalidadesToMaps'] = $this->paraformalidadeModel->getParaformalidadeToMaps($GrupoAtividadeId);
        $this->load->view('escolhaView', $data);
    }
    
    function exibirParaformalidade($paraformalidadeId){
        $this->ajax->addAjaxData('paraformalidade', $this->paraformalidadeModel->getParaformalidadeWhitImage($paraformalidadeId) );
	$this->ajax->returnAjax();
    }
}