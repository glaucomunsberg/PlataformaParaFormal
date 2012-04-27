<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Helpers responsáveis por gerar diversos elementos de interface nas páginas do sistema.<br>
 * Os elementos gerados seguem o estilo da interface padrão do Cobalto.
 * @package helpers
 * @subpackage form
 */

/**
 * Inicia um formulário HTML com propriedades extras para ser utilizado pelo Cobalto.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?= begin_form('gerenciador/programa/salvar', 'formPrograma'); ?>
 *     	Aqui vão os componentes do formulário
 * <?= end_form(); ?>
 * </code>
 * @param string $action URL que vai receber as informacoes do form (via ajax)
 * @param string $idForm Identificador do formulário
 * @param array $attributes Array com opções de estilos e atributos extras
 * @param array $hidden Array para possibilitar criar campos ocultos automaticamente<br>
 * O array deve estar no formato array(id => valor), como array("txtCodigo" => 120, "txtDescricao" => "descrição aqui")
 * @return string O código HTML para gerar o formulário
 * @see end_form
 */
function begin_form($action = '', $idForm = 'formDefault', $attributes = array(), $hidden = array()) {
    $CI = & get_instance();

    $form = '<form id="' . $idForm . '" action="' . $CI->config->site_url($action) . '"';
    if (!isset($attributes['method'])) {
        $form .= ' method="post"';
    }

    if (is_array($attributes) AND count($attributes) > 0) {
        foreach ($attributes as $key => $val) {
            $form .= ' ' . $key . '="' . $val . '"';
        }
    }

    $form .= '>';
    if (is_array($hidden) AND count($hidden > 0)) {
        $form .= form_hidden($hidden);
    }

    $form .= "<script language=\"JavaScript\">";
    $form .= " function " . $idForm . "_submit() { ";
    $form .= "    $('#$idForm').ajaxSubmit({ ";
    $form .= "    dataType:'json', ";
    $form .= "    clearForm: false, ";
    $form .= "    beforeSubmit: {$idForm}_beforeSubmit,";
    $form .= "    success:  {$idForm}_sucefull ";
    $form .= "    });";
    $form .= " }";

    $form .= "function {$idForm}_sucefull(data) {";
    $form .= "    try{ {$idForm}_callback(data); } catch(err){}";
    $form .= "}";

    $form .= "function {$idForm}_beforeSubmit(formData, jqForm, options) {";
    if (!isset($attributes['enctype'])) {
        $form .= " return beforeSubmit(formData, jqForm, options, '$idForm');";
    }
    $form .= "}";

    $form .= "</script>";

    return $form;
}

/**
 * Encerra o formulário criado com o {@link begin_form()}
 * @return string O código para finalizar o formulário
 * @see begin_form
 */
function end_form() {
    return "</form>";
}

/**
 * Cria um rótulo de texto.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?= form_label('lblExemplo', 'Exemplo', 100); ?>
 * </code>
 * @param string $name Nome para identificação do rótulo
 * @param string $value Valor do rótulo
 * @param integer $width Largura em pixels, padrão 50
 * @param array $attributes Array com opções de estilos e atributos extras
 * @return string
 */
function form_label($name = '', $value = '', $width = '50', $attributes = '') {
    if (is_array($attributes) && array_key_exists("style", $attributes)) {
        $attributes['style'] = $attributes['style'] . _style_width($width);
    } else {
        $attributes['style'] = _style_width($width);
    }
    $defaults = array('name' => $name, 'id' => $name,);
    return "<label " . _parse_form_attributes($attributes, $defaults) . " >$value</label>\n";
}

/**
 * Gera um campo de texto.<br>
 * Exemplos de uso nas views:
 * <code>
 * <?= form_textField('txtExemplo', '', 300); ?>
 * </code>
 * <code>
 * <?= form_textField('txtExemplo', @$valor, 300); ?>
 * </code>
 * <i>NOTA: O '@' é utilizado para suprimir mensagens de erro caso a variável ($valor) não esteja declarada.
 * O efeito é o mesmo de que se a variável estivesse em branco.</i>
 * @param string $name Nome para identificação do campo. Por padrão utiliza-se CamelCase com txt minúsculo como prefixo.<br>
 * Exemplos: txtCampo, txtPessoaNome, txtCpf, txtCodigo
 * @param string $value Valor inicial do campo
 * @param integer $width Largura em pixels, padrão 50
 * @param string $mask Classe CSS, utilizada para aplicação de mascaramento no campo
 * @param integer $maxlength Quantidade máxima de caracteres no campo
 * @param array $attributes Array com opções de estilos e atributos extras, no formato array(atributo => valor)
 * @param boolean $disabled Desabilita a edição do campo
 * @return string O código HTML para gerar o campo
 */
