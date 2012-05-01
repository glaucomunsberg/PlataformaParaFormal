<?php

class Colaborador extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastrosBasicos/ColaboradorModel', 'colaboradorModel');
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
    }
    
    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $data['sexo'] = array (array ("M", lang('colaboradorSexoMasculino')), array ("F", lang('colaboradorSexoFeminino')));
        $this->load->view('cadastrosBasicos/colaboradorFiltroView', $data);
    }

    function listaColaboradores(){
        $this->colaboradorModel->getColaboradores($_GET);
    }

    public function salvar() {
        if (empty($_POST['txtColaboradorId'])) {
            $ret = $this->colaboradorModel->inserir($_POST);
        } else {
            $ret = $this->colaboradorModel->alterar($_POST);
        }
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('colaborador', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->colaboradorModel->validate->existsErrors()) {
                $this->colaboradorModel->validate->addError("txtColaboradorId", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->colaboradorModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }
    
    function novo() {
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $data['sexo'] = array (array ("M", lang('colaboradorSexoMasculino')), array ("F", lang('colaboradorSexoFeminino')));
	$this->load->view('cadastrosBasicos/colaboradorView', @$data);
		
    }
    
    function editar($colabordorId){
	$data['colaborador'] = $this->colaboradorModel->getColaborador($colabordorId);
        $data['sexo'] = array (array ("M", lang('colaboradorSexoMasculino')), array ("F", lang('colaboradorSexoFeminino')));
        $data['colaboradorCidade'] = $this->cidadeModel->getCidadeById( $data['colaborador']->cidade_id );
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['colaborador']->nome;
	$this->load->view('cadastrosBasicos/colaboradorView', $data);
    }
    
    function excluir(){
	$isSUccess = $this->colaboradorModel->excluir($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }
    
    function buscarCidade(){
        $this->ajax->addAjaxCombo(
                $this->cidadeModel->getCidadeByNome($_GET['q'], 20)
        );
        $this->ajax->returnAjax();
    }
}
