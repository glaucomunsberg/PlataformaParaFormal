<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CondicaoAmbiental extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/CondicaoAmbientalModel', 'condicaoAmbientalModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/condicaoAmbientalFiltroView', $data);
		}
		
		function listaCondicoesAmbientais(){
			$this->condicaoAmbientalModel->getCondicoesAmbientais($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/condicaoAmbientalView', $data);
		}

		function editar($CondicaoAmbientalId){
			$data['condicao_ambiental'] = $this->condicaoAmbientalModel->getCondicaoAmbiental($CondicaoAmbientalId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['condicao_ambiental']->descricao;
			$this->load->view('cadastrosBasicos/condicaoAmbientalView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->condicaoAmbientalModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtCondicaoAmbientalId'])) {
                        $ret = $this->condicaoAmbientalModel->inserir($_POST);
                    } else {
                        $ret = $this->condicaoAmbientalModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('condicao_ambiental', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->condicaoAmbientalModel->validate->existsErrors()) {
                            $this->condicaoAmbientalModel->validate->addError("txtCondicaoAmbientalId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->condicaoAmbientalModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	