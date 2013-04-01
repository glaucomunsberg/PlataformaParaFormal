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
			return $this->db->get('paraformal.paraformalidades')->result_array();
		}
                
                
                function getImageCombo($grupoAtividade){
                    $this->db->select('u.id, u.nome_gerado, u.nome_original, u.tamanho, to_char(u.dt_cadastro, \'dd/mm/yyyy\') as dt_cadastro',false);
                    $this->db->from('public.paraformalidades as p');
                    $this->db->join('public.uploads as u',' u.id = p.imagem_id');
                    $this->db->where('p.grupo_atividade_id',$grupoAtividade);
                    $this->db->orderby('u.id','asc');
                    return $this->db->get()->result_array();
                }

		function inserir($paraformalidade){
			$this->db->trans_start();                       
                            $this->db->set('cena_id', $paraformalidade['txtCenaId']);
                            if($paraformalidade['txtArquivoImportacaoId'] == ''){
                                $this->db->set('upload_id', 22);
                                $this->db->set('link', $paraformalidade['txtLink']);
                            }else{
                                $this->db->set('upload_id', $paraformalidade['txtArquivoImportacaoId']);
                            }
                            $this->db->set('descricao', $paraformalidade['txtDescricao']);
                            $this->db->set('geo_latitude', $paraformalidade['txtLatOrigem']);
                            $this->db->set('geo_longitude', $paraformalidade['txtLngOrigem']);
                            $this->db->set('turno_ocorrencia_id', $paraformalidade['cmbTurnoOcorrencia']);
                            $this->db->set('atividade_registrada_id', $paraformalidade['cmbAtividadeRegistrada']);
                            $this->db->set('quantidade_registrada_id', $paraformalidade['cmbQuantidadeRegistrada']);
                            $this->db->set('espaco_localizacao_id', $paraformalidade['cmbEspacoLocalizacao']);
                            $this->db->set('corpo_numero_id', $paraformalidade['cmbCorposNumero']);
                            $this->db->set('corpo_posicao_id', $paraformalidade['cmbCorpoPosicao']);
                            $this->db->set('equipamento_porte_id', $paraformalidade['cmbEquipamentoPorte']);
                            $this->db->set('equipamento_mobilidade_id', $paraformalidade['cmbEquipamentoMobilidade']);
                            $this->db->set('dt_ocorrencia', $paraformalidade['txtCenaOcorrencia']);
                            $this->db->set('estaativa', $paraformalidade['chkParaformalidadeAtivo']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.paraformalidades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('paraformalidade', $this->getParaformalidade($this->db->insert_id('paraformal.paraformalidades', 'id')));
			return true;
		}

		function alterar($paraformalidade){

			$this->db->trans_start();
                        $this->db->set('cena_id', $paraformalidade['txtCenaId']);
                            if($paraformalidade['txtArquivoImportacaoId'] == ''){
                                $this->db->set('upload_id', 22);
                                $this->db->set('link', $paraformalidade['txtLink']);
                            }else{
                                $this->db->set('upload_id', $paraformalidade['txtArquivoImportacaoId']);
                            }
                            $this->db->set('descricao', $paraformalidade['txtDescricao']);
                            $this->db->set('geo_latitude', $paraformalidade['txtLatOrigem']);
                            $this->db->set('geo_longitude', $paraformalidade['txtLngOrigem']);
                            $this->db->set('turno_ocorrencia_id', $paraformalidade['cmbTurnoOcorrencia']);
                            $this->db->set('atividade_registrada_id', $paraformalidade['cmbAtividadeRegistrada']);
                            $this->db->set('quantidade_registrada_id', $paraformalidade['cmbQuantidadeRegistrada']);
                            $this->db->set('espaco_localizacao_id', $paraformalidade['cmbEspacoLocalizacao']);
                            $this->db->set('corpo_numero_id', $paraformalidade['cmbCorposNumero']);
                            $this->db->set('corpo_posicao_id', $paraformalidade['cmbCorpoPosicao']);
                            $this->db->set('equipamento_porte_id', $paraformalidade['cmbEquipamentoPorte']);
                            $this->db->set('equipamento_mobilidade_id', $paraformalidade['cmbEquipamentoMobilidade']);
                            $this->db->set('dt_ocorrencia', $paraformalidade['txtCenaOcorrencia']);
                            $this->db->set('estaativa', $paraformalidade['chkParaformalidadeAtivo']);
			$this->db->where('id', $paraformalidade['txtParaformalidadeId']);
			$this->db->update('paraformal.paraformalidades');
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
				$this->db->delete('paraformal.paraformalidades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getParaformalidade($paraformalidadeID){
                        $this->db->from('paraformal.paraformalidades as ip');
                        $this->db->where('ip.id', $paraformalidadeID);
			return $this->db->get()->row();
		
                }
		function getParaformalidadeComDados($paraformalidadeID){
                        $this->db->select('ip.id, ip.cena_id, ip.descricao, up.nome_gerado,up.nome_original, ip.geo_latitude, ip.geo_longitude, ip.link, case when estaativa = \'S\' then \'true\' when estaativo != \'S\' then \'false\' end as estaativa, turno_ocorrencia_id, atividade_registrada_id, quantidade_registrada_id, espaco_localizacao_id, corpo_numero_id, corpo_posicao_id, equipamento_porte_id, equipamento_mobilidade_id, ip.dt_cadastro, to_char(ip.dt_ocorrencia, \'dd/mm/yyyy \') as dt_ocorrencia',false);
                        $this->db->from('paraformal.paraformalidades as ip');
                        $this->db->join('paraformal.cenas as c', 'c.id = ip.cena_id');
                        $this->db->join('public.uploads as up','ip.upload_id = up.id');
			$this->db->where('ip.id', $paraformalidadeID);
			return $this->db->get()->row();
		}
                
		function getParaformalidades($parametros) {
                        $this->db->select('ip.id, ip.cena_id, ip.descricao, up.nome_gerado,up.nome_original, ip.geo_latitude, ip.geo_longitude, ip.link, case when estaativa = \'S\' then \'Publico\' when estaativo != \'S\' then \'Privado\' end as estaativa, tuo.descricao as turno_ocorrencia, ar.descricao as atividade_registrada, qr.descricao as quantidade_registrada, el.descricao as espaco_localizacao, cn.descricao as corpo_numero, cp.descricao as corpo_posicao, qp.descricao as equipamento_porte, qm.descricao as equipamento_mobilidade, ip.dt_cadastro,to_char(ip.dt_ocorrencia, \'dd/mm/yyyy \') as dt_ocorrencia',false);
                        $this->db->from('paraformal.paraformalidades as ip');
                        $this->db->join('paraformal.cenas as c', 'c.id = ip.cena_id');
                        $this->db->join('paraformal.atividades_registradas as ar','ar.id = ip.atividade_registrada_id');
                        $this->db->join('paraformal.turnos_ocorrencia as tuo','tuo.id = ip.turno_ocorrencia_id');
                        $this->db->join('paraformal.quantidades_registrada as qr','qr.id = ip.quantidade_registrada_id');
                        $this->db->join('paraformal.espaco_localizacoes as el','el.id = ip.espaco_localizacao_id');
                        $this->db->join('paraformal.corpo_numeros as cn','cn.id = ip.corpo_numero_id');
                        $this->db->join('paraformal.corpo_posicoes as cp','cp.id = ip.corpo_posicao_id');
                        $this->db->join('paraformal.equipamento_portes as qp','qp.id = ip.equipamento_porte_id');
                        $this->db->join('paraformal.equipamento_mobilidades as qm','qm.id = ip.equipamento_mobilidade_id');
                        $this->db->join('public.uploads as up','ip.upload_id = up.id');
                        if(@$parametros['txtCenaId'] != '' )
                            $this->db->where('c.id',@$parametros['txtCenaId']);
                        $this->db->sendToGrid();
                }
                
                function getParaformalidadeToMaps($grupoAtividadeID){
                    $this->db->select('p.geocode_lat, p.geocode_lng, p.id', false);
                    $this->db->where('p.grupo_atividade_id', $grupoAtividadeID);
                    $this->db->where('p.esta_ativo', 'S');
                    return $this->db->get('paraformal.paraformalidades as p')->result_array();
                }
                
                
                function getColaboradores($parametros){
                    $this->db->select('p.nome',false);
                        $this->db->from('paraformal.colaboradores_paraformalidades as cp');
                        $this->db->join('pessoas as p','p.id = cp.pessoa_id');
                        if(@$parametros['txtParaformalidadeId'] != '' )
                            $this->db->where('cp.paraformalidade_id',@$parametros['txtParaformalidadeId']);
                        $this->db->sendToGrid();
                }
		function validaParaformalidade($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtCenaId', array('required'), lang('ParaformalidadeDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}
                function inserirColaborador($parametros){
			
			$this->db->trans_start();
                            $this->db->set('pessoa_id', $parametros['pessoa_id']);
                            $this->db->set('paraformalidade_id', $parametros['paraformalidadeId']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.colaboradores_paraformalidades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                function excluirColaborador($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.colaboradores_paraformalidades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                
                function getSentidos($parametros){
                    $this->db->select('s.descricao',false);
                        $this->db->from('paraformal.sentidos_paraformalidade as sp');
                        $this->db->join('paraformal.sentidos as s','s.id = sp.sentido_id');
                        if(@$parametros['txtParaformalidadeId'] != '' )
                            $this->db->where('sp.paraformalidade_id',@$parametros['txtParaformalidadeId']);
                        $this->db->sendToGrid();
                }
                function inserirSentido($parametros){
			
			$this->db->trans_start();
                            $this->db->set('sentido_id', $parametros['sentido_id']);
                            $this->db->set('paraformalidade_id', $parametros['paraformalidadeId']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.sentidos_paraformalidade');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                function excluirSentido($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.sentidos_paraformalidade');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                function getCondicionantes($parametros){
                    $this->db->select('c.descricao',false);
                        $this->db->from('paraformal.condicionantes_ambientais_paraformalidade as ca');
                        $this->db->join('paraformal.condicionantes_ambientais as c','c.id = ca.condicionante_ambiental_id');
                        if(@$parametros['txtParaformalidadeId'] != '' )
                            $this->db->where('ca.paraformalidade_id',@$parametros['txtParaformalidadeId']);
                        $this->db->sendToGrid();
                }
                function inserirCondicionante($parametros){
			$this->db->trans_start();
                            $this->db->set('condicionante_ambiental_id', $parametros['condicionante_ambiental_id']);
                            $this->db->set('paraformalidade_id', $parametros['paraformalidadeId']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.condicionantes_ambientais_paraformalidade');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                function excluirCondicionante($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.condicionantes_ambientais_paraformalidade');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                
                function getInstalacoes($parametros){
                    $this->db->select('e.descricao',false);
                        $this->db->from('paraformal.equipamento_instalacoes_paraformalidade as ei');
                        $this->db->join('paraformal.equipamento_instalacoes as e','e.id = ei.equipamento_instalacao_id');
                        if(@$parametros['txtParaformalidadeId'] != '' )
                            $this->db->where('ei.paraformalidade_id',@$parametros['txtParaformalidadeId']);
                        $this->db->sendToGrid();
                }
                
                function inserirInstalacao($parametros){
			$this->db->trans_start();
                            $this->db->set('equipamento_instalacao_id', $parametros['instalacao_id']);
                            $this->db->set('paraformalidade_id', $parametros['paraformalidadeId']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.equipamento_instalacoes_paraformalidade');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                function excluirInstalacao($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.equipamento_instalacoes_paraformalidade');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                
                
                function getClimas($parametros){
                    $this->db->select('c.descricao',false);
                        $this->db->from('paraformal.climas_paraformalidade as cp');
                        $this->db->join('paraformal.climas as c','c.id = cp.clima_id');
                        if(@$parametros['txtParaformalidadeId'] != '' )
                            $this->db->where('cp.paraformalidade_id',@$parametros['txtParaformalidadeId']);
                        $this->db->sendToGrid();
                }
                
                function inserirClima($parametros){
			$this->db->trans_start();
                            $this->db->set('clima_id', $parametros['clima_id']);
                            $this->db->set('paraformalidade_id', $parametros['paraformalidadeId']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.climas_paraformalidade');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}
                function excluirClima($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('paraformal.climas_paraformalidade');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

	}