function form_textField($name = '', $value = '', $width = '50', $mask = '', $maxlength = '255', $attributes = '', $disabled = false) {
    if (is_array($attributes) && array_key_exists("style", $attributes)) {
        $attributes['style'] = $attributes['style'] . _style_width($width);
    } else {
        $attributes['style'] = _style_width($width);
    }

    if ($disabled) {
        $disabled = ' disabled';
    }
    $nameComponentJavaScript = "<script>var $name = $('#$name');</script>";

    $defaults = array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => $maxlength, 'class' => 'ui-state-default ui-corner-all ' . $mask,);
    return "<input " . _parse_form_attributes($attributes, $defaults) . $disabled . " />\n$nameComponentJavaScript\n";
}

/**
 * Gera uma quebra de linha. É recomendado seu uso em vez de inserir quebras de linha manuais.<br>
 * Abaixo um exemplo de como utilizar nas view:<br>
 * <code>
 * <?= new_line(); ?>
 * </code>
 * @param integer $br Numero de linhas consecutivas adicionais
 * @return string O código HTML que gera a nova linha
 */
function new_line($br = 0) {
    $newline = "<br />";
    for ($i = 0; $i < $br; $i++) {
        $newline .= "<br />";
    }
    return $newline;
}

/**
 * Gera uma linha horizontal.<br>
 * Exemplo:
 * <code>
 * <?= hr(); ?>
 * </code>
 * @return string O código HTML para gerar o elemento
 */
function hr() {
    return '<hr class="ui-state-default"/>';
}

/**
 * Gera a exibição do componente re-captcha para auxiliar na segurança do sistema.<br>
 * Exemplo:
 * <code>
 * <?=recaptcha();?>
 * </code>
 * @return string O HTML com a exibição de uma imagem aleatório e o campo para digitar as palavras exibidas na imagem
 */
function recaptcha() {
    $recaptcha = "<script type='text/javascript'>
						var RecaptchaOptions = {
							theme : 'custom',
							custom_theme_widget: 'recaptcha_widget'
						};

						function init(){
							$('#obterNovaImagemRecaptcha').button({text: true, icons: {primary: 'ui-icon-refresh'}});
						}
					</script>";
    $recaptcha .= "<div id='recaptcha_widget''>
					<div style='float: left; padding: 5px;' class='ui-state-highlight ui-widget ui-widget-content ui-corner-all'>
						<div id='recaptcha_image' style='margin-bottom: 5px; text-align: center;'></div>
						<div class='recaptcha_only_if_incorrect_sol' style='color:red'>Buscando imagem ...</div>";
    $recaptcha .= form_label('recaptcha_only_if_image', 'Informe as palavras acima', 150, array('style' => 'font-weight: bold;'));
    $recaptcha .= "		<a id='obterNovaImagemRecaptcha' href='javascript:Recaptcha.reload()' style='margin: 0px 5px 5px 5px; float: right;'>Obter nova imagem</a>";
    $recaptcha .= new_line();
    $recaptcha .= form_textField('recaptcha_response_field', '', 300);
    $recaptcha .= "</div></div>";

    return $recaptcha . recaptcha_get_html(KEY_RECAPTCHA, null, true);
}

/**
 * Gera um campo de data (datePicker) para seleção de data.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?= form_dateField('dtCadastro'); ?>
 * </code>
 * @param string $name Nome do campo
 * @param string $value Valor do campo
 * @param array $attributes Array com opções de estilos e atributos extras
 * @param boolean $disabled TRUE para desabilitar a edição do campo
 * @return string
 * @todo caso a data esteja no formato "cru" do banco de dados, deve ser corrigida para o formato ideal
 */
function form_dateField($name, $value = '', $attributes = '', $disabled = false) {
    if (!is_array($attributes)) {
        $attributes = array();
    }
    if (array_key_exists('style', $attributes)) {
        $attributes['style'] = $attributes['style'] . ' width: 80px;';
    } else {
        $attributes['style'] = ' width: 80px;';
    }
    if (array_key_exists('disabled', $attributes)) {
        $disabled = true;
    } elseif ($disabled == true) {
        $attributes['disabled'] = "disabled";
    }

    $defaults = array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => 10, 'class' => 'ui-state-default ui-corner-all datepicker');

    $jsDatePicker = "<script type='text/javascript'>";
    $jsDatePicker .= "var $name = $('#$name');";
    if ($disabled) {
        $jsDatePicker .= "\$(document).ready(function(){ $name.datepicker('disable'); });";
    }
    $jsDatePicker .= "</script>";

    return "<input " . _parse_form_attributes($attributes, $defaults) . "/>\n" . $jsDatePicker;
}

