<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CondicionantesAmbiental extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/CondicionantesAmbientalModel', 'condicionantesAmbientalModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/condicionantesAmbientalFiltroView', $data);
		}
		
		function listaCondicionantesAmbientais(){
			$this->condicionantesAmbientalModel->getCondicoesAmbientais($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/condicionantesAmbientalView', $data);
		}

		function editar($CondicaoAmbientalId){
			$data['condicao_ambiental'] = $this->condicionantesAmbientalModel->getCondicionantesAmbiental($CondicaoAmbientalId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['condicao_ambiental']->descricao;
			$this->load->view('cadastrosBasicos/condicionantesAmbientalView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->condicionantesAmbientalModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtCondicaoAmbientalId'])) {
                        $ret = $this->condicionantesAmbientalModel->inserir($_POST);
                    } else {
                        $ret = $this->condicionantesAmbientalModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('condicao_ambiental', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->condicionantesAmbientalModel->validate->existsErrors()) {
                            $this->condicionantesAmbientalModel->validate->addError("txtCondicaoAmbientalId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->condicionantesAmbientalModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	