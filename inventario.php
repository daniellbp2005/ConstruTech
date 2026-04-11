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

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $idPega = $_GET['id'];
    foreach ($_SESSION['produtos'] as $index => $item) {
        if ($item['id'] == $idPega) {
            if ($_GET['acao'] === 'add') {
                $_SESSION['produtos'][$index]['qtd'] += 1;
            }
            if ($_GET['acao'] === 'remove') {
                if ($_SESSION['produtos'][$index]['qtd'] > 1) {
                    $_SESSION['produtos'][$index]['qtd'] -= 1;
                } else {
                    unset($_SESSION['produtos'][$index]);
                    $_SESSION['produtos'] = array_values($_SESSION['produtos']); // reorganiza o indice do arrray
                }
            }
            break;
        }
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
    <title><?php print $nomeLoja; ?></title>
</head>

<body>
    <?php
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
                $subTotal = 0;
                foreach ($_SESSION['produtos'] as $mat) {
                    $total = 0;

                    $total = $mat['qtd'] * $mat['preco'];
                    $subTotal += $total;
                    $unidade = $mat['UniMed'] ?? '-';
                    echo '
                    <tr>
                    <td>' . $mat['id'] . '</td>
                    <td>' . $mat['nome'] . '</td>
                    <td>' . $mat['categoria'] . '</td>
                    <td>' . $mat['preco'] . '</td>
                    <td class="centro">
                    <a href="?acao=remove&id=' . $mat['id'] . '">-</a>
                    ' . $mat['qtd'] . '
                    <a href="?acao=add&id=' . $mat['id'] . '">+</a>
                    </td>
                    <td>' . $unidade . '</td>
                    <td>' . $total . '</td>  
                    </tr>
                    ';
                }
                ?>
            </tbody>
            <tfoot>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Subtotal: </td>
                <td><?php print $subTotal ?></td>
            </tfoot>
        </table>
    </div>
    <footer>

    </footer>
</body>

</html>