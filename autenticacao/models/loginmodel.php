<?php

/**
 * Classe responsavel por buscar as informações do banco
 * @package autenticacao
 */
	class LoginModel extends Model {
		
		function __construct (){
			parent::__construct();
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $login $_POST
		 */
		function validaUsuario ($login){
			if(!$this->validaCampos($login)){
				$this->db->select('u.id, u.pessoa_id, u.login, u.senha, p.nome as nome_pessoa, p.email, u.avatar_id, up.nome_gerado, up.nome_original, u.tema', false);
				$this->db->from('usuarios as u');
				$this->db->join('uploads as up', 'up.id = u.avatar_id', 'left');
				$this->db->join('pessoas as p', 'p.id = u.pessoa_id');
				$this->db->where('p.email', $login['txtEmail']);
				$this->db->or_where('u.login', $login['txtEmail']);
				$this->db->or_where('p.cpf', $login['txtEmail']);
				$query = $this->db->get();				
				if($query->num_rows() > 0){
					$usuario = $query->row();					
					if($usuario->senha != $this->encrypt->sha1($login['txtSenha'])){
						$this->validate->addError('txtSenha', lang('loginDadosInvalidos'));
						return false;
					}else{						
						$this->session->set_userdata('usuario', json_encode($usuario));
						setcookie('92c29c1ac4d85b45639f741599c24cd7', true, 0, PATH_COOKIE);
						setcookie('tema', $usuario->tema, 0, PATH_COOKIE);
						setcookie('avatar', $usuario->nome_gerado, 0, PATH_COOKIE);
						return true;
					}
				}else{
					$this->validate->addError('txtEmail', lang('loginDadosInvalidos'));
					return false;
				}
			}else{
				return false;
			}
		}

		function autenticaUsuarioById ($id){			
			$this->db->select('u.id, u.pessoa_id, u.login, u.senha, p.nome as nome_pessoa, p.email, u.avatar_id, up.nome_gerado, up.nome_original, u.tema', false);
			$this->db->from('usuarios as u');
			$this->db->join('uploads as up', 'up.id = u.avatar_id', 'left');
			$this->db->join('pessoas as p', 'p.id = u.pessoa_id');
			$this->db->where('u.id', $id);			
			$usuario = $this->db->get()->row();
			
			$this->session->set_userdata('usuario', json_encode($usuario));
			setcookie('92c29c1ac4d85b45639f741599c24cd7', true, 0, PATH_COOKIE);
			setcookie('tema', $usuario->tema, 0, PATH_COOKIE);
			setcookie('avatar', $usuario->nome_gerado, 0, PATH_COOKIE);					
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $word string
		 */
		function validaCaptcha($word){
			$exp = time()-120;
			$this->db->where('word', $word);
			$this->db->where('ip_address', $this->input->ip_address());
			$this->db->where('captcha_time >', $exp);
			$result = $this->db->get('captcha');			
			if($result->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}
		
		/**
		 * 
		 * @return boolean
		 * @param $dados $_POST
		 */
		function validaCampos($dados){
			$this->validate->setData($dados);
			$this->validate->validateField('txtEmail', array('required'), lang('loginObrigatorio'));
			$this->validate->validateField('txtSenha', array('required'), lang('loginSenhaObrigarotia'));
			return $this->validate->existsErrors();
		}

	}

?>