<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
    <head>
        <style>
            body {font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size:10px}
            div {display:inline}
            h1 {margin:0; text-align:center}
            h2 {margin:0; text-align:center; margin-top:25px}
            table {margin-top:-50px}
            th {border:1px solid #D0D0D0; background-color:#EBECEE}
            .rowWhite {background-color:#FFF; padding: 2px}
            .rowBlue {background-color:#DFE8F6; padding: 2px}
        </style>
    </head>
    <body>
        <div><img src="<?= base_url(); ?>img/ucpel_logo.jpg" /><h1><?= @$titulo; ?></h1><h2>Teste</h2></div>
        <table width="100%">
            <tr>
                <th width="50%" align="left">Nome</th>
                <th width="35%" align="left">Link</th>
                <th width="15%" align="center">Dt. Cadastro</th>
            </tr>
            <?
            $i = 0;
            $style = 'rowWhite';
            foreach ($programas as $programa) {
                if ($i % 2) {
                    $style = 'rowBlue';
                } else {
                    $style = 'rowWhite';
                }
                $i++;
                ?>
                <tr>
                    <td width="50%" class="<?= $style ?>"><?= $programa->nome; ?></td>
                    <td width="35%" class="<?= $style ?>"><?= $programa->link; ?></td>
                    <td width="15%" class="<?= $style ?>" align="center"><?= $programa->dt_cadastro; ?></td>
                </tr>
            <? } ?>
        </table>
    </body>

</html>