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
        'UniMed' => $_POST['UniMed'],
    ];
    // header('Location: produto.php?produtoadd=1');
    header('Location: ' . $_SERVER['PHP_SELF']); // Limpa a URL
    exit;
    
}

if(isset($_GET['acao'])){
    $id = $_GET['id'] ?? '';
    if($_GET['acao'] == 'add'){
        $_SESSION['produtos'][$id]['qtd'] += 1;
    }
    if($_GET['acao'] == 'remove'){
        unset($_SESSION['produtos'][$id]);
    }
}
$subTotal = 0;

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
    <div class="conteinerCad">
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Total:</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($_SESSION['produtos'] as $mat){
                    $unidade = $mat['UniMed'] ?? '-';
                    echo '
                    <tr>
                    <th>'.$mat['id'].'</th>
                    <th>'.$mat['nome'].'</th>
                    <th>'.$mat['categoria'].'</th>
                    <th>'.$mat['preco'].'</th>
                    <th>
                    <a href="?acao=remove&id=<?= $id ?>">-</a>
                    '.$mat['qtd'].'
                    <a href="?acao=add&id=<?= $id ?>">+</a>
                    </th>
                    <th>'.$unidade.'</th>
                    <th>'.$subTotal.'</th>  
                    </tr>
                    ';
                }
                ?>
            </tbody>
            
        </table>
    </div>
    <footer>
        
    </footer>
</body>

</html>