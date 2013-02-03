<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EspacoLocalizacoes extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/EspacoLocalizacoesModel', 'espacoLocalizacoesModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/espacoLocalizacoesFiltroView', $data);
		}
		
		function listaEspacoLocalizacoes(){
			$this->espacoLocalizacoesModel->getEspacoLocalizacoes($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/espacoLocalizacoesView', $data);
		}

		function editar($espacoNumeroId){
			$data['espaco_localizacoes'] = $this->espacoLocalizacoesModel->getEspacoNumero($espacoNumeroId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['espaco_localizacoes']->descricao;
			$this->load->view('cadastrosBasicos/espacoLocalizacoesView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->espacoLocalizacoesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtEspacoLocalizacoesId'])) {
                        $ret = $this->espacoLocalizacoesModel->inserir($_POST);
                    } else {
                        $ret = $this->espacoLocalizacoesModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('espaco_localizacoes', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->espacoLocalizacoesModel->validate->existsErrors()) {
                            $this->espacoLocalizacoesModel->validate->addError("txtEspacoLocalizacoesId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->espacoLocalizacoesModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	