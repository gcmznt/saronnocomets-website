<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ASD Saronno TchoukBall Club</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    
    <link rel="stylesheet" type="text/css" href="../_static/css/reset-min.css" />
    
    <script type="text/javascript" src="../_static/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../_static/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="../_static/ckfinder/ckfinder.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var editor = CKEDITOR.replace('testo', {
                filebrowserBrowseUrl : '../_static/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : '../_static/ckfinder/ckfinder.html?Type=Images',
                filebrowserFlashBrowseUrl : '../_static/ckfinder/ckfinder.html?Type=Flash',
                filebrowserUploadUrl : '../_static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : '../_static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl : '../_static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
        });
    </script>
</head>
<body>
    <?php
        if (isset($_POST['testo'])) {
            require_once(dirname(__FILE__).'/../_includes/utilities.php');
            $t = mysql_real_escape_string($_POST['testo']);
            mysql_query("INSERT INTO news (testo) VALUES ('$t');");
            echo 'Salvataggio effettuato.';
        } else {
    ?>
    <form method="post" action="">
        <textarea name="testo" id="testo"></textarea>
        <br />
        <input type="submit" value="Salva" />
    </form>
    <?php
        }
    ?>
</body>
</html>
    