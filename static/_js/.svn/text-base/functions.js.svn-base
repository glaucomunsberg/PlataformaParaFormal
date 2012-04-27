var isCtrl = false;

$(document).keyup(function (e) {
    if(e.which == 17) isCtrl=false;
}).keydown(function (e) {
    if(e.which == 17) isCtrl=true;
    switch (e.which) {
        case 83:
            if(isCtrl){
                if($('.ui-dialog .salvar').button( "option", 'disabled').length != 0 && !$('.ui-dialog .salvar').button( "option", 'disabled')){
                    try{
                        salvarPopUp();
                    }catch(err){}
                }else{
                    if(!$('.ui-layout-center .salvar').button( "option", 'disabled')){
                        try{
                            salvar();
                        }catch(err){}
                    }
                }
                return false;
            }
            break;
        case 78:
            if(isCtrl){
                if($('.ui-dialog .novo').button( "option", 'disabled').length != 0 && !$('.ui-dialog .novo').button( "option", 'disabled')){
                    try{
                        novoPopUp();
                    }catch(err){}
                }else{
                    if(!$('.ui-layout-center .novo').button( "option", 'disabled')){
                        try{
                            novo();
                        }catch(err){}
                    }
                }
                return false;
            }
            break;
        case 69:
            if(isCtrl){
                if($('.ui-dialog .excluir').button( "option", 'disabled').length != 0 && !$('.ui-dialog .excluir').button( "option", 'disabled')){
                    try{
                        excluirPopUp();
                    }catch(err){}
                }else{
                    if(!$('.ui-layout-center .excluir').button( "option", 'disabled')){
                        try{
                            excluir();
                        }catch(err){}
                    }
                }
                return false;
            }
            break;
        case 13:
            if(isCtrl){
                if($('.ui-dialog .pesquisar').button( "option", 'disabled').length != 0 && !$('.ui-dialog .pesquisar').button( "option", 'disabled')){
                    try{
                        pesquisarPopUp();
                    }catch(err){}
                }else{
                    if(!$('.ui-layout-center .pesquisar').button( "option", 'disabled')){
                        try{
                            pesquisar();
                        }catch(err){}
                    }
                }
                return false;
            }
            break;
        case 73:
            if(isCtrl){
                if($('.ui-dialog .imprimir').button( "option", 'disabled').length != 0 && !$('.ui-dialog .imprimir').button( "option", 'disabled')){
                    try{
                        imprimirPopUp();
                    }catch(err){}
                }else{
                    if(!$('.ui-layout-center .imprimir').button( "option", 'disabled')){
                        try{
                            imprimir();
                        }catch(err){}
                    }
                }
                return false;
            }
            break;
        default:
            break;
    }
})

/**
 * Método executado após carregar todos os elementos da tela
 * TODO: Tentar utilizar o método loadComponents para diminuir linhas e simplificar o código
 * @author rsantos
 */
