<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipamentoInstalacoesModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getEquipamentoInstalacoesCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.equipamento_instalacoes')->result_array();
		}

		function inserir($equipamentoInstalacao){
			$this->db->trans_start();
			$this->db->set('descricao', $equipamentoInstalacao['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.equipamento_instalacoes');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('equipamento_instalacoes', $this->getEquipamentoInstalacao($this->db->insert_id('paraformal.equipamento_instalacoes', 'id')));
			return true;
		}

		function alterar($equipamentoInstalacoes){

			$this->db->trans_start();
			$this->db->set('descricao', $equipamentoInstalacoes['txtDescricao']);		
			$this->db->where('id', $equipamentoInstalacoes['txtEquipamentoInstalacoesId']);
			$this->db->update('paraformal.equipamento_instalacoes');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('equipamento_instalacoes', $this->getEquipamentoInstalacao($equipamentoInstalacoes['txtEquipamentoInstalacoesId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.equipamento_instalacoes');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getEquipamentoInstalacao($equipamentoInstalacaoId){
			$this->db->where('id', $equipamentoInstalacaoId);
			return $this->db->get('paraformal.equipamento_instalacoes')->row();
		}
		
		function getEquipamentoInstalacoes($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.equipamento_instalacoes');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtPonteId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}