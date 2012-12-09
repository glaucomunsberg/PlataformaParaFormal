<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_filter extends Filter {

    function before() {
        if (@$_COOKIE['tema'] == '')
            setcookie('tema', 'redmond', 0, PATH_COOKIE);

        if (@$_COOKIE['92c29c1ac4d85b45639f741599c24cd7'] == '')
            $this->_logout_redirect();

        if (!IS_AJAX) {
            $URL = "http" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "s" : "") . "://" . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI'];

            if (!in_array($URL, array(BASE_URL . "autenticacao/login/sair", BASE_URL . "autenticacao/login", BASE_URL . "dashboard/"))) {
                setcookie('redirect', $_SERVER['REQUEST_URI'], 0, PATH_COOKIE);
            }
        }
    }

    function after() {
        $CI = & get_instance();
        $isLoadExtensionMongo = array_search('mongo', (get_loaded_extensions() !== false) ? array_map('strtolower', get_loaded_extensions()) : array());
        $acessoNegado = false;
        $url = explode('/', $_SERVER['REQUEST_URI']);
        $idPrograma = '';
        $nr_parameters = 0;
        while ($idPrograma == '') {
            $link = '';
            for ($i = 2; $i < count($url) - $nr_parameters; $i++)
                if ($link == '')
                    $link = $url[$i];
                else
                    $link.= '/' . $url[$i];

            $CI->db->where('link', $link);
            $programa = $CI->db->get('programas')->row();
            $idPrograma = isset($programa->id) ? $programa->id : '';
            $nr_parameters++;
        }

        if ($link != '' && $idPrograma != '') {
            if (@json_decode(@$CI->session->userdata('usuario'))->id == '') {
                $this->_logout_redirect();
            } else {
                $sql = 'select upa.id
						      from usuarios_programas_acessos as upa
						      join programas as p
							    on p.id = upa.programa_id
						     where upa.usuario_id = ' . json_decode($CI->session->userdata('usuario'))->id . '
						       and p.id = ' . $idPrograma . '
						     union
						    select gap.id
						      from usuarios as u
						      join usuarios_grupos_acessos as uga
							    on u.id = uga.usuario_id
						      join grupos_acessos_empresas as gae
							    on uga.grupo_acesso_id = gae.grupo_acesso_id
						      join grupos_acessos_programas as gap
							    on uga.grupo_acesso_id = gap.grupo_acesso_id
								    and gae.empresa_id = gap.empresa_id
                            where u.id = ' . json_decode($CI->session->userdata('usuario'))->id . '
                            and gap.programa_id = ' . $idPrograma;

                $usuarioProgramaAcesso = $CI->db->query($sql)->row();

                if (@$usuarioProgramaAcesso->id == '') {
                    /* if($isLoadExtensionMongo != ''){
                      $CI->mongo_db->insert('acessos', array('usuario_id' => json_decode($CI->session->userdata('usuario'))->id,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                      'url' => $_SERVER['REQUEST_URI'],
                      'acesso_negado' => true,
                      'post' => $_POST,
                      'navegador' => $_SERVER['HTTP_USER_AGENT'],
                      'dt_acesso' => new MongoDate()));
                      } */
                    show_error('<h1 style="float: left; margin: 0px 10px 10px 0px;">ACESSO NEGADO</h1><br /><h2 style="margin: 0px 10px 10px 0px;">' . lang('semPermissaoAcessarMetodo') . '</h2>');
                }
            }
        }

        if (@json_decode($CI->session->userdata('usuario'))->id == '') {
            $this->_logout_redirect();
        } else {
            /* if($isLoadExtensionMongo != ''){
              $CI->mongo_db->insert('acessos', array('usuario_id' => json_decode($CI->session->userdata('usuario'))->id,
              'ip' => $_SERVER['REMOTE_ADDR'],
              'url' => $_SERVER['REQUEST_URI'],
              'acesso_negado' => false,
              'post' => $_POST,
              'navegador' => $_SERVER['HTTP_USER_AGENT'],
              'dt_acesso' => new MongoDate()));
              } */
        }
    }

    private function _logout_redirect() {
        $url = BASE_URL . "autenticacao/login/sair";
        if (IS_AJAX) {
            setcookie('logout', true, 0, PATH_COOKIE);
        } else if (!headers_sent()) {
            header("Location: $url");
        } else {
            echo '<script type=\'text/javascript\'>'
            . "var l='$url';"
            . "if(location.href != l){location.href = l;}"
            . '</script>';
        }
    }

}