$(document).ready(function(){
    $.ajaxSetup({
        global: true,
        dataType: 'json',
        beforeSend: function(){
            $('#carregando').fadeIn('normal', function(){
                $('input:button').blur();
            });
        },
        complete: function(){
            $('#carregando').fadeOut('normal');
        }
    });
    $(".breadCrumb").jBreadCrumb();
    $("form").submit(function(){
        return false;
    });
    $('input:button, input:submit').button({
        text:true
    });
    $('button').button();
    $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+10',
        showOtherMonths: true,
        selectOtherMonths: true,
        showOn: "button",
        buttonImage: IMG+"/calendar.gif",
        buttonImageOnly: true
    });
    $("#menu").treeview({
        persist: "cookie",
        cookieId: "navigationtree",
        cookieOptions: {
            path: PATH_COOKIE
        }
    });
    $("#permissao_aplicativos").treeview();
    $('#btnConfiguracoes').button({
        text: true,
        icons: {
            primary: 'ui-icon-person'
        }
    });
    $('#btnSair').button({
        text: true,
        icons: {
            primary: 'ui-icon-power'
        }
    });
    $('#btnCloseOpenMenu').button({
        text: true,
        icons: {
            primary: 'ui-icon-pin-s'
        }
    }).click(function(){
        $('button').blur();
        btnCloseOpenMenu();
    });
    if($('#btnCloseOpenMenu').button( "option", 'label') == 'Exibir menu')
        $('#btnCloseOpenMenu').button( "option" , {
            text: true,
            label: 'Exibir menu',
            icons: {
                primary: 'ui-icon-pin-w'
            }
        });
	
    $('.button-hit').button({
        text: false,
        icons: {
            primary: 'ui-icon-search'
        }
    });
    $('.ui-layout-center .voltar-pagina').button({
        text: false,
        icons: {
            primary: 'ui-icon-circle-arrow-w'
        }
    }).live('click', function(){
        $('button').blur();
        history.go(-1);
    });
    $('.ui-layout-center .pesquisar').button({
        text: true,
        icons: {
            primary: 'ui-icon-search'
        }
    }).click(function(){
        $('button').blur();
        try{
            pesquisar();
        }catch(err){
            messageErrorBox('Erro ao executar o método pesquisar() ' + err);
        }
    });
    $('.ui-layout-center .salvar').button({
        text: true,
        icons: {
            primary: 'ui-icon-disk'
        }
    }).click(function(event){
        $('button').blur();
        try{
            salvar();
        }catch(err){
            messageErrorBox('Erro ao executar o método salvar() ' + err);
        }
    });
    $('.ui-layout-center .novo').button({
        text: true,
        icons: {
            primary: 'ui-icon-document'
        }
    }).click(function(){
        $('button').blur();
        try{
            novo();
        }catch(err){
            messageErrorBox('Erro ao executar o método novo() ' + err);
        }
    });
    $('.ui-layout-center .abrir').button({
        text: true,
        icons: {
            primary: 'ui-icon-folder-open'
        }
    }).click(function(){
        $('button').blur();
        try{
            abrir();
        }catch(err){
            messageErrorBox('Erro ao executar o método abrir() ' + err);
        }
    });
    $('.ui-layout-center .excluir').button({
        text: true,
        icons: {
            primary: 'ui-icon-trash'
        }
    }).click(function(){
        $('button').blur();
        try{
            excluir();
        }catch(err){
            messageErrorBox('Erro ao executar o método excluir() ' + err);
        }
    });
    $('.ui-layout-center .imprimir').button({
        text: true,
        icons: {
            primary: 'ui-icon-print'
        }
    }).click(function(){
        $('button').blur();
        try{
            imprimir();
        }catch(err){
            messageErrorBox('Erro ao executar o método imprimir() ' + err);
        }
    });
    $('.ui-layout-center .ajuda').button({
        text: true,
        icons: {
            primary: 'ui-icon-help'
        }
    }).click(function(){
        $('button').blur();
        try{
            ajuda();
        }catch(err){
            messageErrorBox('Erro ao executar o método ajuda() ' + err);
        }
    });
    $('#txtBuscaMenu').focus(function(){
        if($('#txtBuscaMenu').val() == 'buscar no menu')
            $('#txtBuscaMenu').val('');
    });
    $('#txtBuscaMenu').focusout(function(){
        if($('#txtBuscaMenu').val() == ''){
            $('#txtBuscaMenu').val('buscar no menu');
            $('#menu > li').removeHighlight();
        }
    });
    $("#txtBuscaMenu").autocomplete({
        source: function( request, response ) {
            $('#menu > li').removeHighlight();
            if($('#txtBuscaMenu').val() != '')
                $('#menu > li').highlight(request.term);
			
            var highlights = $('.highlight').parent();
            var programas = new Array();
            for(var i = 0 ; i < highlights.length ; i++)
                if(highlights[i].tagName == 'A'){
                    programas.push(new ClassPrograma($(highlights[i]).attr('href'), $(highlights[i]).text()));
                }

            response($.map(programas, function( item ) {
                return {
                    label: item.nome,
                    value: item.nome,
                    valueHidden: item.url
                }
            }));
        },
        select: function( event, ui ) {
            location.href = ui.item.valueHidden;
        }
    });
    try{
        $('#content-center .toolbar').fixFloat();
    }catch(err){}
    generateTabs();
    loadMasks();
    try{
        init();
    }catch(err){}
});

