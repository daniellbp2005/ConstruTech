<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //qnd a página for acessada como metodo POST, ele executa esse comando.
    $ids = array_column($_SESSION['produtos'], 'id');
    $novoId = $ids ? max($ids) + 1 : 1;

    $_SESSION['produtos'][] = [
        'id' => $novoId,
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco'],
        'categoria' => $_POST['categoria'],
        'qtd' => 1,
        'imagem' => $_POST['imagem'] ?? 'img/img_1.jpg',
        'UniMed' => $_POST['UniMed'],
        'estoque' => $_POST['estoque'],
        'estoqueInicial' => $_POST['estoque'],
        'valorBaixa' => 0,
        'valorSolicitar' => 0,

    ];
    header('Location: ' . $_SERVER['PHP_SELF']); // Limpa a URL
    exit;
}

if (isset($_GET['produtoadd']) && $_GET['produtoadd'] === '1') {
    print '<p class="aviso">Produto add com Sucesso!!</p>';
}
$categoria_get = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title><?php print $nomeLoja; ?></title>
</head>

<body>

    <div class="conteiner">
        <h1 class="titulo-login">Faça seu</h1>
        <h1>Login</h1>
        <form class="login-form">
            <label for="email">Email:</label>
            <input class="login" type="email" id="email" placeholder="Faça seu login...">
            <label for="senha">Senha:</label>
            <input class="login" type="password" id="senha" placeholder="Coloque sua senha">
            <button id="btnLogin">Entrar</button>
        </form>
        <p class="inserir">Insira os dados</p>
        <button id="idSolicitar"><u>Solicitar Login</u></button>
    </div>
    <footer>

    </footer>
    <script src="script.js"></script>
</body>

</html>