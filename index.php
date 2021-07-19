<?php include 'fn.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <meta name="author" content="WhiteHats">
        <title>RGB Test</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <script src="js/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <?php 
        //abrir o arquivo que a url que pede
        if (!empty($_GET[0])) {
            if (file_exists('view/'.$_GET[0].'.php')) {
                include 'view/'.$_GET[0].'.php';
            } else {
                include 'view/error.php';
            }
        } else {
            include 'view/main.php'; 
        }
        ?>
        <div id="modal-bg">
            <div id="modal">
                <div id="modal-close">x</div>
                <div id="modal-body"></div>
            </div>
        </div>
        <script>
            //funções pra modal
            function modal(src,text) {
                $('#modal-body').html('<img src="'+src+'"><br><center>'+text+'</center>');
                $('#modal-bg').fadeIn();
                $('body').css({overflowY:'hidden'});
            }
            function closeModal() {
                $('#modal-bg').fadeOut();
                $('body').css({overflowY:'auto'});
            }
            $(function() {
                $('#modal-close').click(function () {
                    closeModal();
                });
            });
            $(window).keyup(function(e){
                //ao pressionar ESC quando modal estiver aberto
                if (e.keyCode===27) {
                    closeModal();
                }
            });
        </script>
    </body>
</html>