/**
 * Retorna um componente select.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?=form_combo('cmbEmpresa', $lista_empresas, '', 300);?>
 * <?=form_combo('cmbEmpresa', $lista_empresas, @$empresa_selecionada, 300);?>
 * </code>
 * @param string $name Nome do componente select
 * @param array $options Array com a lista para montar o componente select<br>
 * No formato array(
 * 		array(id => valor),
 * 		array(texto => valor2)
 * ).<br>
 * Um <i>result()</i> do banco de dados pode ser utilizado também, sendo que geralmente se seleciona "id, nome" para montar as combos
 * @param string $selected Informa a linha que será selecionada no select, geralmente o "id" do item a ser selecionado
 * @param integer $width Largura em pixels, padrão 150
 * @param array $extra Array com opções de estilos e atributos adicionais, padrão vazio
 * @param boolean $disabled TRUE se o select vai estar habilitado ou desabilitado, padrão FALSE
 * @param boolean $multiple TRUE se o select aceitar seleção múltipla, padrão FALSE
 * @return string
 */
function form_combo($name = '', $options = array(), $selected = '', $width = '150', $extra = '', $disabled = false, $multiple = false, $optGroup = false) {
    if (is_array($extra) && array_key_exists("style", $extra)) {
        $extra['style'] = $extra['style'] . _style_width($width);
    } else {
        $extra['style'] = _style_width($width);
    }

    $defaults = array('name' => $name, 'id' => $name);
    if ($disabled) {
        $disabled = 'disabled';
    }
    $combo = '<select ' . _parse_form_attributes($defaults, $extra) . $disabled . ($multiple ? ' multiple ' : '') . '>';
    if (!$multiple) {
        $combo .= "<option value=''>&nbsp;</option>\n";
    }
    if (count($options) > 0 && !empty($options)) {
        $labelGroupCurrent = '';
        foreach ($options as $arrayObject) {
            $i = 0;
            foreach ($arrayObject as $key => $value) {
                switch ($i) {
                    case 0:
                        $optionValue = $value;
                        $i++;
                        break;
                    case 1:
                        $optionText = $value;
                        ($optGroup ? $i++ : $i = 0);
                        break;
                    case 2:
                        $optionGroup = $value;
                        $i = 0;
                        break;
                }
            }
            $key = (string) $optionValue;
            $val = (string) $optionText;

            if ($optGroup) {
                $labelGroup = (string) $optionGroup;

                if ($labelGroupCurrent == '') {
                    $labelGroupCurrent = $labelGroup;
                    $combo .= '<optgroup label="' . $labelGroupCurrent . '">\n"';
                } elseif ($labelGroup != $labelGroupCurrent) {
                    $labelGroupCurrent = $labelGroup;
                    $combo .= '</optgroup>\n"';
                    $combo .= '<optgroup label="' . $labelGroupCurrent . '">\n"';
                }
            }

            $sel = ($selected != $key) ? '' : ' selected="selected"';
            $combo .= '<option value="' . $key . '"' . $sel . '>' . $val . "</option>\n";
        }

        if ($optGroup)
            $combo .= '</optgroup>\n"';
    }
    $combo .= '</select>';
    $combo .=
            "<script type='text/javascript'>
            var $name = '$name';
            $(document).ready(function(){
                $('#$name').selectmenu({style:'dropdown', width: " . ($width + 4) . "});
            });
        </script>";
    return $combo;
}

/**
 * Retorna um botão. O elemento aceita uma chamada javascript para executar quando clicado.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?= form_button('btnTeste', 'Teste', 'functionJavaScriptTeste()',
 *     80, array('style' => 'float: right;')); ?>
 * </code>
 * @param string $name Nome para identificação do botão
 * @param string $value Valor do botão
 * @param string $onClick Código javascript a ser executado quando clicar no botão, geralmente o nome de uma função javascript implementado na mesma view
 * @param integer $width Largura em pixels, padrão 50
 * @param array $attributes Array com opções de estilos e atributos extras
 * @return string O código HTML para gerar o botão
 */
function form_button($name = '', $value = '', $onClick = '', $width = '50', $attributes = '') {
    if (is_array($attributes)) {
        if (array_key_exists("style", $attributes)) {
            $attributes['style'] = $attributes['style'] . _style_width($width);
        } else {
            $attributes['style'] = _style_width($width);
        }
    }
    $defaults = array('name' => $name, 'onClick' => $onClick, 'id' => $name, 'value' => $value, 'class' => 'button');
//return "<input "._parse_form_attributes($extra, $defaults).$extra." />\n";
    return "<button " . _parse_form_attributes($attributes, $defaults) . $attributes . " >$value</button>\n";
}

