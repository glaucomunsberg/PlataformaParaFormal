<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ElementoSituacaoModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getElementosSituacoesCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('tipos_elementos_situacoes')->result_array();
		}

		function inserir($locais){
			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('tipos_elementos_situacoes');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_elementos_situacoes', $this->getElementoSituacao($this->db->insert_id('tipos_elementos_situacoes', 'id')));
			return true;
		}

		function alterar($locais){

			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);		
			$this->db->where('id', $locais['txtElementoSituacaoId']);
			$this->db->update('tipos_elementos_situacoes');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_elementos_situacoes', $this->getElementoSituacao($locais['txtElementoSituacaoId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aElementosSituacoes = explode(',', $id);
				$aExcluirElementosSituacoes = array();
				for($i = 0; $i < count($aElementosSituacoes); $i++)
					if($aElementosSituacoes[$i] != 'undefined')
						array_push($aExcluirElementosSituacoes, $aElementosSituacoes[$i]);

				$this->db->where_in('id', $aExcluirElementosSituacoes);
				$this->db->delete('tipos_elementos_situacoes');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getElementoSituacao($elementoSituacaoId){
			$this->db->where('id', $elementoSituacaoId);
			return $this->db->get('tipos_elementos_situacoes')->row();
		}
		
		function getElementosSituacoes($parametros){
			$this->db->select('count(*) as quantidade');
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$total = $this->db->get('tipos_elementos_situacoes')->row();

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);

			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$result = $this->db->get('tipos_elementos_situacoes', $paramsJqGrid->limit, $paramsJqGrid->start);

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function validaElementoSituacao($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtElementoSituacaoId', array('required'), lang('elementosSituacoesDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}