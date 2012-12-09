<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helper responsavel por manipular a toolbar do sistema
 * @package helpers
 * @subpackage toolbar
 */

/**
 * abre a toolbar
 * 
 * @access public
 * @param array parametros
 * @param boolean buttonHit
 */
	function begin_ToolBar($parametros = null, $buttonHit=false) {
		$CI =& get_instance();
		$toolBar = '';
		$toolBar .= '<div class="ui-widget-content ui-corner-all toolbar">';

		if(!$buttonHit)
			if(liberaAcao('voltar-pagina',$parametros))
				 $toolBar .= '<button id="voltar-pagina" class="voltar-pagina" style="float: left;">Voltar página</button>';

		if(liberaAcao('pesquisar',$parametros))
			 $toolBar .= '<button id="pesquisar" class="pesquisar" title="Ctrl + enter" style="float: left;">Pesquisar</button>';

		if(!$buttonHit)
			if(liberaAcao('novo',$parametros))
				 $toolBar .= '<button id="novo" class="novo" title="Ctrl + N" style="float: left;">Novo</button>';

		if(!$buttonHit)
			if(liberaAcao('abrir',$parametros))
				 $toolBar .= '<button id="abrir" class="abrir" style="float: left;">Abrir</button>';

		if(!$buttonHit)
			if(liberaAcao('salvar',$parametros))
				 $toolBar .= '<button id="salvar" class="salvar" title="Ctrl + S" style="float: left;">Salvar</button>';

		if(!$buttonHit)
			if(liberaAcao('excluir',$parametros)) 
				 $toolBar .= '<button id="excluir" class="excluir" title="Ctrl + E" style="float: left;">Excluir</button>';

		if(!$buttonHit)
			if(liberaAcao('imprimir',$parametros)) 
				 $toolBar .= '<button id="imprimir" class="imprimir" title="Ctrl + I" style="float: left;">Imprimir</button>';

		if(!$buttonHit)
			if(liberaAcao('ajuda',$parametros))
				 $toolBar .= '<button id="ajuda" class="ajuda" style="float: right;">Ajuda</button>';

		return $toolBar;
	}
	
	/**
	 * Fecha a toolbar
	 * @access public
	 * @author rafael
	 */
	function end_ToolBar() {
		$toolBar = '<span style="clear: both; display: block"></span></div>';
		return $toolBar;
	}

	/**
	 * Adicionar botoes na toolbar
 * @param string $label texto
 * @param string $jsAction metodo javascript a ser chamado quando o botao for clicado
 * @param string $btnName identificador do elemento
 * @param string $icon classe de ícone que deseja colocar no botao
 * @param array $attributes Array com opções de estilos e atributos extras, no formato array(atributo => valor)
 * @return string
	 */
function addButtonToolBar($label, $jsAction, $btnName = '', $icon = '', $attributes = array()) {
    $defaults = array(
        "id" => $btnName,
        "name" => $btnName,
        "style" => "float: left;"
    );
    # if doesn't have float style set ;)
    if (isset($attributes['style']) && !preg_match("/float:/", $attributes['style'])) {
        $attributes['style'] = "float: left; " . $attributes['style'];
    }

    $conf = "{text: true";
    if (!empty($icon)) {
        $conf.= ", icons: {primary: '$icon'}";
    }
    $conf.= "}";

    $buttonToolbar = "<button " . _parse_form_attributes($attributes, $defaults) . ">$label</button>";

    return <<<EOF
    $buttonToolbar
    <script type="text/javascript">
        $(document).ready(function(){
            $('#$btnName').button('destroy');
            $('#$btnName').button($conf).click(function(){
                $('#$btnName').blur();
                try{
                    $jsAction;
                }catch(err){
                    messageErrorBox('Erro ao executar o método $jsAction ' + err);
                }
            });
        });
    </script>
EOF;
	}

	/**
	 * Verifica se foi informado o botao de acao
	 * @access private
	 * @author rafael
	 * @param string acao que deseja exibir
	 * @param array todas as acoes do disponiveis na toolbar
	 * @return boolean retorna true caso contenha a acao desejada
	 */
	function liberaAcao($acao,$arrayAcao) {
		if(!is_array($arrayAcao))
			return true;
		
		if(!in_array($acao,$arrayAcao))
			return true;
		else 
			return false;
	}