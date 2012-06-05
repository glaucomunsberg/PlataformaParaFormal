<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class GrupoAtividade extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastros/GrupoAtividadeModel', 'grupoAtividadeModel');
                        $this->load->model('../../gerenciador/models/CidadeModel', 'cidadeModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastros/grupoAtividadeFiltroView', $data);
		}
		
		function listaGruposAtividades(){
			$this->grupoAtividadeModel->getGruposAtividades($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastros/grupoAtividadeView', $data);
		}

		function editar($grupoAtividadeID){
			$data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($grupoAtividadeID);
                        $data['grupo_atividade_cidade'] = $this->cidadeModel->getCidadeById( $data['grupo_atividade']->cidade_id );
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['grupo_atividade']->descricao;
			$this->load->view('cadastros/grupoAtividadeView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->grupoAtividadeModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtGrupoAtividadeId'])) {
                        $ret = $this->grupoAtividadeModel->inserir($_POST);
                    } else {
                        $ret = $this->grupoAtividadeModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('grupo_atividade', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->grupoAtividadeModel->validate->existsErrors()) {
                            $this->grupoAtividadeModel->validate->addError("txtGrupoAtividadeId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->grupoAtividadeModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
                function buscarCidade(){
                    $this->ajax->addAjaxCombo(
                            $this->cidadeModel->getCidadeByNome($_GET['q'])
                    );
                    $this->ajax->returnAjax();
                }
		
	}	