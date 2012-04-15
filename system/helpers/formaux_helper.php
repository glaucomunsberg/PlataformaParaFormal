<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Helper responsavel por manipular diversos componentes form do sistema
	 * @package helpers
	 * @subpackage form
	 */
	
	/**
	 * Retorna um componente input button HTML
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_button('btnTeste', 'Teste', 'functionJavaScriptTeste();', 
	 * 					80, array('style' => 'float: right;'));?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $name Nome do componente button [optional]
	 * @param string $value Valor do componente button [optional]
	 * @param string $onClick Funcao javascript [optional]
	 * @param int $width Largura do componente button [optional]
	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
	 */
	function form_button($name = '', $value = '', $onClick = '', $width = '50', $extra = '') {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';
		}
		$defaults = array('name' => $name, 'onClick' => $onClick, 'id' => $name, 'value' => $value, 'class' => 'button');
		//return "<input "._parse_form_attributes($extra, $defaults).$extra." />\n";
		return "<button "._parse_form_attributes($extra, $defaults).$extra." >$value</button>\n";
	}

	/**
	 * Retorna um componente buttonHit
	 * @access public
	 * @return string
	 * @param string $name Nome do componente buttonHit
	 * @param string $onclick Método javascript que será chamado ao clicar no botão
	 */
	function form_buttonHit($name='', $url='', $titleButtonHit='Título buttonhit', $widthWindow=500, $id='', $codigo='', $descricao=''){
		$form_buttonHit = form_hidden('txt'.humanize($name).'Id', $id);
		$form_buttonHit.= form_textField('txt'.humanize($name).'Codigo', $codigo, 100, '', '', array('style' => 'text-align: right;', 'onblur' => 'openInputTextHit(\''.$url.'/returnButtonHit'.humanize($name).'\', returnButtonHit'.humanize($name).', \''.'txt'.humanize($name).'Id\', \''.'txt'.humanize($name).'Codigo\', \''.'txt'.humanize($name).'Descricao\');'));
		$form_buttonHit.= '<button id="'.$name.'Button" onclick="openButtonHit(\''.$url.'/parent.returnButtonHit'.humanize($name).'\', \''.$titleButtonHit.'\', '.$widthWindow.');" style="margin: 0px 1px 0px -4px; height: 24px; display: block; float: left;" class="button-hit">Pesquisar</button>';
		$form_buttonHit.= form_textField('txt'.humanize($name).'Descricao', $descricao, 400, '', '', array('style' => 'text-align: left;', 'readonly' => true));
		return $form_buttonHit;
	}

	/**
	 * Retorna um componente label HTML
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_label('lblTeste', 'Teste', 100);?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $name Nome do componente label [optional]
	 * @param string $value Valor do componente label [optional]
	 * @param int $width Largura do componente label [optional]
	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
	 */
	function form_label($name = '', $value = '', $width = '50', $extra = '') {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';
		}else{
			$extra['style'] = ' width:' . $width .'px;';
		}
		$defaults = array('name' => $name, 'id' => $name,);
		return "<label "._parse_form_attributes($extra, $defaults)." >$value</label>\n";
	}
	
	function form_label_message(){
		
	}

 	/**
 	 * Retorna um componente input file HTML
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=form_file('userfile', '', 414, '', '', '', 1, array('id'=>'userfile'));?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $name Nome do componente input file [optional]
 	 * @param string $value Valor do componente input file
 	 * @param int $width Largura do componente input file [optional]
 	 * @param string $mask Marcara do componente input file [optional]
 	 * @param int $maxlength Maximo de caracteres permitido no componente input file [optional]
 	 * @param string $accept Tipo de arquivos permitidos no componente input file [optional]
 	 * @param int $max Maximo de arquivos inseridos no componente input file [optional]
 	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
 	 */
	function form_file($name='', $valueIdUpload='', $valueNameUpload='', $allowed_types='', $width='250', $methodReturnUpload='finishUpload', $extra='', $disable=false) {
		$form_file = form_hidden($name.'Id', $valueIdUpload);
		$form_file.= form_textField($name.'Name', $valueNameUpload, $width, '', '', array('readonly' => true));		
		$form_file.= '<button id="btn'.$name.'" name="btn'.$name.'" onclick="openWindow(BASE_URL+\'util/upload/choiceFile/'.$name.'Id'.'/'.$name.'Name/'.$methodReturnUpload.humanize($name).'/'.$allowed_types.'\', \''.lang('uploadChoiceFileTitle').'\', 600, false);" style="height: 24px; margin-left:0px; margin-bottom: 5px; margin-right: 5px;" class="ui-button ui-button-text-icon-primary ui-widget ui-state-default ui-corner-all">';
		$form_file.= '<span class="ui-button-icon-primary ui-icon ui-icon-newwin" style="float: left;"></span>Fazer upload';
		$form_file.= '</button>';
		return $form_file;
	}
	
	function form_image_webcam($name='', $valueIdUpload='', $valueNameUpload='', $width='250', $methodReturnUpload='finishUploadWebCam', $extra='', $disable=false) {
		$form_file = form_hidden($name.'Id', $valueIdUpload);
		$form_file.= form_textField($name.'Name', $valueNameUpload, $width, '', '', array('readonly' => true));		
		$form_file.= '<button id="btn'.$name.'" name="btn'.$name.'" onclick="openWindow(BASE_URL+\'util/webcam/choiceImagem/'.$name.'Id'.'/'.$name.'Name/'.$methodReturnUpload.humanize($name).'\', \'Visualização WebCam\', 560, false);" style="height: 24px; margin-left:0px; margin-bottom: 5px; margin-right: 5px;" class="ui-button ui-button-text-icon-primary ui-widget ui-state-default ui-corner-all">';
		$form_file.= '<span class="ui-button-icon-primary ui-icon ui-icon-newwin" style="float: left;"></span>Imagem WebCam';
		$form_file.= '</button>';
		return $form_file;
	}

	/**
	 * Retorna um componente input text HTML
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_moneyField('txtTeste','','80');?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $name Nome do componente input text [optional]
	 * @param string $value Valor do componente input text
	 * @param int $width Largura do componente input text [optional]
	 * @param int $maxlength Tamanho maximo do componente input text [optional]
	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
	 */
	function form_moneyField($name = '', $value , $width = '50', $maxlength = '8', $extra = '') {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';		
		}else{
			$extra['style'] = ' width:' . $width .'px;';
		}
		$defaults = array( 'type' => 'text', 'onkeypress' => 'return(currencyFormat(this,\'.\',\',\',event))','name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => $maxlength, 'length' => $maxlength, 'class' => 'input ',); 
		return "<input "._parse_form_attributes($extra, $defaults)." />\n";
	}		
 
 	/**
 	 * Retorna um componente textarea HTML
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_textArea('txtArea', '', 300, 2);?>
	 * </code>
	 * @access public
 	 * @return string
 	 * @param string $name Nome do componente textarea [optional]
 	 * @param string $value Valor componente textarea [optional]
 	 * @param int $width Largura do componete textarea [optional]
 	 * @param int $row Numero de linhas do componente textarea [optional]
 	 * @param int $maxlength Maximo de caracteres do componente textarea [optional]
 	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
 	 * @param boolean $disabled Desabilita o componente textarea [optional]
 	 */
	function form_textArea($name = '', $value = '' , $width = '100', $row = '4', $maxlength = '2000', $extra = '', $disabled=false) {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';		
		}else{
			$extra['style'] = ' width:' . $width .'px;';
		}	
		$defaults = array('name' => $name, 'id' => $name, 'rows' => $row, 'class' => 'ui-state-default ui-corner-all ',);
		if($disabled)
			$disabled = ' disabled';
			
		return "<textarea "._parse_form_attributes($defaults,$extra). $disabled.">".$value."</textarea>\n";
	}

	/**
	 * Retorna um componente textarea HTML utilizando um editor WYSIWYG usando a biblioteca NicEdit
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_textEditor('txtEditor', '', 420, 150, array('style' => 'margin-left: 0px;'));?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $name Nome do componente textarea com NicEdit [optional]
	 * @param string $value Valor do componente textarea com NicEdit [optional]
	 * @param int $width Larguro do componente textarea com NicEdit [optional]
	 * @param int $height Altura do componente textarea com NicEdit [optional]
	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
	 */
	function form_textEditor($name = '', $value = '', $width = 100, $height = 50, $extra = ''){
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px; height:'.$height.'px;';
			else
				$extra['style'] = ' width:' . $width .'px; height:'.$height.'px;';		
		}else{
			$extra['style'] = ' width:' . $width .'px; height:'.$height.'px;';
		}
	
		$defaults = array('name' => $name, 'id' => $name, 'class' => 'textEditor',);
		return "<div class='nicEdit'><textarea "._parse_form_attributes($defaults,$extra).">".$value."</textarea></div>\n";
	}

 	/**
 	 * Retorna um componente datePicker HTML
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=form_dateField('dateField');?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $name Nome do componente input text
 	 * @param string $value Valor do componente input text [optional]
 	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
 	 */
	function form_dateField($name, $value = '', $extra = ''){
		$disabled = '';
		$onblur = '';
		$disabledDatePicker = '';
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width: 80px;';
			else
				$extra['style'] = ' width: 80px;';
	
			if(array_key_exists("disabled", $extra))
				$disabled = "disabled='true'";
	
			if(array_key_exists("onblur", $extra))
				$onblur = 'onblur='.$extra['onblur'];
		}else{
			$extra['style'] = ' width: 80px;';
		}
		$defaults = array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => 10,  'class' => 'ui-state-default ui-corner-all datepicker',);

		if($disabled != ''){
			$disabledDatePicker = "<script type='text/javascript'>";
			$disabledDatePicker .= '	$(document).ready(function(){';
			$disabledDatePicker .= '    	$(\'#'.$name.'\').datepicker( "disable" );';
			$disabledDatePicker .= '	});';
			$disabledDatePicker .= "</script>";	
		}
		
		return "<input "._parse_form_attributes($extra, $defaults)."/>\n".$disabledDatePicker;
	}
 
 	/**
 	 * Retorna um componente input text HTML
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=form_textField('textField', '', 300);?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $name Nome do componente input text [optional]
 	 * @param string $value valor do componente input text
 	 * @param int $width Largura do comonente input text [optional]
 	 * @param string $mask Classe referente a mascara do componente input text [optional]
 	 * @param int $maxlength Maximo de caracteres no componente input text [optional]
 	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
 	 * @param boolean $disabled Desabilita o componente input text [optional]
 	 */
	function form_textField($name = '', $value , $width = '50', $mask = '', $maxlength = '255', $extra = '', $disabled = false) {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';
		}else{
			$extra['style'] = ' width:' . $width .'px;';
		}
		
		if($disabled)
			$disabled = ' disabled';
	
		$defaults = array( 'type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => $maxlength,  'class' => 'ui-state-default ui-corner-all '.$mask,);
		return "<input "._parse_form_attributes($extra, $defaults). $disabled." />\n";
	}
	
	function form_textFieldAutoComplete($name = '', $url, $key='', $value='', $width = '50', $mask = '', $maxlength = '255', $extra = '', $disabled = false) {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . ($width - 25) .'px;';
			else
				$extra['style'] = ' width:' . ($width - 25).'px;';
		}else{
			$extra['style'] = ' width:' . ($width - 25) .'px;';
		}
		
		if($disabled)
			$disabled = ' disabled';
	
		$formAutoComplete = "<script>";
		$formAutoComplete.= '	$(function() {';
		$formAutoComplete.= '		$("#search'.$name.'").autocomplete({';
		$formAutoComplete.= '			minLength: 3,';			
		$formAutoComplete.= '			source: function( request, response ) {';
		$formAutoComplete.= ' 				$.ajax({';
		$formAutoComplete.= ' 					url: "'.$url.'",';
		$formAutoComplete.= '					dataType: "json",';
		$formAutoComplete.= '					data: {autocomplete: true, q: request.term},';
		$formAutoComplete.= '					success: function( data ) {';
		$formAutoComplete.= '						response($.map(data.combo, function( item ) {';						
		$formAutoComplete.= '							return {label: item.optionName, value: item.optionName, valueHidden: item.value}';
		$formAutoComplete.= '						}));';
		$formAutoComplete.= '					}';
		$formAutoComplete.= '				});';
		$formAutoComplete.= '			},';
		$formAutoComplete.= '			select: function( event, ui ) {';
       	$formAutoComplete.= ' 				$("#'.$name.'").val(ui.item.valueHidden);';
       	$formAutoComplete.= "				try{".$name."_callback(); } catch(err){}";       	
		$formAutoComplete.= '			}';	
		$formAutoComplete.= " 		}).after('".'<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$key.'"  />'."');";
		
		$formAutoComplete.= '		$("#search'.$name.'").blur(function(){';
		$formAutoComplete.= '			if($("#search'.$name.'").val() == \'\'){';
		$formAutoComplete.= ' 				$("#'.$name.'").val(\'\');';
		$formAutoComplete.= '			}';
		$formAutoComplete.= '		});';		
		$formAutoComplete.= '	});';
		$formAutoComplete.= "</script>";

		$formAutoCompleteButtonSearch = '<div style="height: 22px; width: 25px; margin: 0px -1px 5px 0px; display: block; float: left; position: relative; padding: 0; text-decoration: none !important; text-align: center; zoom: 1; overflow: visible; border-right: none;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"><span class=" ui-icon ui-icon-search"></span></div>';
		$defaults = array( 'type' => 'text', 'value' => $value, 'name' => 'search'.$name, 'id' => 'search'.$name, 'maxlength' => $maxlength,  'class' => 'ui-state-default ui-corner-tr ui-corner-br '.$mask,);
		return $formAutoCompleteButtonSearch."<input "._parse_form_attributes($extra, $defaults). $disabled." />\n".$formAutoComplete;
	}

	/**
	 * Retorna um componente input select HTML
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_combo('cmbEmpresa', $empresas, '', 300);?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $name Nome do componente select [optional]
	 * @param array $options Array com a lista para montar o componente select [optional]
	 * @param string $selected Informa a linha que sera selecionada no compnente select [optional]
	 * @param int $width Largura do componente select [optional]
	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
	 * @param string $noClass Classe com o estilo do componente select [optional]
	 * @param boolean $disabled Informa se o componente select vai estar habilitado ou desabilitado [optional]
	 * @param boolean $multiple Informa se o componente select aceitara selecionar mais de um registro [optional]
	 */
	function form_combo($name = '', $options = array(), $selected = '', $width = '150', $extra = '', $noClass='select', $disabled=false, $multiple=false, $optGroup=false){
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';
		}else{
			$extra['style'] = ' width:' . $width .'px;';
		}
		
		$defaults = array( 'name' => $name, 'id' => $name);	
		if($disabled)
			$disabled = 'disabled';
		
		$form = '<select '. _parse_form_attributes($defaults, $extra). $disabled . ($multiple ? ' multiple ': '') .'>';
		if(!$multiple)
			$form .= "<option value=''>&nbsp;</option>\n";

		if(count($options)>0 && !empty($options)){
			$labelGroupCurrent = '';
			foreach ($options as $arrayObject){				
				$i = 0;
				foreach($arrayObject as $key => $value){
					switch ($i) {
						case 0:
							$optionValue = $value;
							$i++;
							break;
						case 1:
							$optionText = $value;
							($optGroup ? $i++ : $i=0);
							break;
						case 2:
							$optionGroup = $value;
							$i=0;
							break;
					}
				}
				$key = (string) $optionValue;
				$val = (string) $optionText;

				if($optGroup){
					$labelGroup = (string) $optionGroup;

					if($labelGroupCurrent == ''){
						$labelGroupCurrent = $labelGroup;
						$form .= '<optgroup label="'.$labelGroupCurrent.'">\n"';
					}elseif($labelGroup != $labelGroupCurrent){
						$labelGroupCurrent = $labelGroup;					
						$form .= '</optgroup>\n"';
						$form .= '<optgroup label="'.$labelGroupCurrent.'">\n"';
					}
				}

				$sel = ($selected != $key) ? '' : ' selected="selected"';
				$form .= '<option value="'.$key.'"'.$sel.'>'.$val."</option>\n";
			}
			
			if($optGroup)
				$form .= '</optgroup>\n"';

		}
		$form .= '</select>';
		$form .= "<script type='text/javascript'>";
		$form .= '	var '.$name.' = \''.$name.'\';';
		$form .= '	$(document).ready(function(){';		
		$form .= '    $(\'#'.$name.'\').selectmenu({style:\'dropdown\', width: '.($width+4).'});';
		$form .= '	});';
		$form .= "</script>";
		return $form;
	}
 
 	/**
 	 * Retorna a abertura da tag form do HTML convencional, porem com todas as propriedades para 
 	 * o envio das informacoes ser feita por ajax
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=begin_form('gerenciador/programa/salvar', 'formPrograma');?>
 	 * 		Aqui vai os componentes de formulario
 	 * <?=end_form();?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $action URL que vai receber as informacoes do form [optional]
 	 * @param string $idForm Identificador do componente form [optional]
 	 * @param array $attributes Array com opcoes de estilos e atributos extras [optional]
 	 * @param array $hidden Array para possibilitar criar campos ocultos [optional]
 	 */
	function begin_form($action = '', $idForm= 'formDefault', $attributes = array(), $hidden = array()){
		$CI =& get_instance();
	
		$form = '<form id="'.$idForm.'" action="'.$CI->config->site_url($action).'"';
		if ( ! isset($attributes['method']))
			$form .= ' method="post"';
		
		if (is_array($attributes) AND count($attributes) > 0){
			foreach ($attributes as $key => $val){
				$form .= ' '.$key.'="'.$val.'"';
			}
		}
	
		$form .= '>';
		if (is_array($hidden) AND count($hidden > 0))
			$form .= form_hidden($hidden);
		
		$form .= "<script language=\"JavaScript\">";		
		$form .= " function ".$idForm."_submit() { ";
		$form .= '    $(\'#'.$idForm.'\').ajaxSubmit({ ';
		$form .= "    dataType:'json', ";
		$form .= "    clearForm: false, ";		
		$form .= "	  beforeSubmit: " .$idForm . "_beforeSubmit,";
		$form .= "    success:  " .$idForm . "_sucefull ";
		$form .= "    });";
		$form .= " }";
		
		$form .= "function " .$idForm . "_sucefull(data) {";
		$form .= "    try{ ".$idForm."_callback(data); } catch(err){}";
		$form .= "}";
		
		$form .= "function " .$idForm . "_beforeSubmit(formData, jqForm, options) {";
		if (!isset($attributes['enctype']))			
			$form .= " return beforeSubmit(formData, jqForm, options, '".$idForm."');";

		$form .= "}";
		
		$form .= "</script>";
		
		return $form;
	}

	/**
	 * @ignore
	 * @return string
	 */
	function end_form(){
		return "</form>";
	}

 	/**
 	 * Retorna a abertura da tag fieldSet do HTML
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=begin_fieldset('Titulo FiledSet', 515, 132);?>
 	 * <?=end_fieldset();?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $name Nome do componente fieldSet HTML
 	 * @param int $width Largura do componente fieldSet HTML [optional]
 	 * @param int $height Altura do camponente fieldSet HTML [optional]
 	 */
	function begin_fieldset($name, $width = '', $height = '', $marginLeft = ''){
	    $style = "";
	    
	    if(!empty($width))
	    	$style .= "width:".$width."px; ";
	    
	    if(!empty($height))
	    	$style .= "height:".$height."px; ";    
	    	
	    if(!empty($marginLeft))
	    	$style .= "margin-left:".$marginLeft."px; ";
	    
		$html  = "<fieldset class=\"ui-widget ui-widget-content ui-corner-all\" style=\"$style background: none; padding: 5px;\">";            
	    $html .= "<legend class=\"legend\">$name</legend>";
		
		return $html;
	}

	/**
	 * @ignore
	 * @return string
	 */
	function end_fieldset(){	
		return "</fieldset>";
	}
	
	/**
	 * Retorna um componente input checkbox HTML
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=form_checkbox('chkTelefoneContato', 
	 * 					array('id'=>'chkTelefoneContato'), 
	 * 					'S', 
	 * 					(@$pessoaTelefone->contato == 'S' ? true : false));?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $name Nome do componete input checkbox HTML [optional]
	 * @param array $data Array com opcoes de estilos e atributos extras [optional]
	 * @param string $value Valor do componente input checkbox HTML[optional]
	 * @param boolean $checked Marca o componente input checkbox caso seja true [optional]
	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
	 * @param boolean $disabled Informa se o componente inputcheckbox vai estar habilitado ou desabilitado [optional]
	 */
	function form_checkbox($name = '', $data = '', $value = '', $checked = true, $extra = '', $disabled = '') {
		$defaults = array('type' => 'checkbox', 'name' => $name, 'value' => $value);
		
		if ($checked == false){
			if(is_array($data))
				unset($data['checked']);
		}else
			$data['checked'] = 'checked';
	
		return "<input "._parse_form_attributes($data, $defaults)._parse_form_attributes($extra, $defaults).$disabled." />\n";
	}

 	/**
 	 * Retorna o componente input radio HTML
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=form_radio('optInputRadio', 'optRadio', 'S');?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $id Propriedade Id do componente input radio
 	 * @param string $name Nome do compoente input radio [optional]
 	 * @param string $value Valor do componente input radio [optional]
 	 * @param boolean $checked Marca o componente input radio caso seja true [optional]
 	 * @param array $data Array com opcoes de estilos e atributos extras [optional]
 	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
 	 * @param boolean $disabled Informa se o componente input radio vai estar habilitado ou desabilitado [optional]
 	 */
	function form_radio($id, $name = '',  $value = '', $checked = TRUE, $data = '', $extra = '', $disabled = false) {
		if (!is_array($data))
			$data = array();
		
		$data['id'] = $id;
		$data['type'] = 'radio';
		
		if($disabled)
			$disabled = ' disabled';
		
		return form_checkbox($name, $data, $value, $checked, $extra, $disabled);
	}

	/**
 	 * Retorna um componente colorPicker HTML
 	 * Abaixo um exemplo de como usar nas views:
 	 * <code>
 	 * <?=form_ColorPicker('textColorPicker', '', 300);?>
 	 * </code>
 	 * @access public
 	 * @return string
 	 * @param string $name Nome do componente colorPicker [optional]
 	 * @param string $value valor do componente colorPicker
 	 * @param int $width Largura do comonente colorPicker [optional]
 	 * @param string $mask Classe referente a mascara do componente colorPicker [optional]
 	 * @param int $maxlength Maximo de caracteres no componente colorPicker [optional]
 	 * @param array $extra Array com opcoes de estilos e atributos extras [optional]
 	 * @param boolean $disabled Desabilita o componente colorPicker [optional]
 	 */
	function form_ColorPicker($name = '', $value , $width = '50', $mask = 'colorPicker', $maxlength = '255', $extra = '', $disabled = false) {
		if(is_array($extra)){
			if(array_key_exists("style", $extra))
				$extra['style'] = $extra['style'] .' width:' . $width .'px;';
			else
				$extra['style'] = ' width:' . $width .'px;';
		}else{
			$extra['style'] = ' width:' . $width .'px;';
		}
		
		if($disabled)
			$disabled = ' disabled';
	
		$defaults = array( 'type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => $maxlength,  'class' => $mask,);
		return "<input "._parse_form_attributes($extra, $defaults). $disabled." />\n";
	}
	
 	/**
 	 * Retorna uma quebra de linha
 	 * Abaixo um exemplo de como utilizar nas view:
 	 * <code>
 	 * <?=new_line();?>
 	 * </code>
 	 * @access public
 	 * @return string 
 	 * @param int $br Numero de linhas [optional]
 	 */
	function new_line($br = 0){		
		$newline = "<br />";
		for($i = 0; $i < $br; $i++){
			$newline .= "<br />";
		}
		return $newline;
	}
	
	function hr(){		
		return '<hr class="ui-state-default"/>';
	}

	function begin_GroupItem($name='', $width='100%', $title='', $closeContent=true){
		if($width != '100%')
			$styleWidth = 'width:'.$width.'px';
		else
			$styleWidth = 'width:'.$width;

		$form = "<div style='".$styleWidth."' class='group-item' id='group-item-".$name."'>";
		$form.= "	<h1 class='".($closeContent ? "title-group-item-more" : "title-group-item-less")."' id='".$name."'>".$title."</h1>";
		$form.= "	<div style='padding: 4px; display: ".($closeContent ? "none" : "block").";'>";
		return $form;
	}

	function end_GroupItem(){
		$form = "	</div>";
		$form.= new_line();
		$form.= "</div>";
		return $form;
	}
	
	function form_hidden($name, $value = '', $recursing = FALSE){
		static $form;

		if ($recursing === FALSE){
			$form = "\n";
		}

		if (is_array($name)){
			foreach ($name as $key => $val){
				form_hidden($key, $val, TRUE);
			}
			return $form;
		}

		if ( ! is_array($value)){
			$form .= '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.form_prep($value, $name).'" />'."\n";
		}else{
			foreach ($value as $k => $v){
				$k = (is_int($k)) ? '' : $k; 
				form_hidden($name.'['.$k.']', $v, TRUE);
			}
		}

		return $form;
	}

?>