/**
 * Cria um checkbox.<br>
 * Abaixo exemplos de como usar nas views:
 * <code>
 * <?= form_checkbox('chkName', 'chkNameID', 'S', FALSE); ?>
 * <?= form_checkbox('chkName', 'chkNameID', 'S', (@$check->name == 'S') ); ?>
 * </code>
 * Nota: no segundo exemplo, <i>(@$check->name == 'S')</i> corresponde a
 * TRUE em caso de sucesso, ou FALSE, simplificando o processo de marcação do item<br/>
 * Este helper gera objetos jQuery como id do campo, e uma função com seu nome
 * que retorna o item selecionado como um objeto jquery (ex: chkName().val() retorna
 * o valor do campo selecionado ou um array de valores quando o elemento é um array)
 * @param string $name Nome do campo, o valor será enviado ao controller/model quando este checkbox estiver selecionado
 * @param string $id ID do campo (caso necessário)
 * @param string $value Valor do campo QUANDO SELECIONADO, caso contrário o controller e model não receberão este valor
 * @param boolean $checked TRUE para marcado
 * @param array $extra Array com opções de estilos e atributos adicionais
 * @param boolean $disabled Informa se o componente inputcheckbox vai estar habilitado ou desabilitado
 * @param string $label O texto que aparecerá à direita do checkbox
 * @return string O código HTML para gerar o checkbox
 * @todo opcionalmente o label pode ser um array com pares de value=>label??? Nesses casos o javascript quebrará o layout
 */
function form_checkbox($name = '', $id = '', $value = '', $checked = FALSE, $extra = '', $disabled = false, $label = '', $label_extras = array()) {
    $defaults = array('type' => 'checkbox', 'name' => $name, 'value' => $value);
    global $checkboxes_list;
    global $checkboxes_count;

    if ($checked) {
        $extra['checked'] = 'checked';
    } else if (is_array($extra)) {
        unset($extra['checked']);
    }

    if ($disabled) {
        $disabled = "disabled";
    } else {
        $disabled = "";
    }

    $js = '<script type="text/javascript">';
    if (!empty($id)) {
        if (!empty($label)) {
            $label_extras = array_merge(array('for' => $id), $label_extras);
            $label = form_label('lbl' . ucfirst($id), $label, 'auto', $label_extras);
        } else {
            $label = "";
        }

        $extra['id'] = $id;
        $js .= "var $id = $('#$id');
        $.extend($id, String.prototype);
        $.extend($id, {toString:function(){return '$id';}});";
    } else {
        if (!empty($label)) {
            $jq = "$(this).prev()";
            $label_extras = array_merge(
                    array('onclick' => "if($jq.is(':checked')){ $jq.removeAttr('checked');" .
                "}else{ $jq.attr('checked', true);}"), $label_extras
            );
            $label = form_label('lbl' . ucfirst($name), $label, 'auto', $label_extras);
        } else {
            $label = "";
        }
    }

    if (empty($checkboxes_list) || !in_array("$name", $checkboxes_list)) {
        $fnc_name = explode('[', $name);
        if (count($fnc_name) > 1) {
            $fnc_name = current($fnc_name);
            $js .= "function $fnc_name(){" .
                    "    return $.extend(" .
                    "        $('input[name=\"$name\"]:checked')," .
                    "        {" .
                    "            val:function(){" .
                    "                var v=[];" .
                    "                $fnc_name().each(" .
                    "                    function(index,el){" .
                    "                        v.push($(el).val())" .
                    "                    }" .
                    "                );" .
                    "                return v" .
                    "            }" .
                    "        }" .
                    "    );" .
                    "}";
        } else {
            $js .= "function $name(){ return $('input[name=\"$name\"]:checked');}";
        }
        $checkboxes_list[] = "$name";
    }
    $js .= "</script>";

    return "<input " . _parse_form_attributes($extra, $defaults) . "$disabled />$label\n$js";
}

/**
 * Cria um elemento de seleção do tipo "radio".<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?=form_radio('optInputRadio', 'optRadio', 'S');?>
 * </code>
 * @param string $id Propriedade
 * @param string $name Nome do compoente input radio
 * @param string $value Valor do componente input radio
 * @param boolean $checked Marca o componente input radio caso seja true
 * @param array $data Array com opções de estilos e atributos extras
 * @param array $extra Array com opções de estilos e atributos extras
 * @param boolean $disabled Informa se o componente input radio vai estar habilitado ou desabilitado
 * @return string O código HTML para gerar o radio
 * @todo uniformizar parametros com form_checkbox, remover $data, limpar código, testar
 */ function form_radio($id, $name = '', $value = '', $checked = TRUE, $data = '', $extra = '', $disabled = false) {
    if (!is_array($data)) {
        $data = array();
    }
    if (!is_array($extra)) {
        $extra = array();
    }

    $data['type'] = 'radio';

    $extra = array_merge($data, $extra); // remover essa bagaça... não precisa de dois parametros iguais... tem que testar em todos os phps já criados :(

    return form_checkbox($name, $id, $value, $checked, $extra, $disabled);
}

