<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class SentidosModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getSentidosCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.sentidos')->result_array();
		}

	}