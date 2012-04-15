<? if(!isset($buttonHit)){ ?>
		</div>		
		<div style="clear: both; margin-top: 10px;"><!----></div>
		<div id="footer" class="ui-state-highlight ui-widget">
			&copy;2012 Audigital 3.0
		</div>
		<div id="dialog-message-error" style="display:none;"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0;"></span><label></label></p></div>
		<div id="dialog-message-info" style="display:none;"><p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 0;"></span><label></label></p></div>
		<div id="dialog-confirm" style="display:none;"><p style="margin-top: 20px;"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0;"></span><label></label></p></div>		
	</body>
</html>
<? }else{ ?>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(function(){parent.setHeightWindow($.cookie('lastWindow'), $('.content-center-popup').outerHeight());});
</script>
<? } ?>