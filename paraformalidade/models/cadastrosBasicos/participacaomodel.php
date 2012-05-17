<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ParticipacaoModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getParticipacoesCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('tipos_participacoes')->result_array();
		}

		function inserir($participacoes){
			$this->db->trans_start();
			$this->db->set('descricao', $participacoes['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('tipos_participacoes');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_participacoes', $this->getPartitipacao($this->db->insert_id('tipos_participacoes', 'id')));
			return true;
		}

		function alterar($participacoes){

			$this->db->trans_start();
			$this->db->set('descricao', $participacoes['txtDescricao']);		
			$this->db->where('id', $participacoes['txtParticipacaoId']);
			$this->db->update('tipos_participacoes');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_participacoes', $this->getPartitipacao($participacoes['txtParticipacaoId']));
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
				$this->db->delete('tipos_participacoes');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getPartitipacao($ParticipacaoId){
			$this->db->where('id', $ParticipacaoId);
			return $this->db->get('tipos_participacoes')->row();
		}
		
		function getParticipacoes($parametros){
			$this->db->select('count(*) as quantidade');
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$total = $this->db->get('tipos_participacoes')->row();

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);

			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$result = $this->db->get('tipos_participacoes', $paramsJqGrid->limit, $paramsJqGrid->start);

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function validaParticipacao($participacao){
			$this->validate->setData($participacao);			
				
			$this->validate->validateField('txtParticipacaoId', array('required'), lang('participacaoDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}