<?php

class Cidade extends Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('../../paraformalidade/models/cadastros/gruposAtividadesModel', 'grupoAtividadeModel');
        $this->load->model('../../paraformalidade/models/cadastros/paraformalidadeModel', 'paraformalidadeModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/TurnosOcorrenciaModel', 'turnosOcorrenciaModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/AtividadesRegistradaModel', 'atividadesRegistradaModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/QuantidadesRegistradaModel', 'quantidadesRegistradaModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/EspacoLocalizacoesModel', 'espacaoLocalizacoesModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/CorpoPosicoesModel', 'corpoPosicoesModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/CorpoNumerosModel', 'corpoNumerosModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/EquipamentoMobilidadesModel', 'equipamentoMobilidadesModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/EquipamentoPortesModel', 'equipamentoPortesModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/SentidosModel', 'sentidosModel');
        $this->load->model('../../paraformalidade/models/cadastrosBasicos/EquipamentoInstalacoesModel', 'equipamentoInstalacoesModel');
    }
    
    function index(){
        $data['cidades_atividades'] = $this->grupoAtividadeModel->getGrupoAtividadeCombo();
        $data['turnos_ocorrencia'] = $this->turnosOcorrenciaModel->getTurnosOcorrenciaCombo();
        $data['atividades_registrada'] = $this->atividadesRegistradaModel->getAtividadesRegistradasCombo();
        $data['quantidades_registrada'] = $this->quantidadesRegistradaModel->getQuantidadesRegistradasCombo();
        $data['espacos_localizacao'] = $this->espacaoLocalizacoesModel->getEspacoLocalizacoesCombo();
        $data['corpos_posicao'] = $this->corpoPosicoesModel->getCorpoPosicoesCombo();
        $data['corpos_numero'] = $this->corpoNumerosModel->getCorpoNumerosCombo();
        $data['equipamentos_mobilidade'] = $this->equipamentoMobilidadesModel->getEquipamentoMobilidadesCombo();
        $data['equipamentos_instalacao'] = $this->equipamentoInstalacoesModel->getEquipamentoInstalacoesCombo();
        $data['equipamentos_porte'] = $this->equipamentoPortesModel->getEquipamentoPortesCombo();
        $data['sentidos'] = $this->sentidosModel->getSentidosCombo();
        $data['cidade_id'] = @$_GET['id'];
        if(empty($_GET['id'])){
            $data['grupo_atividade'] = array();
            $data['paraformalidadesToMaps'] = array();
            
            $this->load->view('paraformalidadesView', $data);
        }else{
            $data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($_GET['id']);
            $data['paraformalidadesToMaps'] = $this->paraformalidadeModel->getParaformalidadeToMaps($_GET['id']);
            $this->load->view('paraformalidadesView', $data);
        }
        
    }
    
    function exibir($GrupoAtividadeId){
        $data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($_GET['cidade_id']);
        $data['paraformalidadesToMaps'] = $this->paraformalidadeModel->getParaformalidadeToMaps($_GET['cidade_id']);
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
    
    function carregarParaformalidesToDiscovery(){
        $positions = $this->paraformalidadeModel->getParaformalidadeToMapsDiscovery($_POST);
        $array = array();
        if (count($positions) > 0 && !empty($positions)){
            foreach ($positions as $arrayObject) {
             $lat ='';
             $lng='';
             $id = '';
             foreach($arrayObject as $theObject =>$value){

                     if($theObject == 'geocode_lat'){
                         $lat = $value;
                     }else if($theObject == 'geocode_lng'){
                        $lng = $value;
                     }else if($theObject == 'id'){
                         $id = $value;
                     }
                }
                array_push($array,array($lat,$lng,$id));
            }
        }
        $this->ajax->addAjaxData('paraformalidades', $array );
	$this->ajax->returnAjax();
    }
}