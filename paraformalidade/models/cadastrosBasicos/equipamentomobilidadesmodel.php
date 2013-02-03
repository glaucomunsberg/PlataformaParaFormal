<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipamentoMobilidadesModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getEquipamentoMobilidadesCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.equipamento_mobilidades')->result_array();
		}

		function inserir($equipamentoPorte){
			$this->db->trans_start();
			$this->db->set('descricao', $equipamentoPorte['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.equipamento_mobilidades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('equipamento_mobilidades', $this->getEquipamentoPorte($this->db->insert_id('paraformal.equipamento_mobilidades', 'id')));
			return true;
		}

		function alterar($equipamentoMobilidades){

			$this->db->trans_start();
			$this->db->set('descricao', $equipamentoMobilidades['txtDescricao']);		
			$this->db->where('id', $equipamentoMobilidades['txtEquipamentoMobilidadesId']);
			$this->db->update('paraformal.equipamento_mobilidades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('equipamento_mobilidades', $this->getEquipamentoPorte($equipamentoMobilidades['txtEquipamentoMobilidadesId']));
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
				$this->db->delete('paraformal.equipamento_mobilidades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getEquipamentoPorte($equipamentoPorteId){
			$this->db->where('id', $equipamentoPorteId);
			return $this->db->get('paraformal.equipamento_mobilidades')->row();
		}
		
		function getEquipamentoMobilidades($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.equipamento_mobilidades');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtEquipamentoMobilidadesId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}