/**
 * Métodos responsável por montar todas tabs criadas na tela, este método é lokão.
 * @author rsantos
 */
function generateTabs(){
    var dialogs = $('.ui-dialog-content').get();
    for(var i =0; i < dialogs.length; i++) {
        var jqgrids = $('#'+dialogs[i].id+' .ui-jqgrid').get();
        for(var j =0; j < jqgrids.length; j++) {
            var jqgrid = jqgrids[j].id.split('_', 2)[1];
            if($("#"+jqgrid).jqGrid('getGridParam','autowidth'))
                try{
                    $('#'+jqgrid).jqGrid('setGridWidth', $("#"+dialogs[i].id).outerWidth() - 25);
                }catch(err){};
        }
    }
	
    var tabs = $('.tabs').get();
    for(var i =0; i < tabs.length; i++) {
        if($("#"+tabs[i].id+" ul:first").html() == ''){
            $("#"+tabs[i].id+" ul:first li").remove();
            $("#"+tabs[i].id+" ."+tabs[i].id+" .label"+tabs[i].id).clone().appendTo("#"+tabs[i].id+" ul:first");
            $("#"+tabs[i].id+" ."+tabs[i].id+" .label"+tabs[i].id).parent().remove();
        }
        var jqgrids = $('#'+tabs[i].id+' .ui-jqgrid').get();
        for(var j =0; j < jqgrids.length; j++) {
            var jqgrid = jqgrids[j].id.split('_', 2)[1];
            if($("#"+jqgrid).jqGrid('getGridParam','autowidth'))
                try{
                    $('#'+jqgrid).jqGrid('setGridWidth', $("#"+tabs[i].id).outerWidth() - 35)
                }catch(err){};
        }
    }

    $(".tabs").tabs({
        show: function(event, ui) {
            try{
                tabShow(ui.index, ui.tab.title.split('-', 2)[0]);
            }catch(err){}
            try{
                eval(ui.tab.title.split('-', 2)[0]+"Show("+ui.index+");");
            }catch(err){}
        },
        load: function(event, ui){
            loadComponents();
            generateTabs();
            var tabs = $('#'+ui.tab.title+' > .tabs').get();
            for(var i =0; i < tabs.length; i++) {
                if($("#"+tabs[i].id+" ul:first").html() == ''){
                    $("#"+tabs[i].id+" ul:first li").remove();
                    $("#"+tabs[i].id+" ."+tabs[i].id+" .label"+tabs[i].id).clone().appendTo("#"+tabs[i].id+" ul:first");
                    $("#"+tabs[i].id+" ."+tabs[i].id+" .label"+tabs[i].id).parent().remove();
                }
                var jqgrids = $('#'+tabs[i].id+' .ui-jqgrid').get();
                for(var j =0; j < jqgrids.length; j++) {
                    var jqgrid = jqgrids[j].id.split('_', 2)[1];
                    if($("#"+jqgrid).jqGrid('getGridParam','autowidth')){
                        try{
                            $('#'+jqgrid).jqGrid('setGridWidth', $("#"+tabs[i].id).outerWidth() - 35)
                        }catch(err){};
                        $("#"+tabs[i].id).width($("#"+tabs[i].id).outerWidth());
                    }
		   				
                }
            }
            try{
                tabLoad(ui.index, ui.tab.title.split('-', 2)[0]);
            }catch(err){
                try{
                    eval(ui.tab.title.split('-', 2)[0]+"Load("+ui.index+");");
                }catch(err){}
            }
        },
        select: function(event, ui) {},
        cache: true,
        ajaxOptions: {
            dataType: 'html',
            error: function(xhr, status, index, anchor) {
                $(anchor.hash).html("");
                messageErrorBox("Não foi possível carregar as informações");
            }
        }
    });
}

/**
 * Método responsável por carregar os componentes quando a tela popup é exibida
 * @author rsantos
 */
