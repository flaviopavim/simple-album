<?php
//usar url base do site (como abaixo) pra criar url limpa junto com .htaccess
$systemUrl = 'alexiasystem.com.br/site/rgb/';
//dados de conexão com banco de dados
$host = 'localhost';
$user = 'root';
$pass = '';
$base = 'rgb_test';

//usado pra SELECT
function select($sql) {
    global $host, $user, $pass, $base;
    $conn = mysqli_connect($host, $user, $pass, $base);
    return mysqli_query($conn, $sql);
}

//usado pra enviar string SQL, sem retorno
function send($sql) {
    global $host, $user, $pass, $base;
    $conn = mysqli_connect($host, $user, $pass, $base);
    mysqli_query($conn, $sql);
}

//criar database
send("
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `file` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `files` ADD PRIMARY KEY (`id`);
ALTER TABLE `files` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
");

//url limpa
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$parse = parse_url($actual_link);
$domain = $parse['host'];
$site_url = substr($systemUrl, 0, -1);

//transforma cada separação da url em $_GET[0], $_GET[1], $_GET[2]...
$x = explode($site_url . '/', $actual_link);
$root = './';
if (isset($x[1])) {
    $get = explode('/', $x[1]);
    if (isset($get)) {
        foreach ($get as $f => $v) {
            if ($f > 0) {
                $root .= '../';
            }
            $_GET[$f] = $v;
        }
    }
}

//string aleatória, pra renomear as imagens
function randString($n = 32) {
    $m = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $r = '';
    for ($i = 0; $i < $n; $i++) {
        $r .= $m[rand(0, strlen($m) - 1)];
    }
    return $r;
}

//excluir arquivo
if (!empty($_GET[0]) and $_GET[0] == 'delete') {
    if (is_numeric($_GET[1])) {
        $query = select("SELECT file FROM files WHERE id=" . $_GET[1]);
        $row = mysqli_fetch_assoc($query);
        @unlink('../files/' . $row['file']);
        send("DELETE FROM files WHERE id=" . $_GET[1]);
    }
    header('Location: ../');
    exit;
}