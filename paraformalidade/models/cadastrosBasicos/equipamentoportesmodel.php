<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipamentoPortesModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getEquipamentoPortesCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.equipamento_portes')->result_array();
		}

		function inserir($equipamentoPorte){
			$this->db->trans_start();
			$this->db->set('descricao', $equipamentoPorte['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.equipamento_portes');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('equipamento_portes', $this->getEquipamentoPorte($this->db->insert_id('paraformal.equipamento_portes', 'id')));
			return true;
		}

		function alterar($equipamentoPortes){

			$this->db->trans_start();
			$this->db->set('descricao', $equipamentoPortes['txtDescricao']);		
			$this->db->where('id', $equipamentoPortes['txtEquipamentoPortesId']);
			$this->db->update('paraformal.equipamento_portes');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('equipamento_portes', $this->getEquipamentoPorte($equipamentoPortes['txtEquipamentoPortesId']));
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
				$this->db->delete('paraformal.equipamento_portes');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getEquipamentoPorte($equipamentoPorteId){
			$this->db->where('id', $equipamentoPorteId);
			return $this->db->get('paraformal.equipamento_portes')->row();
		}
		
		function getEquipamentoPortes($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.equipamento_portes');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtEquipamentoPortesId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}