function loadComponents(){
    $(".breadCrumb").jBreadCrumb();
    $("form").submit(function(){
        return false;
    });
    $('input:button, input:submit').button({
        text:true
    });
    $('button').button();
    $("button.button-hit").each(function(){
        $(this).button({
            icons:{
                primary: "ui-icon-search"
            },
            text: false
        });
    });
    $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+10',
        showOtherMonths: true,
        selectOtherMonths: true,
        showOn: "button",
        buttonImage: IMG+"/calendar.gif",
        buttonImageOnly: true
    });
    $('.ui-dialog .pesquisar').button({
        text: true,
        icons: {
            primary: 'ui-icon-search'
        }
    }).click(function(){
        $('button').blur();
        try{
            pesquisarPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método pesquisarPopUp() ' + err);
        }
    });
    $('.ui-dialog .salvar').button({
        text: true,
        icons: {
            primary: 'ui-icon-disk'
        }
    }).click(function(event){
        $('button').blur();
        try{
            salvarPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método salvarPopUp() ' + err);
        }
    });
    $('.ui-dialog .novo').button({
        text: true,
        icons: {
            primary: 'ui-icon-document'
        }
    }).click(function(){
        $('button').blur();
        try{
            novoPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método novoPopUp() ' + err);
        }
    });
    $('.ui-dialog .abrir').button({
        text: true,
        icons: {
            primary: 'ui-icon-folder-open'
        }
    }).click(function(){
        $('button').blur();
        try{
            abrirPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método abrirPopUp() ' + err);
        }
    });
    $('.ui-dialog .excluir').button({
        text: true,
        icons: {
            primary: 'ui-icon-trash'
        }
    }).click(function(){
        $('button').blur();
        try{
            excluirPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método excluirPopUp() ' + err);
        }
    });
    $('.ui-dialog .imprimir').button({
        text: true,
        icons: {
            primary: 'ui-icon-print'
        }
    }).click(function(){
        $('button').blur();
        try{
            imprimirPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método imprimirPopUp() ' + err);
        }
    });
    $('.ui-dialog .ajuda').button({
        text: true,
        icons: {
            primary: 'ui-icon-help'
        }
    }).click(function(){
        $('button').blur();
        try{
            ajudaPopUp();
        }catch(err){
            messageErrorBox('Erro ao executar o método ajudaPopUp() ' + err);
        }
    });
    loadMasks();
}

/**
 * Metódo utilizado para a busca de palavras no menu de programas do sistema
 * @author rsantos
 * @param string url
 * @param string nome
 */
function ClassPrograma(url, nome){
    this.url = url;
    this.nome = nome;
}

function resetForm(form){
    $("#"+form).resetForm();
}
function clearFields(form){
    $("#"+form).clearFields();
}

/**
 * Método responsável por executar a chamada de logout do sistema
 */
function logout(){	
    location.href = BASE_URL+'autenticacao/login/sair';
}

/**
 * Método responsável por executar alguma ação antes de efetuar qualquer chamada AJAX.
 * OBS: AINDA FALTA IMPLEMENTAR ESTE MÉTODO
 * @return boolean
 */
function beforeSubmit(formData, jqForm, options, formName){
    var submit = true;
    /*if(formName != 'formLogin'){
		$j.post(BASE_URL+'autenticacao/login/validaAutenticacaoAjax',
			function(data){
				if(!data.logged.message){
					window.alert('Execute novamente o login no sistema.');
					submit = false;
				}
			}
		);
	}*/
    return submit;
}

/**
 * Método responsável por exibir a tela de configuração do usuário
 */
function configuracoesUsuario(){
    location.href = BASE_URL+'dashboard/configuracao';
}

/**
 * Método responsável por ocultar e mostrar o menu do sistema
 * @author rsantos
 */
function btnCloseOpenMenu(){
    if($('.ui-layout-west').hasClass('closed')){
        $.cookie('showMenu', true, {
            path: PATH_COOKIE
        });
        $('#btnCloseOpenMenu').button( "option" , {
            text: true,
            label: 'Esconder menu',
            icons: {
                primary: 'ui-icon-pin-s'
            }
        });
        $('.ui-layout-west').removeClass('closed');
        $('.ui-layout-west').fadeIn('slow', resizeGridTab);
    }else{
        $.cookie('showMenu', false, {
            path: PATH_COOKIE
        });
        $('#btnCloseOpenMenu').button( "option" , {
            text: true,
            label: 'Exibir menu',
            icons: {
                primary: 'ui-icon-pin-w'
            }
        });
        $('.ui-layout-west').addClass("closed");
        $('.ui-layout-west').fadeOut('slow', resizeGridTab);
    }
}

