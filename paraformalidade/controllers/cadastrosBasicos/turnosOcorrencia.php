<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class TurnosOcorrencia extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/TurnosOcorrenciaModel', 'turnosOcorrenciaModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/turnosOcorrenciaFiltroView', $data);
		}
		
		function listaTurnosOcorrencia(){
			$this->turnosOcorrenciaModel->getTurnosOcorrencia($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/turnosOcorrenciaView', $data);
		}

		function editar($turnosNumeroId){
			$data['turnos_ocorrencia'] = $this->turnosOcorrenciaModel->getTurnosNumero($turnosNumeroId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['turnos_ocorrencia']->descricao;
			$this->load->view('cadastrosBasicos/turnosOcorrenciaView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->turnosOcorrenciaModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtTurnoOcorrenciaId'])) {
                        $ret = $this->turnosOcorrenciaModel->inserir($_POST);
                    } else {
                        $ret = $this->turnosOcorrenciaModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('turnos_ocorrencia', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->turnosOcorrenciaModel->validate->existsErrors()) {
                            $this->turnosOcorrenciaModel->validate->addError("txtTurnoOcorrenciaId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->turnosOcorrenciaModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	