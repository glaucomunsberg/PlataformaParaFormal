<?php

class PessoaTipo extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('PessoaTipoModel', 'pessoaTipoModel');
        $this->load->model('ProgramaModel', 'programaModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($this->uri->segment(1) . '/' . $this->uri->segment(2));
        $this->load->view('pessoaTipoFiltroView', $data);
    }

    function listaPessoasTipos(){
        $this->pessoaTipoModel->getPessoasTipos($_GET);
    }

    public function salvar() {
        if (empty($_POST['txtPessoaTipoId'])) {
            logVar($_POST['txtPessoaTipo'], 'asasas');
            $ret = $this->pessoaTipoModel->inserir($_POST);
        } else {
            logVar($_POST['txtPessoaTipo'], 'asasas');
            $ret = $this->pessoaTipoModel->alterar($_POST);
        }
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('pessoa', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->pessoaTipoModel->validate->existsErrors()) {
                $this->pessoaTipoModel->validate->addError("txtPessoaTipo", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->pessoaTipoModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }
    
    function novo() {
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI'].' / Novo / ');
	$this->load->view('pessoaTipoView', @$data);
		
    }
    
    function editar($pessoaTipo){
	$data['pessoa_tipo'] = $this->pessoaTipoModel->getPessoaTipo($pessoaTipo);
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['pessoa_tipo']->tipo;
	$this->load->view('pessoaTipoView', $data);
    }
    
    function excluir(){
	$isSUccess = $this->pessoaTipoModel->excluir($_POST['id']);
	if($isSUccess)
		$this->ajax->addAjaxData('success', true);
	else
		$this->ajax->addAjaxData('success', false);
	$this->ajax->returnAjax();
    }

}
