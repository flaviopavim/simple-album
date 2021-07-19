<?php
if (isset($_FILES['file']['name'])) {
    include '../fn.php';
    $x = explode('.', $_FILES['file']['name']);
    $extension = strtolower(end($x));
    //bloquear uploads indesejados
    if (in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))) {
        //renomeia imagem
        $newName = randString(32);
        //ve se já existe o nome
        while (file_exists('../files/' . $newName . '.' . $extension)) {
            $newName = randString(32);
        }
        //sobe o arquivo na pasta
        move_uploaded_file($_FILES['file']['tmp_name'], '../files/' . $newName . '.' . $extension);
        //insere no banco de dados
        send("INSERT INTO files (file,description) VALUES ('" . $newName . '.' . $extension . "','" . $_POST['description'] . "')");
        //redireciona pro início
        header('Location: ../');
        exit;
    } else {
        ?>
        <script>
            window.alert('Erro ao subir imagem. Extensões aceitas: jpg, jpeg, png e gif.');
            window.location = '../insert';
        </script>
        <?php
    }
    exit;
}
?>
<div class="main">
    <div class="box">
        <a href="./">Voltar</a>
        <br>
        <br>
        <form enctype="multipart/form-data" action="./view/insert.php" method="POST">
            <div>
                <label>Arquivo</label>
                <input name="file" type="file">
            </div>
            <div>
                <label>Descrição</label>
                <textarea type="text" name="description"></textarea>
            </div>
            <input type="submit" value="Enviar arquivo">
        </form>
    </div>
</div>