/**
 * Gera um campo oculto.<br>
 * Este campo não será exibido e serve somente para armazenar um valor para seu posterior uso.
 * @param string $name Nome para identificação do campo
 * @param string $value Valor inicial do campo
 * @ignore @param boolean $recursing usado internamente, ignore
 * @return string O código HTML para gerar o campo oculto
 */
function form_hidden($name, $value = '', $recursing = FALSE) {
    static $form;
    static $hidden_count;

    if ($recursing === FALSE) {
        $form = "\n";
        $hidden_count = 0;
    }

    if (is_array($name)) {
        foreach ($name as $key => $val) {
            form_hidden($key, $val, TRUE);
        }
        return $form;
    }

    if (!is_array($value)) {
        $str_name = explode('[', $name);
        if (count($str_name) <= 1) {
            $id = $name;
        } else {
            $str_name = $str_name[0];
            $id = $str_name . "_" . $hidden_count;
            $hidden_count++;
        }
        $form .= '<input type="hidden" name="' . $name . '" id="' . $id . '" value="' . form_prep($value, $name) . '" />' . "\n";
        $form .= "<script>var $id = $('#$id');</script>";
    } else {
        foreach ($value as $k => $v) {
            $k = (is_int($k)) ? '' : $k;
            form_hidden($name . '[' . $k . ']', $v, TRUE);
        }
    }


    return $form;
}

/**
 * Gera um campo de texto com recurso de autocompletar.
 * Quando são digitados mais de 3 caracteres, é consultado o termo na $url, e retornado uma lista para seleção, com os pares key=>value.
 * Exemplo:
 * <code>
 * <?= form_textFieldAutoComplete('campodepesquisa',
 * 		base_url().'exemplo_app/exemplo/campoAutocomplete', @$key, @$value, 300); ?>
 * </code>
 * @param string $name Nome para identificação do campo. Deve ser todo em minúsculas.
 * @param string $url A URL absoluta para onde o campo fará requisição quando o usuário começar a digitar.<br>
 * Por padrão, usa-se: <code>base_url().'APLICAÇÃO/PROGRAMA/MÉTODO'</code>
 * @param string $key Chave. Valor inicial do campo $name, oculto, para consulta (geralmente usado para armazenar IDs)
 * @param string $value Valor. Valor inicial do campo search$name para exibição
 * @param integer $width Largura em pixels
 * @param string $mask Classe CSS, utilizada para aplicação de mascaramento no campo
 * @param integer $maxlength Quantidade máxima de caracteres no campo
 * @param array $attributes Array com opções de estilos e atributos extras, no formato array(atributo => valor)
 * @param boolean $disabled Desabilita a edição do campo
 * @return string O código HTML para gerar o campo
 */
function form_textFieldAutoComplete($name = '', $url = '', $key = '', $value = '', $width = '50', $mask = '', $maxlength = '255', $attributes = '', $disabled = false) {
    $defaults = array('type' => 'text', 'value' => $value, 'name' => "search$name", 'id' => "search$name", 'maxlength' => $maxlength, 'class' => "ui-state-default ui-corner-tr ui-corner-br $mask");

    if (is_array($attributes) && array_key_exists("style", $attributes)) {
        $attributes['style'] = $attributes['style'] . _style_width($width - 25);
    } else {
        $attributes['style'] = _style_width($width - 25);
    }

    if ($disabled) {
        $disabled = ' disabled';
    }

    $search = "search$name";

    $formAutoCompleteScript =
            "<script type='text/javascript'>
    var $name = $('#$name');
    var $search = $('#$search');
    $(function() {
        $('#$search').autocomplete({
            minLength: 3,
            source: function(request, response) {
                $.ajax({
                    url: '$url',
                    dataType: 'json',
                    data: {autocomplete: true, q: request.term},
                    success: function( data ) {
                        response($.map(data.combo, function( item ) {
                            return {label: item.optionName, value: item.optionName, valueHidden: item.value}
                        }));
                    }
                });
            },
            select: function(event, ui) {
                 $('#$name').val(ui.item.valueHidden);
                try{ {$name}_callback(ui.item.valueHidden, ui.item.label); } catch(err){}
            }
         });
        $('#$search').blur(function(){
            if($('#$search').val() == ''){
                 $('#$name').val('');
            }
        });
    });
</script>";

    $formAutoCompleteButtonSearch = '<div style="height: 22px; width: 25px; margin: 0px -1px 5px 0px; display: block; float: left; position: relative; padding: 0; text-decoration: none !important; text-align: center; zoom: 1; overflow: visible; border-right: none;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"><span class=" ui-icon ui-icon-search"></span></div>';
    $formAutoCompleteInputHidden = form_hidden($name, $key);
    $formAutoCompleteSearchField = "<input " . _parse_form_attributes($attributes, $defaults) . "$disabled />";
    return $formAutoCompleteButtonSearch . $formAutoCompleteSearchField . $formAutoCompleteInputHidden . $formAutoCompleteScript;
}

