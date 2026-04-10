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
        'qtd' => $_POST['qtd'],
        'imagem' => $_POST['imagem'] ?? 'img/img_1.jpg',
        'UniMed' => $_POST['UniMed']
    ];
    header('Location: produto.php?produtoadd=1');
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
    <link rel="stylesheet" href="style.css">
    <title><?= print $nomeLoja; ?></title>
</head>

<body>
    <?= 
    require_once 'partials/header.php'
    ?>
    <div class="conteiner">
        <div class="row">
            <?=
            print '
            <h2>Gerenciamento de Estoque</h2>
            <ul>
                <li><a href="index.php">Todos</a></li>
            ';
            foreach ($categoria as $kcat => $catNome) {
                print '<li><a href="index.php?categoria=' . $kcat . '">' . $catNome . '</a></li>';
            }
            print '</ul>'
            ?>
        </div>
        <div class="paicard">
            <?php
            foreach ($_SESSION['produtos'] as $produto) {
                if ($categoria_get == '' || $produto['categoria'] == $categoria_get) {
                    echo '
                    <div class="col">
                            <div class="cima">
                                <select name="" id="">
                                    <option value=""> Mais</option>
                                    <option value=""> Acessar</option>
                                </select>
                                <img src="' . $produto['imagem'] . '" alt="">
                            </div>
                            <div class="baixo">
                                <a href="produto.php?id=' . $produto['id'] . '">
                                
                                    <!-- <button class="button-col">comprar</button> -->
                                    <p class="preco">R$: ' . $produto['preco'] . '</p>
                                </a>
                            </div>
                    </div>
                    ';
                }
            }
            ?>
        </div>
    </div>
    <footer>

    </footer>
</body>

</html>