function loadMasks(){
	$('.datepicker, .cep, .cpf, .cnpj, .telefone, .nr_processo_rh, .ano').unmask();
	$('.datepicker').mask('99/99/9999', {placeholder:' '});
	$('.datepicker').bind('blur', function(){validateDate(this.id);});
	$('.cep').mask('99999-999',{completed:function(){void(0);}});
	$('.cpf').mask('999.999.999-99');
	$('.cpf').bind('blur', function(){validateCPF(this);});
	$('.cnpj').mask('99.999.999/9999-99',{completed:function(){void(0);}});
	$('.telefone').mask('(99) 9999-9999',{completed:function(){void(0);}});
	$('.placa').mask('aaa 9999');
	$('.real').unmaskMoney();	
	$('.real').maskMoney({symbol:'R$', decimal:',', thousands:'.'});
	$('.nr_processo_rh').mask("99999.999999/9999-99");
	$('.ano').mask('9999');
}