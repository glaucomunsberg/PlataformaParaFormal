<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class TurnosOcorrenciaModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getTurnosOcorrenciaCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.turnos_ocorrencia')->result_array();
		}

		function inserir($turnosNumero){
			$this->db->trans_start();
			$this->db->set('descricao', $turnosNumero['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.turnos_ocorrencia');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('turnos_ocorrencia', $this->getTurnosNumero($this->db->insert_id('paraformal.turnos_ocorrencia', 'id')));
			return true;
		}

		function alterar($turnosOcorrencia){

			$this->db->trans_start();
			$this->db->set('descricao', $turnosOcorrencia['txtDescricao']);		
			$this->db->where('id', $turnosOcorrencia['txtTurnoOcorrenciaId']);
			$this->db->update('paraformal.turnos_ocorrencia');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('turnos_ocorrencia', $this->getTurnosNumero($turnosOcorrencia['txtTurnoOcorrenciaId']));
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
				$this->db->delete('paraformal.turnos_ocorrencia');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getTurnosNumero($turnosNumeroId){
			$this->db->where('id', $turnosNumeroId);
			return $this->db->get('paraformal.turnos_ocorrencia')->row();
		}
		
		function getTurnosOcorrencia($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.turnos_ocorrencia');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtTurnoOcorrenciaId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}