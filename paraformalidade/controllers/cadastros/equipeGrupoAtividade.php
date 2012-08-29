<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipeGrupoAtividade extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
                        $this->load->model('../../gerenciador/models/PessoaModel', 'pessoaModel');
                        $this->load->model('cadastros/GrupoAtividadeModel', 'grupoAtividadeModel');
                        $this->load->model('cadastros/EquipeGrupoAtividadeModel', 'equipeGrupoAtividadeModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastros/equipeGrupoAtividadeFiltroView', $data);
		}
		
		function listaEquipeGruposAtividades(){
			$this->equipeGrupoAtividadeModel->getEquipeGruposAtividades($_GET);
		}
                
                function listaGruposAtividades(){
			$this->grupoAtividadeModel->getGruposAtividades($_GET);
		}
                
		
		function editar($grupoAtividadeId){
                        $data['grupo_atividade_equipe_pessoa'] = $this->equipeGrupoAtividadeModel->getEquipeGrupoAtividade($grupoAtividadeId);
			$this->ajax->addAjaxData('grupo_ativiade_equipe', $this->equipeGrupoAtividadeModel->getEquipeGrupoAtividade($grupoAtividadeId) );
                        $this->ajax->addAjaxData('pessoa', $this->pessoaModel->getPessoa( $data['grupo_atividade_equipe_pessoa']->pessoa_id) );
                        $this->ajax->returnAjax();
		}

		function equipe($grupoAtividadeID){
                        $data['cmbResponsavel'] = array (array ("S", lang('equipeGrupoAtividadeSim')), array ("N", lang('equipeGrupoAtividadeNao')));
			$data['grupo_atividade'] = $this->grupoAtividadeModel->getGrupoAtividade($grupoAtividadeID);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar Equipe / ';
			$this->load->view('cadastros/equipeGrupoAtividadeView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->equipeGrupoAtividadeModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtGrupoPessoaId'])) {
                        $ret = $this->equipeGrupoAtividadeModel->inserir($_POST);
                    } else {
                        $ret = $this->equipeGrupoAtividadeModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('grupo_atividade', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->equipeGrupoAtividadeModel->validate->existsErrors()) {
                            $this->equipeGrupoAtividadeModel->validate->addError("txtGrupoAtividadeId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->equipeGrupoAtividadeModel->validate->getError());
                    }
                    
                    $this->ajax->returnAjax();
		}
                
                function buscarParticipante(){
                    $this->ajax->addAjaxCombo(
                            $this->equipeGrupoAtividadeModel->getParticipanteByNome($_GET['q'])
                    );
                    $this->ajax->returnAjax();
                }
		
	}	