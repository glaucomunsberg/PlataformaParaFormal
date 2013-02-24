<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class Cenas extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastros/CenasModel', 'cenasModel');
		}
		
		function listaCenas(){
			$this->cenasModel->getCenas($_GET);
		}
                
                function cena($id){
                    $this->ajax->addAjaxData('cena', $this->cenasModel->getCena($id));
                    $this->ajax->returnAjax();
                }
		function excluir(){
			$isSUccess = $this->cenasModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
                        if (empty($_POST['txtCenaId'])) {
                                $ret = $this->cenasModel->inserir($_POST);
                            } else {
                                $ret = $this->cenasModel->alterar($_POST);
                            }
                            if ($ret !== FALSE) {
                                $this->ajax->addAjaxData('cena', $ret);
                                $this->ajax->ajaxMessage('success', lang('registroGravado'));
                            } else {
                                if (!$this->cenasModel->validate->existsErrors()) {
                                    $this->cenasModel->validate->addError("txtCenaId", lang('registroNaoGravado'));
                                }
                                $this->ajax->addAjaxData('error', $this->cenasModel->validate->getError());
                            }

                            $this->ajax->returnAjax();
                        }
		
	}	