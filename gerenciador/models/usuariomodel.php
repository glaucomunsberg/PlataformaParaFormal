<?php
	class UsuarioModel extends Model{
		
		function __construct(){
			parent::__construct();			
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('../../gerenciador/models/PerfilModel', 'perfilModel');
			$this->load->model('../../gerenciador/models/PermissaoModel', 'permissaoModel');
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $usuario $_POST
		 */
		function incluir($usuario){
			$retErro = $this->validaInclusaoUsuario($usuario);
			if($retErro)
				return false;
			
			$this->db->trans_begin();
				$this->db->set('nome',  'trim(upper(\''.trim(strtoupper($usuario['txtNome'])).'\'))', false);
				$this->db->set('nome_consulta', 'trim(upper(retira_acento(\''.trim(strtoupper($usuario['txtNome'])).'\')))', false);
				$this->db->set('sexo', $usuario['chksexo']);
				if($usuario['dtNascimento'] != '')
					$this->db->set('dt_nascimento', 'to_date(\''.$usuario['dtNascimento'].'\',\'%d/%m/%Y\')', false);
				else
					$this->db->set('dt_nascimento', 'NULL', false);
	
				$this->db->set('email', $usuario['txtEmail']);
				$this->db->set('rg', $usuario['txtRG']);
				$this->db->set('cpf', str_replace('-', '', str_replace('.', '', $usuario['txtCPF'])));
				$this->db->set('dt_cadastro', 'NOW()', false);
				$this->db->insert('pessoas');

				$this->db->set('pessoa_id', $this->db->insert_id());
				$this->db->set('login', $usuario['txtLogin']);
				$this->db->set('senha', $this->encrypt->sha1($usuario['txtSenha']));
				$this->db->set('dt_cadastro', 'NOW()', false);
				$this->db->insert('usuarios');
				
				$this->ajax->addAjaxData('usuario', $this->getUsuario($this->db->insert_id()));
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
				
			$this->db->trans_commit();
			return true;
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $usuario $_POST
		 */
		function alterar($usuario){
			$retErro = $this->validaAlterarUsuario($usuario);
			if($retErro)
				return false;
			
			$pessoaId = $this->getUsuario($usuario['txtCodigo'])->pessoa_id;
			
			$this->db->trans_begin();
				$this->db->set('nome',  'trim(upper(\''.trim(strtoupper($usuario['txtNome'])).'\'))', false);
				$this->db->set('nome_consulta', 'trim(upper(retira_acento(\''.trim(strtoupper($usuario['txtNome'])).'\')))', false);
				$this->db->set('sexo', $usuario['chksexo']);
				if($usuario['dtNascimento'] != '')
					$this->db->set('dt_nascimento', 'to_date(\''.$usuario['dtNascimento'].'\',\'%d/%m/%Y\')', false);
				else
					$this->db->set('dt_nascimento', 'NULL', false);
	
				$this->db->set('email', $usuario['txtEmail']);
				$this->db->set('rg', $usuario['txtRG']);
				$this->db->set('cpf', str_replace('-', '', str_replace('.', '', $usuario['txtCPF'])));
				$this->db->where('id', $pessoaId);
				$this->db->update('pessoas');

				$this->db->set('login', $usuario['txtLogin']);
				if($usuario['txtSenha'] != '')
					$this->db->set('senha', $this->encrypt->sha1($usuario['txtSenha']));
				$this->db->where('id', $usuario['txtCodigo']);
				$this->db->update('usuarios');
				
				$this->ajax->addAjaxData('usuario', $this->getUsuario($usuario['txtCodigo']));
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}

			$this->db->trans_commit();
			return true;
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $id integer
		 */
		function excluir($id){
			$pessoaId = $this->getUsuario($id)->pessoa_id;			
			
			$this->db->trans_begin();
				
				$this->db->where('usuario_id', $id);
				$this->db->delete('usuarios_empresas');
				
				$this->db->where('usuario_id', $id);
				$this->db->delete('usuarios_perfis');
				
				$this->db->where('id', $pessoaId);
				$this->db->delete('pessoas');
				
				$this->db->where('id', $id);
				$this->db->delete('usuarios');
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
				
			$this->db->trans_commit();
			return true;
		}
		
		/**
		 * 
		 * @return Array para montar a grid
		 * @param $nome string[optional]
		 * @param $login string[optional]
		 * @param $start integer
		 * @param $limit integer
		 */
		function getUsuarios($parametros){
			$nomes = array();
			if (isset($parametros['nome']) and !empty($parametros['nome'])) {
			 	$nomes = explode(" ", $parametros['nome']);
			}
		 	$login = "";
		 	if (isset($parametros['login']) and !empty($parametros['login'])) {
		 		$login = $parametros['login'];
		 	}
			$this->db->select('count(*) as quant');
			$this->db->from('usuarios as u');
			$this->db->join('pessoas as p', 'p.id = u.pessoa_id');
			
			foreach ( $nomes as $nome )
       			$this->db->like('upper(p.nome)', $nome);
			
			$this->db->like('upper(u.login)', $login);
			$total = $this->db->get()->row();
			
			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quant);

			$this->db->select('u.id, p.nome as nome, u.login, p.email, date_format(p.dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->from('usuarios as u');
			$this->db->join('pessoas as p', 'p.id = u.pessoa_id');
			foreach ( $nomes as $nome )
       			$this->db->like('upper(p.nome)', $nome);

			$this->db->like('upper(u.login)', $login);
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$this->db->offset($paramsJqGrid->start);
			$this->db->limit($paramsJqGrid->limit);
			$result = $this->db->get();

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}
		
		/**
		 * 
		 * @return row
		 * @param $id integer
		 */
		function getUsuario($id){
			$this->db->select('u.id, p.nome as nome, p.sexo, u.login, p.cpf, p.rg, p.email,' .
					          'date_format(p.dt_nascimento, \'%d/%m/%Y\') as dt_nascimento, u.pessoa_id', false);
			$this->db->from('usuarios as u');
			$this->db->join('pessoas as p', 'p.id = u.pessoa_id');
			$this->db->where('u.id', $id);
			return $this->db->get()->row();
		}

		function getUsuarioByHashId($hash_id){
			$this->db->select('u.id, u.pessoa_id, u.login, u.senha, p.nome, p.email', false);
			$this->db->from('usuarios as u');
			$this->db->join('pessoas as p', 'p.id = u.pessoa_id');
			$this->db->where('u.hash_id', $hash_id);
			return $this->db->get()->row();
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $empresa $_POST
		 */
		function incluirEmpresa($empresa){
			$retErro = $this->validaIncluirEmpresa($empresa);
			if($retErro)
				return false;
			
			$this->db->trans_begin();
			
				$this->db->where('usuario_id', $empresa['txtIdUsuarioEmpresa']);
				$this->db->where('empresa_id', $empresa['cmbEmpresa']);
				$this->db->delete('usuarios_empresas');
			
				$empresaBoot = 'N';
				if(isset($empresa['chkEmpresaBoot'])){
					$this->db->set('empresa_boot', 'N');
					$this->db->where('usuario_id', $empresa['txtIdUsuarioEmpresa']);
					$this->db->update('usuarios_empresas');
					$empresaBoot = 'S';
				}
				
				$this->db->set('usuario_id', $empresa['txtIdUsuarioEmpresa']);
				$this->db->set('empresa_id', $empresa['cmbEmpresa']);
				$this->db->set('empresa_boot', $empresaBoot);
				$this->db->insert('usuarios_empresas');
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
				
			$this->db->trans_commit();
			return true;
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $usuarioId integer
		 * @param $empresaId integer
		 */
		function excluirEmpresa($usuarioId, $empresaId){
			$this->db->where('empresa_id', $empresaId);
			$perfis = $this->db->get('empresas_perfis')->result();
			
			$this->db->trans_begin();

				foreach($perfis as $perfil){
					$this->db->where('usuario_id', $usuarioId);
					$this->db->where('perfil_id', $perfil->perfil_id);
					$this->db->where('empresa_id', $empresaId);
					$this->db->delete('usuarios_perfis');
				}
				
				$this->db->where('usuario_id', $usuarioId);
				$this->db->where('empresa_id', $empresaId);
				$this->db->delete('usuarios_empresas');
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
			
			$this->db->trans_commit();
			return true;
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $perfis $_POST
		 */
		function salvarPerfis($perfis){			
			$this->db->where('empresa_id', $perfis['empresaId']);
			$empresaPerfis = $this->db->get('empresas_perfis')->result();
			
			$this->db->trans_begin();
				foreach($empresaPerfis as $empresaPerfil){
					$this->db->where('usuario_id', $perfis['usuarioId']);
					$this->db->where('perfil_id', $empresaPerfil->perfil_id);
					$this->db->where('empresa_id', $perfis['empresaId']);
					$this->db->delete('usuarios_perfis');
				}
							
				if($perfis['perfisId'] != ''){
					$idPerfis = explode(',', $perfis['perfisId']);
					for($i = 0; $i < count($idPerfis); $i++){
						$this->db->set('usuario_id', $perfis['usuarioId']);
						$this->db->set('perfil_id', $idPerfis[$i]);
						$this->db->set('empresa_id', $perfis['empresaId']);
						$this->db->insert('usuarios_perfis');
					}
				}
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
			
			$this->db->trans_commit();
			return true;
		}
		
		/**
		 * 
		 * @return Array para montar a grid
		 * @param $usuarioId integer
		 */
		function getEmpresasUsuario($parametros){
			$sql = 'select concat_ws(\'chr\', ue.usuario_id, ue.empresa_id) as id, e.nome, case when ue.empresa_boot = \'S\' then \'Sim\' else \'Não\' end as empresa_boot
						from usuarios_empresas as ue
						join empresas as e
							on ue.empresa_id = e.id
 					  where ue.usuario_id = '.$parametros['usuarioId'].'
					  	order by e.nome asc';
			$result = $this->db->query($sql);
			
			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}
		
		/**
		 * 
		 * @return result_array
		 * @param $usuarioId integer
		 */
		function getEmpresasUsuarioCombo($usuarioId){
			$this->db->select('ue.empresa_id, e.nome');
			$this->db->from('usuarios_empresas as ue');
			$this->db->join('empresas as e', 'ue.empresa_id = e.id');
			$this->db->where('ue.usuario_id', $usuarioId);
			$this->db->orderby('e.nome', 'asc');			
			return $this->db->get()->result();
		}
		
		function getEmpresasGruposAcessos($usuarioId){
			$sql = 'select ue.empresa_id, e.nome
					  from usuarios_empresas as ue
					  join empresas as e
						on ue.empresa_id = e.id  
					 where ue.usuario_id = '.$usuarioId.'
					 union
					select gae.empresa_id, e.nome
					  from usuarios as u
					  join usuarios_grupos_acessos as uga 
						on u.id = uga.usuario_id
					  join grupos_acessos_empresas as gae
						on uga.grupo_acesso_id = gae.grupo_acesso_id
					  join empresas as e
						on e.id = gae.empresa_id
					 where u.id = '.$usuarioId.'
					 order by nome asc';
			return $this->db->query($sql)->result();
		}
		
		/**
		 * 
		 * @return row
		 * @param $usuarioId integer
		 */
		function getEmpresaBootUsuario($usuarioId){
			$this->db->select('ue.empresa_id');
			$this->db->from('usuarios_empresas as ue');
			$this->db->join('empresas as e', 'ue.empresa_id = e.id');
			$this->db->where('ue.usuario_id', $usuarioId);
			$this->db->where('ue.empresa_boot', 'S');
			$this->db->orderby('e.nome', 'asc');
			$result = $this->db->get()->row();
			return $result->empresa_id;
		}
		
		/**
		 * 
		 * @return row
		 * @param $usuarioId integer
		 * @param $empresaId integer
		 */
		function getEmpresaUsuario($usuarioId, $empresaId){
			$this->db->where('usuario_id', $usuarioId);
			$this->db->where('empresa_id', $empresaId);
			return $this->db->get('usuarios_empresas')->row();
		}
		
		/**
		 * 
		 * @return result
		 * @param $usuarioId integer
		 */
		function getPerfisUsuario($usuarioId, $empresaId){
			$this->db->select('p.id, p.nome_perfil');
			$this->db->where('up.usuario_id', $usuarioId);
			$this->db->where('ep.empresa_id', $empresaId);
			$this->db->where('up.empresa_id', $empresaId);
			$this->db->from('usuarios_perfis as up');
			$this->db->join('perfis as p', 'up.perfil_id = p.id');
			$this->db->join('empresas_perfis as ep', 'up.perfil_id = ep.perfil_id');
			$this->db->order_by('p.nome_perfil', 'asc');
			return $this->db->get()->result();
		}
		
		function getGruposAcessosUsuario($usuarioId){
			$this->db->where('usuario_id', $usuarioId);		
			return $this->db->get('usuarios_grupos_acessos')->result();
		}
		
		function acessaPerfil($perfilId, $usuarioId){
			$this->db->select('count(*) as qtd_perfil');
			$this->db->where('usuario_id', $usuarioId);
			$this->db->where('perfil_id', $perfilId);
			$perfil = $this->db->get('usuarios_perfis')->row();
			$acessaPerfil = false;
			if($perfil->qtd_perfil > 0)
				$acessaPerfil = true;

			return $acessaPerfil;
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $data $_POST
		 */
		function validaIncluirEmpresa($data){
			$this->validate->setData($data);
			$this->validate->validateField('cmbEmpresa', array('required'), lang('usuarioEmpresaNaoInformada'));
			return $this->validate->existsErrors();
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $usuario $_POST
		 */
		function validaInclusaoUsuario($usuario){
			$this->validate->setData($usuario);
			$this->validate->validateField('txtNome', array('required'), 'Nome deve ser informado');
			$this->validate->validateField('txtLogin', array('required'), 'Login deve ser informado');
			$this->validate->validateField('txtSenha', array('required'), 'Senha deve ser informada');
			return $this->validate->existsErrors();
		}

		/**
		 * 
		 * @return boolean
		 * @param $usuario $_POST
		 */
		function validaAlterarUsuario($usuario){
			$this->validate->setData($usuario);
			$this->validate->validateField('txtNome', array('required'), 'Nome deve ser informado');
			$this->validate->validateField('txtLogin', array('required'), 'Login deve ser informado');			
			return $this->validate->existsErrors();
		}

		function getMenuByUsuarioId($usuarioId){
			$menu = '';
			$empresas = $this->getEmpresasGruposAcessos($usuarioId);
			foreach ($empresas as $empresa) {
				$menu.= '<li><span>'.$empresa->nome.'</span><ul style="background: none !important;">';
				$perfis = $this->perfilModel->getPerfisGrupoAcessoByUsuarioIdEmpresaId($usuarioId, $empresa->empresa_id);
				foreach ($perfis as $perfil){
					$menu.= '<li class="closed"><span>'.$perfil->nome_perfil.'</span><ul style="background: none !important;">';
					$programasParent = $this->getProgramas($usuarioId, $perfil->id, 0, $empresa->empresa_id);

					foreach ($programasParent as $programaParent) {
						if($this->verificaAcessoPrograma($usuarioId, $empresa->empresa_id, $perfil->id, $programaParent->programa_id)){
							$menu.= '<li class="closed"><span>';
							if($programaParent->link == '')
								$menu.= $programaParent->nome_programa;
							else
								$menu.= '<a href="'.base_url().$programaParent->link.'">'.$programaParent->nome_programa.'</a>';
	
							$menu.= '</span>';
							$programas = $this->getProgramas($usuarioId, $perfil->id, $programaParent->programa_id, $empresa->empresa_id);
							if(count($programas) > 0){
								$menu.='<ul style="background: none !important;">';
								foreach ($programas as $programa)
								if($this->verificaAcessoPrograma($usuarioId, $empresa->empresa_id, $perfil->id, $programa->programa_id))
									$menu.= '<li><a href="'.base_url().$programa->link.'">'.$programa->nome_programa.'</a></li>';
	
								$menu.= '</ul></li>';	
							}	
						}
					}
					$menu.= '</ul></li>';
				}
				$menu.= '</ul></li>';
			}
			return $menu;
		}
		
		function getMenuPermissoesByUsuarioId($usuarioId){
			$menu = '';
			$empresas = $this->getEmpresasUsuarioCombo($usuarioId);
			foreach ($empresas as $empresa) {
				$menu.= '<li><span>'.$empresa->nome.'</span><ul style="background: none !important;">';
				$perfis = $this->perfilModel->getPerfisByUsuarioIdEmpresaId($usuarioId, $empresa->empresa_id);
				foreach ($perfis as $perfil){
					$menu.= '<li><span>'.$perfil->nome_perfil.'</span><ul style="background: none !important;">';
					$programasParent = $this->getProgramas($usuarioId, $perfil->id, 0, $empresa->empresa_id);

					foreach ($programasParent as $programaParent) {
						$menu.= '<li><span><input type="checkbox" id="programa-'.$perfil->id.'-'.$programaParent->programa_id.'" name="programas_acessos[]" value="'.$empresa->empresa_id.'chr'.$perfil->id.'chr'.$programaParent->programa_id.'" style="margin: 0px 2px;" '.($this->verificaAcessoPrograma($usuarioId, $empresa->empresa_id, $perfil->id, $programaParent->programa_id) ? 'checked' : '').' />'.$programaParent->nome_programa;

						$menu.= '</span><ul style="background: none !important;">';
						$programas = $this->getProgramas($usuarioId, $perfil->id, $programaParent->programa_id, $empresa->empresa_id);
						foreach ($programas as $programa)
							$menu.= '<li><input type="checkbox" id="programa-'.$perfil->id.'-'.$programa->programa_id.'" name="programas_acessos[]" value="'.$empresa->empresa_id.'chr'.$perfil->id.'chr'.$programa->programa_id.'" style="margin: 0px 2px;" '.($this->verificaAcessoPrograma($usuarioId, $empresa->empresa_id, $perfil->id, $programa->programa_id) ? 'checked' : '').' /><span id="p-'.$programa->programa_id.'-'.$programa->perfil.'-'.$usuarioId.'" style="margin: 0px; display: block; float: left;">'.$programa->nome_programa.'</span><button id="'.$programa->programa_id.'-'.$programa->perfil.'-'.$usuarioId.'" style="margin: -2px 2px; padding: 0px; height: 20px; font-size: 9px;" class="permissoes"/>permissões</button></li>';

						$menu.= '</ul></li>';
					}
					$menu.= '</ul></li>';
				}
				$menu.= '</ul></li>';
			}
			return $menu;
		}

		function getProgramas($usuarioId, $perfil, $programaPai=0, $empresaId){
  			$sql = 'select p.id as perfil, p.nome_perfil, pp.programa_id, pp.programa_pai, pp.ordem, pr.nome_programa, pr.link
					  from usuarios_perfis as up
					  join perfis as p
						on up.perfil_id = p.id
					  join empresas_perfis as ep
						on up.perfil_id = ep.perfil_id
							and up.empresa_id = ep.empresa_id
					  join perfis_programas as pp
						on pp.perfil_id = p.id
					  join programas as pr
						on pp.programa_id = pr.id
					 where up.usuario_id = '.$usuarioId.'
					   and pp.programa_pai = '.$programaPai.'
					   and p.id = '.$perfil.'
					   and ep.empresa_id = '.$empresaId.'
					 union
					select p.id as perfil, p.nome_perfil, pp.programa_id, pp.programa_pai, pp.ordem, pr.nome_programa, pr.link
					  from usuarios as u
					  join usuarios_grupos_acessos as uga
						on u.id = uga.usuario_id
					  join grupos_acessos_empresas as gae
						on uga.grupo_acesso_id = gae.grupo_acesso_id
					  join grupos_acessos_perfis as gap
						on uga.grupo_acesso_id = gap.grupo_acesso_id
							and gae.empresa_id = gap.empresa_id
					  join perfis as p
						on p.id = gap.perfil_id 
					  join perfis_programas as pp
						on pp.perfil_id = p.id
					  join programas as pr
						on pp.programa_id = pr.id
					 where u.id = '.$usuarioId.'
					   and pp.programa_pai = '.$programaPai.'
					   and p.id = '.$perfil.'
					   and gap.empresa_id = '.$empresaId.'
					 order by ordem asc';
			return $this->db->query($sql)->result();
		}

		function getMenu($perfilId) {
			$strMenu = "<ul id='nav'>";
			$this->db->select('p.id, p.nome_programa as nome, p.link, p.onclick');
			$this->db->from('programas as p');
			$this->db->join('perfis_programas as pp', 'pp.programa_id = p.id');
			$this->db->where('pp.perfil_id', $perfilId);
			$this->db->where('pp.programa_pai', 0);
			$this->db->where('pp.flg_ativo', 'S');
			$this->db->orderby('pp.ordem', 'asc');
			$programas = $this->db->get();
			
			foreach($programas->result() as $programa){
				$this->db->select('p.id, p.nome_programa as nome, p.link, p.onclick');
				$this->db->from('programas as p');
				$this->db->join('perfis_programas as pp', 'pp.programa_id = p.id');
				$this->db->where('pp.perfil_id', $perfilId);
				$this->db->where('pp.programa_pai', $programa->id);
				$this->db->where('pp.flg_ativo', 'S');
				$this->db->orderby('pp.ordem', 'asc');
				$subProgramas = $this->db->get();
				
				if($subProgramas->num_rows == 0)
					$strMenu .= "<li class='no-arrow'>";
				else
					$strMenu .= "<li>";
				
				if($programa->link == ''){
					if($programa->onclick == ''){
						$strMenu .= "<a href='javascript:;'>$programa->nome</a>";
					}else{
						$strMenu .= "<a style='cursor:pointer' onclick='$programa->onclick'>$programa->nome</a>";
					}
				}else{
					$strMenu .= anchor($programa->link, $programa->nome);
				}
				
				if($subProgramas->num_rows() > 0){
					$strMenu .= "<ul>";
					foreach($subProgramas->result() as $subPrograma){
						$strMenu .= "<li>";
						$strMenu .= anchor($subPrograma->link, $subPrograma->nome);
						$strMenu .= "</li>";
					}
					$strMenu .= "</ul>";
				}
				$strMenu .= "</li>";
			}

			$strMenu .= "</ul>";
			return $strMenu;
		}

		function incluirProgramasAcessos($usuario_programas_acessos){
			$retErro = $this->validaIncluirProgramasAcessos($usuario_programas_acessos);
			if($retErro)
				return false;

			$this->db->trans_begin();

				$this->db->where('usuario_id', $usuario_programas_acessos['txtIdUsuarioProgramaAcesso']);
				$this->db->delete('usuarios_programas_acessos');

				$empresa_id = '';
				$a_programa_acessos = @$usuario_programas_acessos['programas_acessos'];
				for($i = 0; $i < count($a_programa_acessos); $i++){
					$a_programa_empresa = explode('chr', $a_programa_acessos[$i]);

					$this->db->set('usuario_id', $usuario_programas_acessos['txtIdUsuarioProgramaAcesso']);
					$this->db->set('empresa_id', $a_programa_empresa[0]);
					$this->db->set('perfil_id', $a_programa_empresa[1]);
					$this->db->set('programa_id', $a_programa_empresa[2]);
					$this->db->insert('usuarios_programas_acessos');
				}

				$sql = 'delete
						  from sys_permissoes
						 where id in (select sp.id
									  from sys_permissoes as sp
									  join sys_metodos as sm
									    on sp.sys_metodo_id = sm.id
									 where sp.usuario_id = '.$usuario_programas_acessos['txtIdUsuarioProgramaAcesso'].'
									   and sm.classe not in (select p.link
														       from usuarios_programas_acessos as upa
														       join programas as p
															 on upa.programa_id = p.id
														      where upa.usuario_id = '.$usuario_programas_acessos['txtIdUsuarioProgramaAcesso'].'))';
				$this->db->query($sql);

				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}

			$this->db->trans_commit();
			return true;
		}
		
		function getPermissoesUsuario($usuarioId, $programaId){
			$programa = $this->programaModel->getPrograma($programaId);
			$metodosPrograma = $this->permissaoModel->getMetodos($programa->link);
			
			$aMetodosPrograma = array();			
			foreach ($metodosPrograma as $metodoPrograma)
				array_push($aMetodosPrograma, $metodoPrograma->id);
			
			if(count($aMetodosPrograma) > 0){
				$this->db->where_in('sys_metodo_id', $aMetodosPrograma);
				$this->db->where('usuario_id', $usuarioId);
				return $this->db->get('sys_permissoes')->result();	
			}else{
				return null;
			}
		}

		function salvarGruposAcessos($grupoAcesso){
			$this->db->trans_start();
				$this->db->where('usuario_id', $grupoAcesso['txtIdUsuarioGrupoAcesso']);
				$this->db->delete('usuarios_grupos_acessos');

				if($grupoAcesso['txtGruposAcessos'] != ''){
					$idGruposAcessos = explode(',', $grupoAcesso['txtGruposAcessos']);
					for($i = 0; $i < count($idGruposAcessos); $i++){
						$this->db->set('usuario_id', $grupoAcesso['txtIdUsuarioGrupoAcesso']);
						$this->db->set('grupo_acesso_id', $idGruposAcessos[$i]);
						$this->db->insert('usuarios_grupos_acessos');
					}
				}

			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtIdUsuarioGrupoAcesso', lang('registroNaoGravado'));
				return false;
			}

			$this->db->trans_commit();
			return true;
		}

		function salvarPermissoes($permissoes){
			$this->db->trans_start();
				$programa = $this->programaModel->getPrograma($permissoes['programaId']);
				$metodosPrograma = $this->permissaoModel->getMetodos($programa->link);
				$aMetodosPrograma = array();

				foreach ($metodosPrograma as $metodoPrograma)
					array_push($aMetodosPrograma, $metodoPrograma->id);

				if(count($aMetodosPrograma) > 0){
					$this->db->where_in('sys_metodo_id', $aMetodosPrograma);
					$this->db->where('usuario_id', $permissoes['usuarioId']);
					$this->db->delete('sys_permissoes');
				}
				
				if($permissoes['metodos'] != ''){
					$metodos = explode(',', $permissoes['metodos']);
					$ExcluirCursos = array();
					for($i = 0; $i < count($metodos); $i++)
						if($metodos[$i] != 'undefined'){
							$this->db->set('sys_metodo_id', $metodos[$i]);
							$this->db->set('usuario_id', $permissoes['usuarioId']);
							$this->db->insert('sys_permissoes');
						}
				}				

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function verificaAcessoPrograma($usuario_id, $empresa_id, $perfil_id, $programa_id){
			$sql = 'select empresa_id, perfil_id, programa_id
					  from usuarios_programas_acessos
					 where usuario_id = '.$usuario_id.'
					   and empresa_id = '.$empresa_id.'
					   and perfil_id = '.$perfil_id.'
					   and programa_id = '.$programa_id.'
					 union
					select gap.empresa_id, gap.perfil_id, gap.programa_id
					  from usuarios as u
					  join usuarios_grupos_acessos as uga
						on u.id = uga.usuario_id
					  join grupos_acessos_empresas as gae
						on uga.grupo_acesso_id = gae.grupo_acesso_id
					  join grupos_acessos_programas as gap
						on uga.grupo_acesso_id = gap.grupo_acesso_id
							and gae.empresa_id = gap.empresa_id
					 where u.id = '.$usuario_id.'
					   and gap.empresa_id = '.$empresa_id.'
					   and gap.perfil_id = '.$perfil_id.'
					   and gap.programa_id = '.$programa_id;
			$programa_acesso = $this->db->query($sql)->row();
			return (@$programa_acesso->programa_id != '' ? true : false);
		}

		function validaIncluirProgramasAcessos($usuario_programas_acessos){
			$this->validate->setData($usuario_programas_acessos);
			$this->validate->validateField('txtIdUsuarioProgramaAcesso', array('required'), lang('usuarioDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}