<?php

class Colaboradores extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastros/ColaboradoresModel', 'colaboradoresModel');
        $this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
        $this->load->model('../../gerenciador/models/PessoaTipoModel', 'pessoaTipoModel');
    }
    
    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $data['sexo'] = array (array ("M", lang('colaboradorSexoMasculino')), array ("F", lang('colaboradorSexoFeminino')));
        $this->load->view('cadastros/colaboradoresFiltroView', $data);
    }

    function listaColaboradores(){
        $this->colaboradoresModel->getColaboradores($_GET);
    }

    public function salvar() {
        if (empty($_POST['txtColaboradorId'])) {
            $ret = $this->colaboradoresModel->inserir($_POST);
        } else {
            $ret = $this->colaboradoresModel->alterar($_POST);
        }
        if ($ret !== FALSE) {
            $this->ajax->addAjaxData('colaborador', $ret);
            $this->ajax->ajaxMessage('success', lang('registroGravado'));
        } else {
            if (!$this->colaboradoresModel->validate->existsErrors()) {
                $this->colaboradoresModel->validate->addError("txtColaboradorId", lang('registroNaoGravado'));
            }
            $this->ajax->addAjaxData('error', $this->colaboradoresModel->validate->getError());
        }
        $this->ajax->returnAjax();
    }
    
    function novo() {
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $data['tipo_pessoa'] = $this->pessoaTipoModel->getPessoasTiposCombo();
        $data['sexo'] = array (array ("M", lang('colaboradorSexoMasculino')), array ("F", lang('colaboradorSexoFeminino')));
	$this->load->view('cadastros/colaboradoresView', @$data);
		
    }
    
    function editar($colabordorId){
	$data['colaborador'] = $this->colaboradoresModel->getColaborador($colabordorId);
        $data['tipo_pessoa'] = $this->pessoaTipoModel->getPessoasTiposCombo();
        $data['sexo'] = array (array ("M", lang('colaboradorSexoMasculino')), array ("F", lang('colaboradorSexoFeminino')));
        $data['colaboradorCidade'] = $this->cidadeModel->getCidadeById( $data['colaborador']->cidade_id );
	$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['colaborador']->nome;
	$this->load->view('cadastros/colaboradoresView', $data);
    }
    
    function excluir(){
	$isSUccess = $this->colaboradoresModel->excluir($_POST['id']);
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
    
    function buscarColaborador(){
        $this->ajax->addAjaxCombo(
                $this->colaboradoresModel->getColaboradorByNome($_GET['q'])
        );
        $this->ajax->returnAjax();
    }
}