/**
 * Retorna um campo colorPicker para seleção de cor.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?= form_ColorPicker('textColorPicker', '', 300); ?>
 * </code>
 * @param string $name Nome do elemento
 * @param string $value Valor do elemento
 * @param integer $width Largura em pixels
 * @param string $mask Classe CSS, utilizada para mascaramento do campo
 * @param integer $maxlength Máximo de caracteres
 * @param array $extra Array com opções de estilos e atributos extras
 * @param boolean $disabled Desabilita o elemento
 * @return string O código HTML para gerar o elemento
 */ function form_ColorPicker($name, $value, $width = '50', $mask = 'colorPicker', $maxlength = '255', $extra = '', $disabled = false) {
    if (is_array($extra) && array_key_exists("style", $extra)) {
        $extra['style'] = $extra['style'] . _style_width($width);
    } else {
        $extra['style'] = _style_width($width);
    }

    if ($disabled) {
        $disabled = ' disabled';
    }
    $defaults = array('type' => 'text', 'name' => $name, 'id' => $name, 'value' => $value, 'maxlength' => $maxlength, 'class' => $mask,);
    return "<input " . _parse_form_attributes($extra, $defaults) . $disabled . " />\n";
}

/**
 * Retorna a abertura da tag fieldset do HTML. Esta tag é responsável por enquadrar um grupo de elementos com borda e um título ($name).<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?= begin_fieldset('Titulo FiledSet', 515, 132); ?>
 *     Aqui vão os componentes do fieldset
 * <?= end_fieldset(); ?>
 * </code>
 * @param string $name Nome do componente fieldSet HTML
 * @param integer $width Largura do componente fieldSet HTML
 * @param integer $height Altura do camponente fieldSet HTML
 * @return string O código HTML para gerar o fieldset
 * @see end_fieldset
 */ function begin_fieldset($name, $width = '', $height = '', $marginLeft = '') {
    $style = "";

    if (!empty($width)) {
        $style .= _style_width($width);
    }
    if (!empty($height)) {
        $style .= _style_height($height);
    }
    if (!empty($marginLeft)) {
        $style .= "margin-left:" . $marginLeft . "px; ";
    }
    $html = "<fieldset class=\"ui-widget ui-widget-content ui-corner-all\" style=\"$style background: none; padding: 5px;\">";
    $html .= "<legend class=\"legend\">$name</legend>";

    return $html;
}

/**
 * Encerra o fieldset
 * @return string O código HTML para finalizar o campo
 * @see begin_fieldset
 */
function end_fieldset() {
    return "</fieldset>";
}

/**
 * Cria um grupo de itens...
 * @param string $name O nome do elemento
 * @param integer $width Largura em pixels
 * @param string $title O texto a ser exibido como título do grupo
 * @param boolean $closeContent FALSE para exibir o conteúdo do grupo de itens
 * @return string O código HTML para criar o elemento
 * @see end_GroupItem
 * @todo completar a implementação ou explicar melhor o uso da função {@link begin_GroupItem}
 */
function begin_GroupItem($name = '', $width = '100%', $title = '', $closeContent = true) {
    $styleWidth = _style_width($width);

    $form = "<div style='$styleWidth' class='group-item' id='group-item-$name'>";
    $form.= "    <h1 class='" . ($closeContent ? "title-group-item-more" : "title-group-item-less") . "' id='$name'>$title</h1>";
    $form.= "    <div style='padding: 4px; display: " . ($closeContent ? "none" : "block") . ";'>";
    return $form;
}

/**
 * Encerra o GroupItem.
 * @return string O código HTML para encerrar o elemento
 * @see begin_GroupItem
 */
function end_GroupItem() {
    $form = "    </div>";
    $form.= new_line();
    $form.= "</div>";
    return $form;
}

