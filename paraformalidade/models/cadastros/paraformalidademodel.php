<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ParaformalidadeModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getParaformalidadeCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformalidades')->result_array();
		}

		function inserir($paraformalidade){
			$this->db->trans_start();
			$this->db->set('descricao', $paraformalidade['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformalidades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('paraformalidade', $this->getParaformalidade($this->db->insert_id('paraformalidades', 'id')));
			return true;
		}

		function alterar($paraformalidade){

			$this->db->trans_start();
			$this->db->set('descricao', $paraformalidade['txtDescricao']);		
			$this->db->where('id', $paraformalidade['txtParaformalidadeId']);
			$this->db->update('paraformalidades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('paraformalidade', $this->getParaformalidade($paraformalidade['txtParaformalidadeId']));
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
				$this->db->delete('paraformalidades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getParaformalidade($paraformalidadeID){
			$this->db->where('id', $paraformalidadeID);
			return $this->db->get('paraformalidades')->row();
		}
		
		    function getParaformalidades($parametros) {
                        $this->db->select(' ', false);
                        $this->db->from('paraformalidades as p');
                        $this->db->join('cidades as c','p.cidade_id = c.id', 'left');
                        if(@$parametros['txtColaboradorNome'] != null )
                            $this->db->like('p.nome', @$parametros['txtColaboradorNome']);
                        if(@$parametros['cmbColaboradorSexo'] != null )
                            $this->db->where('p.sexo', @$parametros['cmbColaboradorSexo']);
                        if(@$parametros['txtColaboradorEmail'] != null )
                            $this->db->like('p.email', @$parametros['txtColaboradorEmail']);
                        if(@$parametros['txtColaboradorCidadeId'] != null )
                            $this->db->where('p.cidade_id', @$parametros['txtColaboradorCidadeId']);
                        $this->db->where('p.pessoa_tipo_id = cast(fnc_get_parametro(\'PESSOA_TIPO_COLABORADOR\') as int)');
                        $this->db->sendToGrid();
                }

		function validaParaformalidade($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('ParaformalidadeDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}