/**
 * Método responsável por ajustar o tamanho da grid ao tamanho das tabs caso não seja informada a largura da grid.
 * @author rsantos
 */
function resizeGridTab(){
    var jqgrids = $('.ui-layout-center .ui-jqgrid').get();
    for(var x =0; x < jqgrids.length; x++) {
        var jqgrid = jqgrids[x].id.split('_', 2)[1];
        if($("#"+jqgrid).jqGrid('getGridParam','autowidth'))
            $('#'+jqgrid).jqGrid('setGridWidth', document.getElementById('content-center').offsetWidth - 13);
    }

    var tabs = $('.tabs').get();
    for(var i =0; i < tabs.length; i++) {
        var jqgrids = $('#'+tabs[i].id+' .ui-jqgrid').get();
        for(var j =0; j < jqgrids.length; j++) {
            var jqgrid = jqgrids[j].id.split('_', 2)[1];
            if($("#"+jqgrid).jqGrid('getGridParam','autowidth'))
                $('#'+jqgrid).jqGrid('setGridWidth', document.getElementById(tabs[i].id).offsetWidth - 35);
        }
    }
}

/**
 * DEPRECATED since 09/12/2010
 * Método responsável por setar o valor da combo
 * @author rsantos
 * @param string comboName Nome da combo que deseja setar o valor
 * @param string value Valor que deseja selecionar
 * @deprecated
 * @ignore
 */
function setValueCombo(comboName, value){
    $('#'+comboName).val(value).selectmenu('value', value);
}

/**
 * Método responsável por buscar a informação quando o usuário digita algo no campo código do componente buttonHit
 * @author rsantos
 * @param string url URL do controle responsável por buscar a informação
 * @param object functionCallBack Método de retorno com as informações carregadas
 * @param string idComponenteId ID do componente hidden que irá armazenar o Id da informação solicitada
 * @param string idComponenteCodigo Id componente que irá armazenar o Código da informação solicitada
 * @param string idComponenteDescricao Id componente que irá armazenar a Descrição da informação solicitada
 */
function openInputTextHit(url, functionCallBack, idComponentId, idComponentCodigo, idComponentDescricao){
    if($('#'+idComponentCodigo).val()){
    	$.post(url, {
            cod_object: $('#'+idComponentCodigo).val()
        },
        function(data){
            if(data.object.id != undefined){
                data.object.error = false;
                try{
                    console.log(data.object);
                }catch(err){}
                if($.isFunction(functionCallBack))
                    try{
                        functionCallBack(data.object);
                    }catch(err){}
            }else{
                clearButtonHit(idComponentId, idComponentCodigo, idComponentDescricao);
                messageErrorBox('Nenhum registro foi encontrado.', idComponentCodigo);
            }
        });
    }else{
    	clearButtonHit(idComponentId, idComponentCodigo, idComponentDescricao, functionCallBack);	
    }        
}

/**
 * Método responsável por limpar todos os campos do componente buttonHit
 * @author rsantos;
 * @param string idComponenteId ID do componente hidden
 * @param string idComponenteCodigo Id componente que armazena o Código
 * @param string idComponenteDescricao Id componente que armazena a Descrição
 * @param object functionCallBack Método a ser executado após limpar todos os campos do componente buttonHit
 */
function clearButtonHit(idComponentId, idComponentCodigo, idComponentDescricao, functionCallBack){
    $('#'+idComponentId).val('');
    $('#'+idComponentCodigo).val('');
    $('#'+idComponentDescricao).val('');
    if($.isFunction(functionCallBack))
        try{
            functionCallBack({
                error: true
            });
        }catch(err){}
}

/**
 * Método responsável por abrir a janela do componente buttonHit
 * @author rsantos
 * @param string url URL do controle responsável por exibir a tela de filtro para utilização do componente
 * @param string title Título da janela
 * @param integer width Largura da janela
 */
function openButtonHit(url, title, width){
    openWindow(url, title, width);
}

