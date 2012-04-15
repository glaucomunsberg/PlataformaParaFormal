<?php

	class Empresa extends Controller{
		
		function __construct () {
			parent::__construct();
			$this->load->model('ProgramaModel', 'programaModel');
			$this->load->model('EmpresaModel','empresaModel');
			$this->load->model('PerfilModel', 'perfilModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('empresaFiltroView', $data);
		}
		
		function listaEmpresas () {
			$this->ajax->returnJqGrid($this->empresaModel->getEmpresas($_GET));			
		}
		
		function salvar(){
			if($_POST['txtCodigo'] == '')
				$ret = $this->empresaModel->inserir($_POST);
			else
				$ret = $this->empresaModel->alterar($_POST);			
			
			if($ret)
				$this->ajax->ajaxMessage('sucess', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->empresaModel->validate->getError());

			$this->ajax->returnAjax();
		}

		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';
			$this->load->view('empresaView', $data);
		}

		function buscar($empresa_id){
			$data['empresa'] = $this->empresaModel->getEmpresa($empresa_id);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.$data['empresa']->nome;			
			$this->load->view('empresaView', $data);
		}
		
		function excluir() {
			$isSucess = $this->empresaModel->excluir($_POST['empresas']);
			
			if($isSucess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function listaPerfisEmpresa(){
			$this->ajax->addAjaxData('empresaPerfis', $this->empresaModel->getPerfisEmpresa($_POST['empresaId']));
			$this->ajax->returnAjax();
		}
		
		function listaPerfisEmpresaGrid(){
			$this->ajax->returnJqGrid($this->empresaModel->getPerfisEmpresaGrid($_GET));			
		}		
		
	}