/**
 * Retorna um conjunto de componentes que permitem uma seleção aprimorada de itens.<br>
 * O componente exibe um campo de busca, que consuta o termo via ajax. Há ainda um botão que permite abrir uma janela em primeiro plano para exibir possibilidades avançadas de refinamento de pesquisa.<br>
 * Para um buttonHit de nome exemplo, é gerado um campo oculto txtExemploId, txtExemploCodigo e txtExemploDescricao, sendo que o Codigo é o termo de pesquisa e a descrição não é editável pelo usuário.<br>
 * Note que é necessário criar um método no Controller para pesquisar por item de forma unitária ($url). Também é preciso ser codificada a view da janela de busca,
 * que consiste numa janela de filtro onde pode-se pesquisar pelos registros do sistema.<br>
 * Exemplo:
 * <code>
 * <?= form_buttonHit('pessoa', base_url() . 'exemplo_app/pessoa/buscaPessoa', 'Titulo Da Janela', 500); ?>
 * <script type='text/javascript'>
 *      // quando um item é selecionado na janela do buttonHit
 *      function returnButtonHitPessoa(pessoa){
 *          txtPessoaId.val(pessoa.id);
 *          txtPessoaCodigo.val(pessoa.cpf);
 *          txtPessoaDescricao.val(pessoa.nome);
 *      }
 * </script>
 * </code>
 * @param string $name Nome do componente buttonHit
 * @param string $onclick Método javascript que será chamado ao clicar no botão
 * @param string $titleButtonHit Título da janela de consulta avançada que abrirá quando clicar no botão de pesquisa
 * @param string $widthWindow largura da janela de consulta avançada
 * @param string $id ID inicial do campo, padrão vazio
 * @param string $codigo Código inicial do campo, padrão vazio
 * @param string $descricao Descrição inicial do campo, padrão vazio
 * @return string O código HTML para gerar este conjunto de componentes
 */
function form_buttonHit($name = '', $url = '', $titleButtonHit = 'Título buttonhit', $widthWindow = 500, $id = '', $codigo = '', $descricao = '') {
    $hName = humanize($name);
    $btHId = "txt{$hName}Id";
    $btHCd = "txt{$hName}Codigo";
    $btHDs = "txt{$hName}Descricao";
    $btHButton = "{$name}Button";
    $form_buttonHit = form_hidden($btHId, $id);
    $form_buttonHit.= form_textField($btHCd, $codigo, 100, '', '', array('style' => 'text-align: right;', 'onblur' => "openInputTextHit('$url/returnButtonHit$hName', returnButtonHit$hName, '$btHId', '$btHCd', '$btHDs');"));
    $form_buttonHit.= '<button id="' . $name . 'Button" onclick="openButtonHit(\'' . $url . '/parent.returnButtonHit' . $hName . '\', \'' . $titleButtonHit . '\', ' . $widthWindow . ');" style="margin: 0px 1px 0px -4px; height: 24px; display: block; float: left;" class="button-hit">Pesquisar</button>';
    $form_buttonHit.= form_textField($btHDs, $descricao, 400, '', '', array('style' => 'text-align: left;', 'readonly' => true));
    $form_buttonHit.=
            "<script>
            var $btHId = $('#$btHId');
            var $btHCd = $('#$btHCd');
	    	var $btHDs = $('#$btHDs');
 	    	var $btHButton = $('#$btHButton');
        </script>";
    return $form_buttonHit;
}

/**
 * Retorna um componente input file HTML.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?=form_file('userfile', '', 414, '', '', '', 1, array('id'=>'userfile'));?>
 * </code>
 * @param string $name Nome do componente input file
 * @param string $value Valor do componente input file
 * @param integer $width Largura do componente input file
 * @param string $mask Marcara do componente input file
 * @param integer $maxlength Maximo de caracteres permitido no componente input file
 * @param string $accept Tipo de arquivos permitidos no componente input file
 * @param integer $max Maximo de arquivos inseridos no componente input file
 * @param array $extra Array com opções de estilos e atributos extras
 * @return string
 */ function form_file($name = '', $valueIdUpload = '', $valueNameUpload = '', $allowed_types = '', $width = '250', $methodReturnUpload = 'finishUpload', $extra = '', $disable = false) {
    $form_file = form_hidden($name . 'Id', $valueIdUpload);
    $form_file.= form_textField($name . 'Name', $valueNameUpload, $width, '', '', array('readonly' => true));
    $form_file.= '<button id="btn' . $name . '" name="btn' . $name . '" onclick="openWindow(BASE_URL+\'util/upload/choiceFile/' . $name . 'Id' . '/' . $name . 'Name/' . $methodReturnUpload . humanize($name) . '/' . $allowed_types . '\', \'' . lang('uploadChoiceFileTitle') . '\', 600, false);" style="height: 24px; margin-left:0px; margin-bottom: 5px; margin-right: 5px;" class="ui-button ui-button-text-icon-primary ui-widget ui-state-default ui-corner-all">';
    $form_file.= '<span class="ui-button-icon-primary ui-icon ui-icon-newwin" style="float: left;"></span>Fazer upload';
    $form_file.= '</button>';
    return $form_file;
}

