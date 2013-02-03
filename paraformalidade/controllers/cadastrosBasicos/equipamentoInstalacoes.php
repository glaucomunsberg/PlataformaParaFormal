<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipamentoInstalacoes extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/EquipamentoInstalacoesModel', 'equipamentoInstalacoesModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/equipamentoInstalacoesFiltroView', $data);
		}
		
		function listaEquipamentoInstalacoes(){
			$this->equipamentoInstalacoesModel->getEquipamentoInstalacoes($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/equipamentoInstalacoesView', $data);
		}

		function editar($equipamentoInstalacaoId){
			$data['equipamento_instalacoes'] = $this->equipamentoInstalacoesModel->getEquipamentoInstalacao($equipamentoInstalacaoId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['equipamento_instalacoes']->descricao;
			$this->load->view('cadastrosBasicos/equipamentoInstalacoesView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->equipamentoInstalacoesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtEquipamentoInstalacoesId'])) {
                        $ret = $this->equipamentoInstalacoesModel->inserir($_POST);
                    } else {
                        $ret = $this->equipamentoInstalacoesModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('equipamento_instalacoes', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->equipamentoInstalacoesModel->validate->existsErrors()) {
                            $this->equipamentoInstalacoesModel->validate->addError("txtEquipamentoInstalacoesId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->equipamentoInstalacoesModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	