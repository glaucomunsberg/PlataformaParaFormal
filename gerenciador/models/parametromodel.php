<?php
	
	class ParametroModel extends Model{
		
		function __construct(){
			parent::__construct();
		}
		
		function inserir($parametro){
			$retErro = $this->validaParametro($parametro);
			if($retErro){
				return false;
			}
			
			$this->db->set('nome', $parametro['txtNome']);
			$this->db->set('descricao', $parametro['txtDescricao']);
			$this->db->set('valor', $parametro['txtValor']);
			$this->db->set('dt_cadastro', 'now()', false);
			$this->db->insert('parametros');

			$this->ajax->addAjaxData('parametro', $this->getParametro($this->db->insert_id()));
			return true;
		}

		function alterar($parametro){
			$retErro = $this->validaParametro($parametro);
			if($retErro)
				return false;
			
			$this->db->set('nome', $parametro['txtNome']);
			$this->db->set('descricao', $parametro['txtDescricao']);
			$this->db->set('valor', $parametro['txtValor']);
			$this->db->set('dt_cadastro', 'now()', false);
			$this->db->where('id', $parametro['txtCodigo']);
			$this->db->update('parametros');
			
			$this->ajax->addAjaxData('parametro', $this->getParametro($parametro['txtCodigo']));			
			return true;
		}
		
		function excluir($id){
			$this->db->trans_begin();
			
				$aParametros = explode(',', $id);
				$aExcluirParametros = array();
				for($i = 0; $i < count($aParametros); $i++)
					if($aParametros[$i] != 'undefined')
						array_push($aExcluirParametros, $aParametros[$i]);
			
				$this->db->where_in('id', $aExcluirParametros);
				$this->db->delete('parametros');
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}

			$this->db->trans_commit();
			return true;
		}

		function getParametro($id){
			$this->db->select('id, nome, descricao, valor, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->where('id', $id);
			return $this->db->get('parametros')->row();
		}

		function getParametroNome($nome){
			$this->db->select('valor');
			$this->db->where('nome', $nome);
			$query = $this->db->get('parametros')->row();
			return @$query->valor;
		}

		function getParametros($parametros){
			$this->db->select('count(*) as quantidade');			
			$total = $this->db->get('parametros')->row();
			
			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);
						
			$this->db->select('id, nome, descricao, valor, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->orderby('nome', 'asc');
			$result = $this->db->get('parametros', $paramsJqGrid->limit, $paramsJqGrid->start);

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function validaParametro($parametro){
			$this->validate->setData($parametro);
			$this->validate->validateField('txtNome', array('required'), lang('parametroNomeRequerido'));
			$this->validate->validateField('txtValor', array('required'), lang('parametroValorRequerido'));
			return $this->validate->existsErrors();
		}
		
	}
	
?>