/**
 *
 * @param string $name
 * @param string $valueIdUpload
 * @param string $valueNameUpload
 * @param string $width
 * @param string $methodReturnUpload
 * @param string $extra
 * @param boolean $disable
 * @return string
 */
function form_image_webcam($name = '', $valueIdUpload = '', $valueNameUpload = '', $width = '250', $methodReturnUpload = 'finishUploadWebCam', $extra = '', $disable = false) {
    $form_file = form_hidden($name . 'Id', $valueIdUpload);
    $form_file.= form_textField($name . 'Name', $valueNameUpload, $width, '', '', array('readonly' => true));
    $form_file.= '<button id="btn' . $name . '" name="btn' . $name . '" onclick="openWindow(BASE_URL+\'util/webcam/choiceImagem/' . $name . 'Id' . '/' . $name . 'Name/' . $methodReturnUpload . humanize($name) . '\', \'Visualização WebCam\', 560, false);" style="height: 24px; margin-left:0px; margin-bottom: 5px; margin-right: 5px;" class="ui-button ui-button-text-icon-primary ui-widget ui-state-default ui-corner-all">';
    $form_file.= '<span class="ui-button-icon-primary ui-icon ui-icon-newwin" style="float: left;"></span>Imagem WebCam';
    $form_file.= '</button>';
    return $form_file;
}

/**
 * Retorna um textarea.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?=form_textArea('txtArea', '', 300, 2);?>
 * </code>
 * @param string $name Nome do textarea
 * @param string $value Texto inicial do textarea
 * @param integer $width Largura
 * @param integer $row Numero de linhas
 * @param integer $maxlength Maximo de caracteres
 * @param array $extra Array com opções de estilos e atributos extras
 * @param boolean $disabled True para desabilitar o campo
 * @return string
 */ function form_textArea($name = '', $value = '', $width = '100', $row = '4', $maxlength = '2000', $extra = '', $disabled = false) {
    if (is_array($extra) && array_key_exists("style", $extra)) {
        $extra['style'] = $extra['style'] . _style_width($width);
    } else {
        $extra['style'] = _style_width($width);
    }
    $defaults = array('name' => $name, 'id' => $name, 'rows' => $row, 'class' => 'ui-state-default ui-corner-all ',);
    if ($disabled) {
        $disabled = ' disabled';
    }
    return "<textarea " . _parse_form_attributes($defaults, $extra) . $disabled . ">$value</textarea>\n" .
            "<script type='text/javascript'>var $name = $('$name'); $.extend($name, {val: function(){return $('#$name').val();}});</script>";
}

/**
 * Retorna um textarea utilizando um editor WYSIWYG usando a biblioteca NicEdit.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * <?=form_textEditor('txtEditor', '', 420, 150, array('style' => 'margin-left: 0px;'));?>
 * </code>
 * @param string $name Nome do campo
 * @param string $value Valor inicial
 * @param integer $width Largura
 * @param integer $height Altura
 * @param array $extra Array com opções de estilos e atributos extras
 * @return string
 */ function form_textEditor($name = '', $value = '', $width = 100, $height = 50, $extra = '') {
    if (is_array($extra) && array_key_exists("style", $extra)) {
        $extra['style'] = $extra['style'] . _style_width($width) . _style_height($height);
    } else {
        $extra['style'] = _style_width($width) . _style_height($height);
    }

    $defaults = array('name' => $name, 'id' => $name, 'class' => 'textEditor',);
    return "<div class='nicEdit'><textarea " . _parse_form_attributes($defaults, $extra) . ">" . $value . "</textarea></div>\n";
}

/**
 * @ignore
 * Retorna um trecho CSS válido para "width".
 * @param string|integer $width O valor a ser utilizado como base
 * @return Um trecho CSS de valor válido, terminado com ";"
 */
function _style_width($width) {
    if ($width == 'auto' || preg_match('/%$/', $width) || preg_match('/px$/', $width)) {
        $width = "width: $width;";
    } else {
        $width = "width: {$width}px;";
    }
    return $width;
}

/**
 * @ignore
 * Retorna um trecho CSS válido para "height".
 * @param string|integer $height O valor a ser utilizado como base
 * @return Um trecho CSS de valor válido, terminado com ";"
 */
function _style_height($height) {
    if ($height == 'auto' || preg_match('/%$/', $height) || preg_match('/px$/', $height)) {
        $height = "height: $height;";
    } else {
        $height = "height: {$height}px;";
    }
    return $height;
}

?>
