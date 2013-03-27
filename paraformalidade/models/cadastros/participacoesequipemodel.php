<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ParticipacoesEquipemodel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getParticipacoesEquipeCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.participacoes_equipe')->result_array();
		}

	}