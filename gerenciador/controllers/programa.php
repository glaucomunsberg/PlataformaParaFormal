<?php

	class Programa extends Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model('ProgramaModel','programaModel');
		}

		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('programaFiltroView', $data);
		}

		function listaProgramas(){
			$this->ajax->returnJqGrid($this->programaModel->getProgramas($_GET));
		}

		function listaParametrosProgramas(){
			$this->ajax->returnJqGrid($this->programaModel->getParametrosProgramas($_GET));
		}

		function salvar(){
			if($_POST['txtCodigo'] ==  '')
				$ret = $this->programaModel->inserir($_POST);
			else
				$ret = $this->programaModel->alterar($_POST);			

			if($ret)
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->programaModel->validate->getError());

			$this->ajax->returnAjax();
		}
		
		function novo() {
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';
			$this->load->view('programaView', $data);
		}
		
		function editar($programa){			
			$data['programa'] = $this->programaModel->getPrograma($programa);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.$data['programa']->nome;
			$this->load->view('programaView', $data);
		}

		function excluir() {
			$isSUccess = $this->programaModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}

		function excluirParametrosProgramas(){
			$isSUccess = $this->programaModel->excluirProgramaParametros($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}

		function salvarProgramaParametro(){			
			$ret = $this->programaModel->salvarProgramaParametro($_POST);			

			if($ret)
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->programaModel->validate->getError());

			$this->ajax->returnAjax();
		}
		
		function editarProgramaParametro($programaParametroId){			
			$this->ajax->addAjaxData('programa_parametro', $this->programaModel->getProgramaParametro($programaParametroId));			
			$this->ajax->returnAjax();
		}
		
		function imprimir () {			
			$this->jasperreportgenerate->pdf_create('rptProgramas.jasper', 'relatorio_programas');
		}

	}