/**
 * Método responsável por excutar o método de retorno do buttonHit, ou seja, quando o usuário escolher o registro de sua preferência
 * @author rsantos
 * @param object functionCallBack Método que receberá o retorno que o usuário selecionou
 * @param object returnObject Objeto javascript com no mínimo os campos id, codigo, descricao
 */
function buttonHitCallBack(functionCallBack, returnObject){
    try{
        console.log(returnObject);
    }catch(err){}

    if($.isFunction(functionCallBack))
        try{
            functionCallBack(returnObject);
        }catch(err){}

    parent.closeWindowSelf();
}

function uploadCallBack(functionCallBack){
    if($.isFunction(functionCallBack))
        try{
            functionCallBack();
        }catch(err){}

    closeWindowSelf();
}

function validateCPF(objectCPF){
    var cpf = objectCPF.value;
    exp = /\.|\-/g
    cpf = cpf.toString().replace(exp, ""); 
    if(cpf != '')  
        if(!cpfIsTrue(cpf)){
            objectCPF.value = '';
            messageErrorBox("CPF inválido.", objectCPF.id);
        }
}

function cpfIsTrue(cpf){
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1))
        {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais)
    {
        numeros = cpf.substring(0,9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
            soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        numeros = cpf.substring(0,10);
        soma = 0;
        for (i = 11; i > 1; i--)
            soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}

function validateDate(objectId){
    var objectDate = document.getElementById(objectId);
    var strDate = objectDate.value;
    var mask = "99/99/9999";

    if($.trim(strDate.replace('/', '').replace('/', '')) != ""){
        if (strDate.length != 10){
            clearDateField(objectId, mask);
            messageErrorBox("Formato da data não é válido. Formato correto: - dd/mm/aaaa.", objectId);
            return false;
        }

        if ("/" != strDate.substr(2,1) || "/" != strDate.substr(5,1)){
            clearDateField(objectId, mask);
            messageErrorBox("Formato da data não é válido. Formato correto: - dd/mm/aaaa.", objectId);
            return false;
        }

        dia = strDate.substr(0,2)
        mes = strDate.substr(3,2);
        ano = strDate.substr(6,4);

        if (isNaN(dia) || dia > 31 || dia < 1){
            clearDateField(objectId, mask);
            messageErrorBox("Formato do dia não é válido.", objectId);
            return false;
        }

        if (mes == 4 || mes == 6 || mes == 9 || mes == 11){
            if (dia == "31"){
                clearDateField(objectId, mask);
                messageErrorBox("O mês informado não possui 31 dias.", objectId);
                return false;
            }
        }

        if (mes == "02"){
            bissexto = ano % 4;
            if (bissexto == 0){
                if (dia > 29){
                    clearDateField(objectId, mask);
                    messageErrorBox("O mês informado possui somente 29 dias.", objectId);
                    return false;
                }
            }else{
                if (dia > 28){
                    clearDateField(objectId, mask);
                    messageErrorBox("O mês informado possui somente 28 dias.", objectId);
                    return false;
                }
            }
        }

        if (isNaN(mes) || mes > 12 || mes < 1){
            clearDateField(objectId, mask);
            messageErrorBox("Formato do mês não é válido.", objectId);
            return false;
        }

        if (isNaN(ano)){
            clearDateField(objectId, mask);
            messageErrorBox("Formato do ano não é válido.", objectId);
            return false;
        }
    }
}

function clearDateField(objectId, mask){
    var objectDate = document.getElementById(objectId);
    $("#"+objectId).unmask();
    objectDate.value = "";
    $(".datepicker").mask(mask, {
        placeholder:" "
    });
}

function getIntervalDate(dtInicio, dtFim){
    var dtInicio = dtInicio.split("/");
    var dtFim = dtFim.split("/");
		
    inicio = new Date(dtInicio[2], dtInicio[1]-1, dtInicio[0]);
    fim = new Date(dtFim[2], dtFim[1]-1, dtFim[0]);
    dif = fim.getTime() - inicio.getTime();
    dia = 1000 * 60 * 60 * 24;
    intervalDate = dif / dia;

    return intervalDate;
}

/**
 * Método utilizado para manipular os valores dos elementos sem a utilização explícita da biblioteca jQuery ou de métodos/funções auxiliares.
 */
String.prototype.val = function(value){
    var el = $('#'+this);
    if(value != undefined){    	
        if(el.get(0).tagName == 'SELECT'){
            this.setValueCombo(value);
        }else if(el.attr('type') == 'checkbox'){
            if(value || value != ''){
                el.attr('checked', true);
            }else{
                el.removeAttr('checked');
            }
        }else{
            el.val(value);
        }
    }else if(el.attr('type') == 'checkbox'){
        return ( el.attr('checked') == undefined );
    }
    return el.val();
}

/**
 * Desabilita componentes de tela utilizando a biblioteca jQuery, isto é um plugin para o jquery
 */
jQuery.fn.disable = function(){
	return this.each(function(){
		var el = $(this);
		if(el.get(0).tagName == 'SELECT'){
			el.attr('disabled', true).selectmenu('disable');
		}else{
			el.attr('disabled', true).addClass('ui-state-disabled');
		}
	});
};

/**
 * Habilita componentes de tela utilizando a biblioteca jQuery, isto é um plugin para o jquery
 */
jQuery.fn.enable = function(){
	return this.each(function(){
		var el = $(this);
		if(el.get(0).tagName == 'SELECT'){
			el.attr('disabled', false).selectmenu('enable');
		}else{
			el.attr('disabled', false).removeClass('ui-state-disabled');
		}
	});
};

/**
 * Desabilita componentes de tela
 */
String.prototype.disable = function(){
	var el = $('#'+this);
	if(el.get(0).tagName == 'SELECT'){
		el.attr('disabled', true).selectmenu('disable');
	}else{
		el.attr('disabled', true).addClass('ui-state-disabled');
	}
}

/**
 * Habilita componentes de tela
 */
String.prototype.enable = function(){
    $('#'+this).attr("disabled", false).selectmenu('enable');
}

/**
 * Seta o valor da combo
 */
String.prototype.setValueCombo = function(value){
    $('#'+this).val(value).selectmenu('value', value);
}

/**
 * Remove todos os valores da combo
 */
String.prototype.clearCombo = function(){
    objectCombo = document.getElementById(this);
    countRows = objectCombo.length;
    for(var j = countRows; j > 0 ; j--){
        objectCombo.remove(j);
    }
    $('#'+this).selectmenu('destroy');
    $('#'+this).selectmenu({
        style:'dropdown',
        maxHeight: 150,
        width: parseInt(objectCombo.style.width.replace('px', '')) + 4
    });
}

String.prototype.removeFirst = function(){
    objectCombo = document.getElementById(this);
    objectCombo.remove(0);
    $('#'+this).selectmenu('destroy');
    $('#'+this).selectmenu({
        style:'dropdown',
        maxHeight: 150,
        width: parseInt(objectCombo.style.width.replace('px', '')) + 4
    });
}

String.prototype.loadCombo = function(url, param, selectedIndex, functionCallback){
    comboName = this;
    objectCombo = document.getElementById(comboName);
    countRows = objectCombo.length;
    for(var j = objectCombo.length; j > 0 ; j--){
        objectCombo.remove(j);
    }

    if(param != undefined){
        paramSelectedIndex = param + "";
        if(paramSelectedIndex.substr(0,1) != "{"){
            selectedIndex = param;
        }
    }
	
    $.post(url, param, function(data){
        for(var i = 0 ; i < data.combo.length ; i++) {
            var value      =  data.combo[i].value;
            var optionName =  data.combo[i].optionName;

            if(optionName!=false){
                objectCombo.options[objectCombo.options.length] = new Option (optionName, value, true, true);
            }
        }

        if(selectedIndex != undefined){
            objectCombo.value = selectedIndex;
        } else{
            objectCombo.value = "";
        }

        $('#'+comboName).selectmenu('destroy');
        $('#'+comboName).selectmenu({
            style:'dropdown',
            maxHeight: 150,
            width: parseInt(objectCombo.style.width.replace('px', '')) + 4
        });
		
        if ($.isFunction(functionCallback)){
            functionCallback();
        }

    }, 'json');
}
