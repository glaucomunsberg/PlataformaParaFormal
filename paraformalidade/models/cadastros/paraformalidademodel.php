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
                                $this->db->set('link', '');
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
                            $this->db->set('estaativa', (!empty($paraformalidade['chkParaformalidadeAtivo'])?'S':'N'));
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
                                $this->db->set('link', '');
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
                            $this->db->set('estaativa', (!empty($paraformalidade['chkParaformalidadeAtivo'])?'S':'N'));
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
                        $this->db->select('ip.id, ip.cena_id, ip.descricao, up.id as upload_id,up.nome_gerado,up.nome_original, ip.geo_latitude, ip.geo_longitude, ip.link, case when estaativa = \'S\' then \'true\' when estaativo != \'S\' then \'false\' end as estaativa, turno_ocorrencia_id, atividade_registrada_id, quantidade_registrada_id, espaco_localizacao_id, corpo_numero_id, corpo_posicao_id, equipamento_porte_id, equipamento_mobilidade_id, ip.dt_cadastro, to_char(ip.dt_ocorrencia, \'dd/mm/yyyy \') as dt_ocorrencia',false);
                        $this->db->from('paraformal.paraformalidades as ip');
                        $this->db->join('paraformal.cenas as c', 'c.id = ip.cena_id');
                        $this->db->join('public.uploads as up','ip.upload_id = up.id');
			$this->db->where('ip.id', $paraformalidadeID);
			return $this->db->get()->row();
		}
                
                function getParaformalidadesParaPaginar($cena_id){
                        $this->db->select('p.id, p.descricao, ar.descricao as atividade_registrada, em.descricao as equipamento_mobilidade, el.descricao as equipamento_localizacao, tu.descricao as turno_ocorrencia,to_char(p.dt_ocorrencia, \'dd/mm/yyyy\') as dt_ocorrencia, up.nome_gerado',false);
                        $this->db->from('paraformal.paraformalidades as p');
                        $this->db->join('public.uploads as up', 'up.id = p.upload_id');
                        $this->db->join('paraformal.turnos_ocorrencia as tu', 'tu.id = p.turno_ocorrencia_id');
                        $this->db->join('paraformal.atividades_registradas as ar','ar.id = p.atividade_registrada_id');
                        $this->db->join('paraformal.espaco_localizacoes as el', 'el.id = p.espaco_localizacao_id');
                        $this->db->join('paraformal.equipamento_mobilidades as em','em.id = p.equipamento_mobilidade_id');
			$this->db->where('p.estaativa', 'S');
                        $this->db->where('p.cena_id', $cena_id);
                        $this->db->order_by('p.dt_ocorrencia','DESC');
                        return $this->db->get()->result();
                }
                
                function getCenaParaExibir($cena_id){
                    $this->db->select('c.id, c.descricao as cena_descricao, ga.descricao as grupo_descricao,cid.nome as cidade_nome, p.descricao as para_descricao, up.nome_gerado, (select count(ptemp.id) from paraformal.paraformalidades as ptemp where ptemp.cena_id = c.id and ptemp.estaativa = \'S\') as num_paraformalidades, p.id as para_id, p."link", to_char(p.dt_cadastro, \'dd/mm/yyyy \') as dt_cadastro, to_char(p.dt_ocorrencia, \'dd/mm/yyyy \') as dt_ocorrencia, ar.descricao as atividade_registrada, em.descricao as equipamento_mobilidade, tu.descricao as turno_ocorrencia, el.descricao as espaco_localizacao',false);
                    $this->db->from('paraformal.cenas as c');
                    $this->db->join('paraformal.grupos_atividades as ga', 'ga.id = c.grupo_atividade_id');
                    $this->db->join('paraformal.paraformalidades as p', 'p.id = (select para.id from paraformal.paraformalidades as para where para.cena_id = c.id and para.estaativa = \'S\' order by dt_ocorrencia DESC limit 1)');
                    $this->db->join('public.uploads as up', 'up.id = p.upload_id');
                    $this->db->join('paraformal.atividades_registradas as ar', 'ar.id = p.atividade_registrada_id');
                    $this->db->join('paraformal.equipamento_mobilidades as em', 'em.id = p.equipamento_mobilidade_id');
                    $this->db->join('paraformal.turnos_ocorrencia as tu', 'tu.id = p.turno_ocorrencia_id');
                    $this->db->join('paraformal.espaco_localizacoes as el', 'el.id = p.espaco_localizacao_id');
                    $this->db->join('cidades as cid','cid.id = ga.cidade_id');
                    $this->db->where('c.id', $cena_id);
                    $this->db->where('c.estaativo', 'S');
                    return $this->db->get()->row();
                }
                
                function getColaboradorParaExibir($paraformalidade_id){
                     $this->db->select('p.nome',false);
                     $this->db->from('paraformal.colaboradores_paraformalidades as cp');
                     $this->db->join('paraformal.paraformalidades as par', 'par.id = cp.paraformalidade_id');
                     $this->db->join('pessoas as p', 'p.id = cp.pessoa_id');
                     $this->db->where('par.id', $paraformalidade_id);
                     $this->db->where('par.estaativa', 'S');
                     $this->db->limit(2);
                     return $this->db->get()->result();
                 }
                 
                 function getSentidosParaExibir($paraformalidade_id){
                     $this->db->select('s.descricao',false);
                     $this->db->from('paraformal.sentidos_paraformalidade as sp');
                     $this->db->join('paraformal.paraformalidades as par', 'par.id = sp.paraformalidade_id');
                     $this->db->join('paraformal.sentidos as s', 's.id = sp.sentido_id');
                     $this->db->where('par.id', $paraformalidade_id);
                     $this->db->where('par.estaativa', 'S');
                     return $this->db->get()->result();
                 }
                 function getClimasParaExibir($paraformalidade_id){
                     $this->db->select('c.descricao',false);
                     $this->db->from('paraformal.climas_paraformalidade as cp');
                     $this->db->join('paraformal.paraformalidades as par', 'par.id = cp.paraformalidade_id');
                     $this->db->join('paraformal.climas as c', 'c.id = cp.clima_id');
                     $this->db->where('par.id', $paraformalidade_id);
                     $this->db->where('par.estaativa', 'S');
                     return $this->db->get()->result();
                 }
                 
                 function getInstalacoesParaExibir($paraformalidade_id){
                     $this->db->select('i.descricao',false);
                     $this->db->from('paraformal.equipamento_instalacoes_paraformalidade as ip');
                     $this->db->join('paraformal.paraformalidades as par', 'par.id = ip.paraformalidade_id');
                     $this->db->join('paraformal.equipamento_instalacoes as i', 'i.id = ip.equipamento_instalacao_id');
                     $this->db->where('par.id', $paraformalidade_id);
                     $this->db->where('par.estaativa', 'S');
                     return $this->db->get()->result();
                 }
               
		function getParaformalidades($parametros) {
                        $this->db->select('ip.id, ip.cena_id, ip.descricao, up.nome_gerado, up.nome_original, ip.upload_id, ip.link as link_para, case when ip.estaativa = \'S\' then \'Publico\' when ip.estaativa != \'S\' then \'Privado\' end as estaativa, to_char(ip.dt_ocorrencia, \'dd/mm/yyyy\') as dt_ocorrencia',false);
                        $this->db->from('paraformal.paraformalidades as ip');
                        $this->db->join('paraformal.cenas as c', 'c.id = ip.cena_id');
                        $this->db->join('public.uploads as up','ip.upload_id = up.id');
                        if($parametros['txtCenaId'] != '' )
                            $this->db->where('c.id',$parametros['txtCenaId']);
                        $this->db->sendToGrid();
                }
                
                function getParaformalidadeToMaps($grupoAtividadeID){
                    $this->db->select('c.id, p.geo_latitude as geocode_lat,p.geo_longitude as geocode_lng', false);
                    $this->db->from('paraformal.cenas as c');
                    $this->db->join('paraformal.paraformalidades as p','p.id = (select para.id from paraformal.paraformalidades as para where para.cena_id = c.id order by dt_ocorrencia DESC limit 1) ');
                    $this->db->where('c.estaativo', 'S');
                    $this->db->where('p.estaativa', 'S');
                    $this->db->where('c.grupo_atividade_id', $grupoAtividadeID);
                    return $this->db->get()->result_array();
                }
                
                function getParaformalidadeToMapsDiscovery($parametros){
                    $this->db->select('c.id, p.geo_latitude as geocode_lat,p.geo_longitude as geocode_lng', false);
                    $this->db->from('paraformal.cenas as c');
                    $this->db->join('paraformal.paraformalidades as p','p.id = (select para.id from paraformal.paraformalidades as para where para.cena_id = c.id order by dt_ocorrencia DESC limit 1) ');
                    if(!empty($parametros['sentidos'])){
                        $values = "";
                        foreach ($parametros['sentidos'] as $val){
                            if($values == ""){
                                $values.=$val;
                            }else{
                                $values.=",".$val;
                            }
                        }
                        $this->db->join('paraformal.sentidos_paraformalidade as sp','sp.id = (select sp.id from paraformal.sentidos_paraformalidade as sp where sp.sentido_id in ('.$values.') and sp.paraformalidade_id = p.id limit 1)');
                    }
                    if(!empty($parametros['instalacao_equipamento'])){
                        $values = "";
                        foreach ($parametros['instalacao_equipamento'] as $val){
                            if($values == ""){
                                $values.=$val;
                            }else{
                                $values.=",".$val;
                            }
                        }
                        $this->db->join('paraformal.equipamento_instalacoes_paraformalidade as eip','eip.id = (select eip.id from paraformal.equipamento_instalacoes_paraformalidade as eip where eip.equipamento_instalacao_id in ('.$values.') and eip.paraformalidade_id = p.id limit 1)');
                    }
                    
                    if(!empty($parametros['tipo_atividade'])){
                        $this->db->where_in('atividade_registrada_id',$parametros['tipo_atividade']);
                    }
                    if(!empty($parametros['turno'])){
                        $this->db->where_in('turno_ocorrencia_id',$parametros['turno']);
                    }
                    if(!empty($parametros['quantidade'])){
                        $this->db->where_in('quantidade_registrada_id',$parametros['quantidade']);
                    }
                    if(!empty($parametros['localizacao'])){
                        $this->db->where_in('espaco_localizacao_id',$parametros['localizacao']);
                    }
                    if(!empty($parametros['corpo_posicao'])){
                        $this->db->where_in('corpo_posicao_id',$parametros['corpo_posicao']);
                    }
                    if(!empty($parametros['corpo_numero'])){
                        $this->db->where_in('corpo_numero_id',$parametros['corpo_numero']);
                    }
                    if(!empty($parametros['mobilidade_equipamento'])){
                        $this->db->where_in('equipamento_mobilidade_id',$parametros['mobilidade_equipamento']);
                    }
                    if(!empty($parametros['tamanho_equipamento'])){
                        $this->db->where_in('equipamento_porte_id',$parametros['tamanho_equipamento']);
                    }
                    if(!empty($parametros['grupo_atividade'])){
                        $this->db->where('grupo_atividade_id',$parametros['grupo_atividade']);
                    }
                    if(!empty($parametros['cena'])){
                        $this->db->where('c.id',$parametros['cena']);
                    }
                    $this->db->where('c.estaativo', 'S');
                    $this->db->where('p.estaativa', 'S');
                    return $this->db->get()->result_array();
                }
                
                function getNumeroDeColaboracoesPublicas(){
                    $this->db->select('*');
                    $this->db->from('paraformal.paraformalidades');
                    $this->db->where('contribuicao_publica','S');
                    $this->db->where('estaativa','N');
                    return $this->db->get()->num_rows();
                }
                
                
                function getColaboradores($parametros){
                    $this->db->select('cp.id, p.nome',false);
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
                    $this->db->select('sp.id, s.descricao',false);
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
                    $this->db->select('ca.id, c.descricao',false);
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
                    $this->db->select('ei.id, e.descricao',false);
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
                    $this->db->select('cp.id, c.descricao',false);
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