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
        'qtd' =>  1,
        'imagem' => $_POST['imagem'] ?? 'img/img_1.jpg',
        'UniMed' => $_POST['UniMed'],
        'estoque' => $_POST['estoque'],
        'estoqueInicial' => $_POST['estoque']
    ];
    header('Location: ' . $_SERVER['PHP_SELF']); // Limpa a URL
    exit;
}

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $idPega = $_GET['id'];
    $erro = false;
    // $limiteMaximo = 
    foreach ($_SESSION['produtos'] as $index => $item) {
        if ($item['id'] == $idPega) {
            if ($_GET['acao'] === 'add') {
                if ($item['qtd'] < $item['estoque']) {
                    $_SESSION['produtos'][$index]['qtd'] += 1;
                } else {
                    $erro = true;
                }
            }
            // else if( $_GET['acao'] === 'add' && limite atingido), aq tem q delimitar a qtd maxima de produtos, tipo n permitir um valor maior que o estoque
            if ($_GET['acao'] === 'remove') {
                if ($_SESSION['produtos'][$index]['qtd'] > 1) {
                    $_SESSION['produtos'][$index]['qtd'] -= 1;
                } else {
                    unset($_SESSION['produtos'][$index]);
                    $_SESSION['produtos'] = array_values($_SESSION['produtos']); // reorganiza o indice do arrray
                }
            }
            if ($_GET['acao'] === 'apagar') {
                unset($_SESSION['produtos'][$index]);
                $_SESSION['produtos'] = array_values($_SESSION['produtos']); // reorganiza o indice do arrray
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
            break;
        }
       
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <title><?php print $nomeLoja; ?></title>
</head>

<body>
    <?php
    require_once 'partials/header.php'
    ?>
    <div class="conteinerCad">
        
    </div>
    <footer>
        <?php
        require_once 'partials/footer.php'
        ?>
    </footer>
</body>

</html>