<?php

class Participacao extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('cadastrosBasicos/ParticipacaoModel', 'participacaoModel');
    }
    
    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $this->load->view('cadastrosBasicos/participacaoFiltroView', $data);
    }

    function listaParticipacoes(){
            $this->participacaoModel->getParticipacoes($_GET);
    }

    public function salvar() {
        if (empty($_POST['txtParticipacaoId'])) {
            $ret = $this->participacaoModel->inserir($_POST);
        } else {
            $ret = $this->participacaoModel->alterar($_POST);
        }
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('participacao', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->participacaoModel->validate->existsErrors()) {
                $this->participacaoModel->validate->addError("txtParticipacaoId", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->participacaoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }
    
    function novo() {
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
	$this->load->view('cadastrosBasicos/participacaoView', @$data);
		
    }
    
    function editar($participacaoId){
	$data['participacao'] = $this->participacaoModel->getPartitipacao($participacaoId);
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['participacao']->nome;
	$this->load->view('cadastrosBasicos/participacaoView', $data);
    }
    
    function excluir(){
	$isSUccess = $this->participacaoModel->excluir($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
}
