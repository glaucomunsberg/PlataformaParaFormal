<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class Local extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/LocalModel', 'localModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/localFiltroView', $data);
		}
		
		function listaLocais(){
			$this->ajax->returnJqGrid($this->localModel->getLocais($_GET));
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/localView', $data);
		}

		function editar($LocalId){
			$data['tipos_locais'] = $this->localModel->getLocal($LocalId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['local']->descricao;
			$this->load->view('cadastrosBasicos/localView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->localModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtLocalId'])) {
                        $ret = $this->localModel->inserir($_POST);
                    } else {
                        $ret = $this->localModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('tipos_locais', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->localModel->validate->existsErrors()) {
                            $this->localModel->validate->addError("txtLocalId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->localModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	