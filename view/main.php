<div class="main">
    <div class="box">
        <a href="./insert">Inserir imagem</a>
    </div>
    <br>
    <?php 
    $result=select("SELECT * FROM files ORDER BY id DESC");
    while($row= mysqli_fetch_assoc($result)) { ?>
        <div class="box_img">
            <a onclick="if (confirm('Tem certeza que deseja excluir?')) { window.location='./delete/<?php echo $row['id']; ?>'; }">Excluir</a>
            <img onclick="modal('files/<?php echo $row['file']; ?>','<?php echo $row['description']; ?>');" src="php/im.php?url=../files/<?php echo $row['file']; ?>&w=400&h=300">
        </div>
    <?php } ?>
</div>