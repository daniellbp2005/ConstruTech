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
        'estoqueInicial' => $_POST['estoque'],
        'valorBaixa' => 0,
        'valorSolicitar' => 0,
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

            if ($_GET['baixa'] === 'remove') {
                $_SESSION['produtos'][$index]['valorBaixa'] -= 1;
            }
            if ($_GET['baixa'] === 'add') {
                $_SESSION['produtos'][$index]['valorBaixa'] += 1;
            }
            $lmite = 4;
            if ($item['estoque'] <= $limite) {
                $_SESSION['produtos'][$index]['qtd'] += 10;
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
            break;
        }
    }
}
foreach ($_SESSION['produtos'] as $index => $item) {
    $idPega = $_GET['id'] ?? "";

    if (isset($_GET['baixa']) || isset($_GET['solicitar']) || isset($_GET['efetuar'])) {
        if ($item['id'] == $idPega) {

            if (isset($_GET['baixa']) && isset($_GET['id'])) {
                if ($_GET['baixa'] === 'remove') {
                    if ($_SESSION['produtos'][$index]['valorBaixa'] > 1) {
                        $_SESSION['produtos'][$index]['valorBaixa'] -= 1;
                    }
                }
                if ($_GET['baixa'] === 'add') {
                    $_SESSION['produtos'][$index]['valorBaixa'] += 1;
                }
            }

            if (isset($_GET['solicitar']) && isset($_GET['id'])) {
                if ($_GET['solicitar'] === 'remove' && $_SESSION['produtos'][$index]['valorSolicitar'] > 0) {
                    $_SESSION['produtos'][$index]['valorSolicitar'] -= 1;
                }
                if ($_GET['solicitar'] === 'add') {
                    $_SESSION['produtos'][$index]['valorSolicitar'] += 1;
                }
            }

            if (isset($_GET['efetuar']) && $_GET['efetuar'] == 'sim') {
                if ($item['valorBaixa'] > 0) {
                    $_SESSION['produtos'][$index]['estoque'] -= $item['valorBaixa'];        
                    $_SESSION['produtos'][$index]['valorBaixa'] = 0;
                }
                if ($item['valorSolicitar'] > 0) {
                    $_SESSION['produtos'][$index]['estoque'] += $item['valorSolicitar'];
                    $_SESSION['produtos'][$index]['valorSolicitar'] = 0;
                }
            }
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
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
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Unidade</th>
                    <th>Estoque</th>
                    <th>Situação</th>
                    <th>Total:</th>
                    <th>Baixa</th>
                    <th>Solicitar</th>
                    <th>Efetuar</th>
                    <th>Remover</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subTotal = 0;

                foreach ($_SESSION['produtos'] as $mat) {
                    $total = 0;
                    $limiteMinimo = 4;
                    $limiteMedio = 10;
                    $limiteMaximo = $mat['estoque'];
                    $resultado = '';

                    if ($mat['qtd'] > $limiteMinimo) {
                        $resultado = 'MEDIO';
                    }
                    if ($mat['qtd'] > $limiteMedio) {
                        $resultado = 'FINAL';
                    }
                    if ($mat['qtd'] <= $limiteMinimo) {
                        $resultado = 'MUITO';
                    }
                    if ($mat['qtd'] == $mat['estoque']) {
                        $resultado = "Acabou";
                    }


                    $total = $mat['qtd'] * $mat['preco'];
                    $subTotal += $total;
                    $unidade = $mat['UniMed'] ?? '-';
                    echo '
                    <tr class="tab-body">
                    <td class="centro">' . $mat['id'] . '</td>
                    <td>' . $mat['nome'] . '</td>
                    <td>' . $mat['categoria'] . '</td>
                    <td >' . $mat['preco'] . '</td>
                    
                    <td>' . $unidade . '</td>
                    <td>' . $mat['estoque'] . '</td>
                    <td>' . $resultado . '</td>
                    <td>' . $total . '</td>  
                    
                    <td class="">
                    <a href="?baixa=remove&id=' . $mat['id'] . '">-</a>
                    ' . $mat['valorBaixa'] . '
                    <a href="?baixa=add&id=' . $mat['id'] . '">+</a>
                    </td>


                    <td>
                    <a href="?solicitar=remove&id=' . $mat['id'] . '">-</a>
                    ' . $mat['valorSolicitar'] . '
                    <a href="?solicitar=add&id=' . $mat['id'] . '">+</a>
                    </td>


                    <td class="centro">
                    <a href="?efetuar=sim&id=' . $mat['id'] . '">✔</a>
                    </td>
                    <td class=""> 
                    <a href="?acao=apagar&id=' . $mat['id'] . '"><img src="img/lixeira.png" alt="apagar tudo" class="remover"></a>
                    </td>  
                    </tr>
                    ';
                }
                ?>
            </tbody>
            <!--  -->
            <tfoot>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="fundo">Subtotal: </td>
                <td class="fundo"><?php print $subTotal ?></td>
       

            </tfoot>
        </table>
    </div>
    <footer>
        <?php
        require_once 'partials/footer.php'
        ?>
    </footer>
</body>

</html>