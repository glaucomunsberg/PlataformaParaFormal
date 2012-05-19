<?php
/**
 * @package cgic
 * @subpackage bolsista
 */
	class RegistroAtividadeModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function inserir($registroAtividade){
			$retErro = $this->validaAtividade($registroAtividade);
			if($retErro)
				return false;

			$this->db->trans_start();
			$this->db->set('entrada_saida', $registroAtividade['cmbEntradaSaida']);
			$this->db->set('pessoa_id', $registroAtividade['txtPessoaId']);
			$this->db->set('atividade', $registroAtividade['txtAtividade']);
			$this->db->set('remote_addr',$_SERVER['REMOTE_ADDR']);
			//$this->db->set('x_forward',$_SERVER['HTTP_X_FORWARDED_FOR']);

			$this->db->insert('equipe_atividades_registros');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('cmbEntradaSaida', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('atividade', $this->getBolsista($this->db->insert_id('bolsistas_registros', 'id')));
			return true;
		}


		function getAtividadesRegistros($parametros, $pessoaId, $noPagination=false){
			$this->db->select('br.id, br.entrada_saida, br.atividade, br.dt_cadastro');
			$this->db->from('equipe_atividades_registros as br');
			$this->db->join('pessoas as p', 'br.pessoa_id = p.id');
			$this->db->where('pessoa_id',$pessoaId);
			if (@$parametros['dt_inicio'] && $parametros['dt_fim'] != '') {
				$this->db->where('date(br.dt_cadastro) between to_date(\''. $parametros['dt_inicio'] .'\', \'dd/mm/yyyy\') and to_date(\''.$parametros['dt_fim'].'\', \'dd/mm/yyyy\')');
                        }elseif(@$parametros['dt_inicio'] && $parametros['dt_fim'] == ''){
				$this->db->where('date(br.dt_cadastro) between to_date(\''. $parametros['dt_inicio'] .'\', \'dd/mm/yyy\') and to_date(\''.$parametros['dt_inicio'].'\', \'dd/mm/yyyy\')');
                        }
			$this->db->sendToGrid();
		}
                
                function getAtividadesRegistrosPorPessoa($parametros, $noPagination=false){
			$this->db->select('br.id, br.entrada_saida, br.atividade, br.dt_cadastro');
			$this->db->from('equipe_atividades_registros as br');
			$this->db->join('pessoas as p', 'br.pessoa_id = p.id');
                        if (@$parametros['pessoaId'] != '')
                            $this->db->where('p.id',$parametros['pessoaId']);
                        if (@$parametros['dt_inicio'] && $parametros['dt_fim'] != '') {
				$this->db->where('date(br.dt_cadastro) between to_date(\''. $parametros['dt_inicio'] .'\', \'dd/mm/yyyy\') and to_date(\''.$parametros['dt_fim'].'\', \'dd/mm/yyyy\')');
                        }elseif(@$parametros['dt_inicio'] && $parametros['dt_fim'] == ''){
				$this->db->where('date(br.dt_cadastro) between to_date(\''. $parametros['dt_inicio'] .'\', \'dd/mm/yyy\') and to_date(\''.$parametros['dt_inicio'].'\', \'dd/mm/yyyy\')');
                        }
                        logLastSQL();
			$this->db->sendToGrid();
		}
                function getEquipeComAtividades($parametros, $noPagination=false){
                        $this->db->select('p.id, p.nome');
                        $this->db->from('equipe_atividades_registros as ear');
                        $this->db->join('pessoas as p', 'ear.pessoa_id = p.id');
                        if (@$parametros['nome'] != '')
                            $this->db->like('upper(p.nome)', $parametros['nome']);
                        $this->db->groupBy('p.id');
                        $this->db->sendToGrid();
                }

		function getAtividade($bolsistaId){
			$this->db->select('br.id, br.entrada_saida, br.atividade, to_char(br.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->from('equipe_atividades_registros as br');
			$this->db->join('pessoas as p', 'br.pessoa_id = p.id');
			$this->db->where('br.id', $bolsistaId);
			return $this->db->get()->row();
		}

		function validaAtividade($capacitacao){
			$this->validate->setData($capacitacao);
			$this->validate->validateField('cmbEntradaSaida', array('required'), lang('atividadeRegistradaDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}