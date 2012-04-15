<?php

	class Grupo extends Controller{
		
		function __construct () {
			parent::__construct();
			$this->load->model('GrupoModel', 'grupoModel');
			$this->load->model('EmpresaModel','empresaModel');
			$this->load->model('ProgramaModel', 'programaModel');
		}
		
		function index () {
			$data['empresas'] = $this->empresaModel->getEmpresasCombo();
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);			
			$this->load->view('grupoFiltroView', $data);
		}
		
		function novo () {
			$data['empresas'] = $this->empresaModel->getEmpresasCombo();
			$data['programas'] = $this->programaModel->getProgramasCombo();
			$this->load->view('grupoView', $data);
		}
		
		function salvar(){
			if($_POST['txtCodigo'] == ''){				
				$ret = $this->grupoModel->incluirGrupo($_POST);
			}else{
				$ret = $this->grupoModel->alterarGrupo($_POST);
			}
			
			if($ret){
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			}else{
				$this->ajax->addAjaxData('error', $this->grupoModel->validate->getError());
			}
			$this->ajax->returnAjax();		
		}
		
		function excluir(){
			$isSucess = $this->grupoModel->excluirGrupo($_POST['id']);			
			
			if($isSucess){
				$this->ajax->addAjaxData('sucess', 'true');
			}else{
				$this->ajax->addAjaxData('sucess', 'false');
			}
			$this->ajax->returnAjax();
		}
		
		function buscar(){
			$data['grupo'] = $this->grupoModel->getGrupo($this->uri->segment(4));
			$data['empresas'] = $this->empresaModel->getEmpresasCombo();
			$data['programas'] = $this->programaModel->getProgramasCombo();
			$this->load->view('gerenciador/grupoView', $data);
		}
		
		function buscarProgramaPai() {
			$this->ajax->addAjaxData('programaPai', $this->grupoModel->getProgramaGrupo($_POST['id']));
			$this->ajax->returnAjax();
		}
		
		function buscarPrograma(){
			$this->ajax->addAjaxData('programa', $this->grupoModel->getProgramaGrupo($_POST['id']));
			$this->ajax->returnAjax();
		}
		
		function salvarProgramaPai() {
			if($_POST['txtIdProgramaGrupoPai'] == ''){
				$ret = $this->grupoModel->incluirProgramaPai($_POST, 0);				
			}else{
				$ret = $this->grupoModel->alterarProgramaPai($_POST);
			}
			
			if($ret){
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			}else{
				$this->ajax->addAjaxData('error', $this->grupoModel->validate->getError());
			}
			$this->ajax->returnAjax();
		}
		
		function salvarPrograma(){
			if($_POST['txtIdProgramaGrupo'] == ''){
				$ret = $this->grupoModel->incluirPrograma($_POST, $_POST['txtIdGrupo'], $_POST['txtIdPai']);
			}else{
				$ret = $this->grupoModel->alterarPrograma($_POST, $_POST['txtIdGrupo'], $_POST['txtIdPai']);
			}
			
			if($ret){
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			}else{
				$this->ajax->addAjaxData('error', $this->grupoModel->validate->getError());
			}
			$this->ajax->returnAjax();
		}
		
		function alterarProgramasPai() {					
			$isSucess = $this->grupoModel->alterarProgramas($this->uri->segment(4), 0, $_POST['ids'], $_POST['idProgramas']);			
			if($isSucess){
				$this->ajax->addAjaxData('sucess', 'true');
			}else{
				$this->ajax->addAjaxData('sucess', 'false');
			}			
			$this->ajax->returnAjax();
		}
		
		function alterarProgramas(){
			$isSucess = $this->grupoModel->alterarProgramas($this->uri->segment(4), $this->uri->segment(5), $_POST['ids'], $_POST['idProgramas']);			
			if($isSucess){
				$this->ajax->addAjaxData('sucess', 'true');
			}else{
				$this->ajax->addAjaxData('sucess', 'false');
			}
			$this->ajax->returnAjax();
		}				
		
		function excluirProgramaPai(){
			$isSucess = $this->grupoModel->excluirProgramaPai($this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6));
			
			if($isSucess){
				$this->ajax->addAjaxData('sucess', 'true');
			}else{
				$this->ajax->addAjaxData('sucess', 'false');	
			}
			$this->ajax->returnAjax();
		}
		
		function excluirPrograma(){
			$isSucess = $this->grupoModel->excluirPrograma($this->uri->segment(4));
			
			if($isSucess){
				$this->ajax->addAjaxData('sucess', 'true');
			}else{
				$this->ajax->addAjaxData('sucess', 'false');
			}
			$this->ajax->returnAjax();
		}
		
		function listaProgramas(){
			if($this->uri->segment(4) != ''){
				if($_GET['pai'] != ''){
					$this->ajax->returnGrid($this->grupoModel->getGrupoProgramas($this->uri->segment(4), $_GET['pai']));
				}
			}else{
				if($_GET['pai'] != ''){
					$this->ajax->returnGrid($this->grupoModel->getGrupoProgramas($_GET['idGrupo'], $_GET['pai']));
				}
			}
		}
		
		function listaProgramasPai(){
			if($this->uri->segment(4) != ''){
				$this->ajax->returnGrid($this->grupoModel->getGrupoProgramas($this->uri->segment(4), 0));
			}else{
				if($_GET['idGrupo'] != ''){
					$this->ajax->returnGrid($this->grupoModel->getGrupoProgramas($_GET['idGrupo'], 0));	
				}
			}
		}
		
		function listaGrupos() {
			$this->ajax->returnGrid($this->grupoModel->getGrupos($_GET['start'], $_GET['limit'], @$_GET['empresa_id'], @$_GET['nome'], @$_GET['data']));
		}
		
	}