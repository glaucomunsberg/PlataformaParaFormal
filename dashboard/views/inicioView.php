<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

    <?= path_bread('Início', false); ?>
    <ol id="selectable">
        <li class="ui-widget-content"><?=$numDenuncias?> Denúncias</li>
        <li class="ui-widget-content"><?=$numAtualizacoes?> Novas Atualizações</li>
        <li class="ui-widget-content"><?=$novasParaformalidades ?> Novas Paraformalidades</li>
    </ol>
    <style>
        #feedback { font-size: 1.4em; }
        #selectable .ui-selecting { background: #599cce; }
        #selectable .ui-selected { background: #2e6e9e; color: white; }
        #selectable { list-style-type: none; margin: 0; padding: 0; width: 99%; }
        #selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
    </style>
    <script>
        $(function() {
          $( "#selectable" ).selectable({
      stop: function() {
          $( ".ui-selected", this ).each(function() {
          var index = $( "#selectable li" ).index( this );
          switch(index){
              case 0:
                  location.href = BASE_URL+'paraformalidade/gerenciar/denuncias';
                  break;
              case 1:
                  location.href = BASE_URL+'paraformalidade/gerenciar/atualizacoes';
                  break;
              case 2:
                  alert('Sorry!Not implemented yet')
                  break;
          }
        });
      }
    });

          

          
        });
        $( "#selectable li" ).css( 'cursor', 'pointer' );
    </script>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
