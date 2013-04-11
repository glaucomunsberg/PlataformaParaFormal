<?php

class Paraformalidade extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('../../gerenciador/models/PessoaModel', 'pessoaModel');
        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
        $this->load->model('../../util/models/UploadModel', 'uploadModel');
        $this->load->model('cadastros/ParaformalidadeModel', 'paraformalidadeModel');
        $this->load->model('cadastros/CenasModel', 'cenasModel');
        $this->load->model('cadastros/GruposAtividadesModel', 'gruposAtividadesModel');
        $this->load->model('cadastrosBasicos/AtividadesRegistradaModel', 'atividadesRegistradaModel');
        $this->load->model('cadastrosBasicos/TurnosOcorrenciaModel', 'turnosOcorrenciaModel');
        $this->load->model('cadastrosBasicos/CondicionantesAmbientalModel', 'condicionantesAmbientalModel');
        $this->load->model('cadastrosBasicos/QuantidadesRegistradaModel', 'quantidadesRegistradaModel');
        $this->load->model('cadastrosBasicos/EspacoLocalizacoesModel', 'espacaoLocalizacoesModel');
        $this->load->model('cadastrosBasicos/CorpoPosicoesModel', 'corpoPosicoesModel');
        $this->load->model('cadastrosBasicos/CorpoNumerosModel', 'corpoNumerosModel');
        $this->load->model('cadastrosBasicos/EquipamentoMobilidadesModel', 'equipamentoMobilidadesModel');
        $this->load->model('cadastrosBasicos/EquipamentoPortesModel', 'equipamentoPortesModel');
        $this->load->model('cadastrosBasicos/EquipamentoInstalacoesModel', 'equipamentoInstalacoesModel');
        $this->load->model('cadastrosBasicos/SentidosModel', 'sentidosModel');
        $this->load->model('cadastrosBasicos/ClimasModel', 'climasModel');
    }
    
    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('cadastros/paraformalidadeFiltroView', $data);
    }

    function listaParaformalidades(){
        $this->paraformalidadeModel->getParaformalidades($_GET);
    }

    public function salvar() {
        if (empty($_POST['txtParaformalidadeId'])) {
            $ret = $this->paraformalidadeModel->inserir($_POST);
        } else {
            $ret = $this->paraformalidadeModel->alterar($_POST);
        }
        if ($ret !== FALSE) {
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->paraformalidadeModel->validate->existsErrors()) {
                $this->paraformalidadeModel->validate->addError("txtParaformalidadeId", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->paraformalidadeModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }
    
    function paraformalidadesDaCena($cenaId) {
        $data['cena'] = $this->cenasModel->getCena($cenaId);
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / '.lang('paraformalidadePorCena').' / '.$data['cena']->descricao;
        $data['grupo_atividade'] = $this->gruposAtividadesModel->getGrupoAtividade($data['cena']->grupo_atividade_id);
        $data['atividades_registradas'] = $this->atividadesRegistradaModel->getAtividadesRegistradasCombo();
        $data['turnos_ocorrencia'] = $this->turnosOcorrenciaModel->getTurnosOcorrenciaCombo();
        $data['condicionantes_ambientais'] = $this->condicionantesAmbientalModel->getCondicionantesAmbientalCombo();
        $data['quantidades_registradas'] = $this->quantidadesRegistradaModel->getQuantidadesRegistradasCombo();
        $data['espacos_localizacoes'] = $this->espacaoLocalizacoesModel->getEspacoLocalizacoesCombo();
        $data['corpo_posicoes'] = $this->corpoPosicoesModel->getCorpoPosicoesCombo();
        $data['corpos_numeros'] = $this->corpoNumerosModel->getCorpoNumerosCombo();
        $data['equipamento_portes'] = $this->equipamentoPortesModel->getEquipamentoPortesCombo();
        $data['equipamento_mobilidades'] = $this->equipamentoMobilidadesModel->getEquipamentoMobilidadesCombo();
        $data['equipamento_instalacoes'] = $this->equipamentoInstalacoesModel->getEquipamentoInstalacoesCombo();
        $data['sentidos'] = $this->sentidosModel->getSentidosCombo();
        $data['climas'] = $this->climasModel->getClimasCombo();
	$this->load->view('cadastros/paraformalidadeView', $data);	
    }
    
    function editar($paraformalidadeId){
        $this->ajax->addAjaxData('paraformalidade', $this->paraformalidadeModel->getParaformalidadeComDados($paraformalidadeId) );
	$this->ajax->returnAjax();
    }
    
    
    function excluir(){
	$isSUccess = $this->paraformalidadeModel->excluir($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function buscarCidade(){
        $this->ajax->addAjaxCombo(
                $this->cidadeModel->getCidadeByNome($_GET['q'])
        );
        $this->ajax->returnAjax();
    }
    
    function listaColaboradores(){
        $this->paraformalidadeModel->getColaboradores($_GET);
    }
    
    function inserirColaborador(){
	$isSUccess = $this->paraformalidadeModel->inserirColaborador($_POST);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    function excluirColaborador(){
	$isSUccess = $this->paraformalidadeModel->excluirColaborador($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function listaSentidos(){
        $this->paraformalidadeModel->getSentidos($_GET);
    }
    
    function inserirSentido(){
	$isSUccess = $this->paraformalidadeModel->inserirSentido($_POST);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    function excluirSentido(){
	$isSUccess = $this->paraformalidadeModel->excluirSentido($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function listaCondicionantes(){
        $this->paraformalidadeModel->getCondicionantes($_GET);
    }
    
    function inserirCondicionante(){
	$isSUccess = $this->paraformalidadeModel->inserirCondicionante($_POST);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    function excluirCondicionante(){
	$isSUccess = $this->paraformalidadeModel->excluirCondicionante($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function listaInstalacoes(){
        $this->paraformalidadeModel->getInstalacoes($_GET);
    }
    
    function inserirInstalacao(){
	$isSUccess = $this->paraformalidadeModel->inserirInstalacao($_POST);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    function excluirInstalacao(){
	$isSUccess = $this->paraformalidadeModel->excluirInstalacao($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function listaClimas(){
        $this->paraformalidadeModel->getClimas($_GET);
    }
    
    function inserirClima(){
	$isSUccess = $this->paraformalidadeModel->inserirClima($_POST);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    function excluirClima(){
	$isSUccess = $this->paraformalidadeModel->excluirClima($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
}
