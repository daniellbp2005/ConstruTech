<?php
require_once 'init.php';

// Primeiro: verificar se é atualização de estoque (id_update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id_update'])) {
    $id = $_GET['id_update'];
    if (!empty($_POST['valor'])) {
        $valorDigitado = $_POST['valor'];

        foreach ($_SESSION['produtos'] as $index => $item) {
            if ($item['id'] == $id) {
                $_SESSION['produtos'][$index]['estoque'] += $valorDigitado;
                break;
            }
        }
    } else {
        echo "vazio";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Segundo: criar novo produto (só executa se não for atualização)
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
        'estoqueMinimo' => 20,
        'estoqueMedio' => 55,
        'valorBaixa' => 0,
        'valorSolicitar' => 0,
        'valor' => $_POST['valor']
    ];
    header('Location: ' . $_SERVER['PHP_SELF']); // Limpa a URL
    exit;
}

if (!empty($_SESSION['produtos'])) {
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

    if (!empty($_SESSION['produtos'])) {
        foreach ($_SESSION['produtos'] as $index => $item) {
            $idPega = $_GET['id'] ?? "";

            if (isset($_GET['baixa']) || isset($_GET['solicitar']) || isset($_GET['efetuar'])) {
                if ($item['id'] == $idPega) {

                    if (isset($_GET['baixa']) && isset($_GET['id'])) {
                        if ($_GET['baixa'] === 'remove') {
                            if ($_SESSION['produtos'][$index]['valorBaixa'] > 0) {
                                $_SESSION['produtos'][$index]['valorBaixa'] -= 1;
                            } else {
                                echo "estoque insuficiente";
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
                        if ($item['valorBaixa'] <= $item['estoque']) {
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

        <ul class="categoria">
            <li><a href="inventario.php">Todas</a></li>
            <?php
            foreach ($categoria as $kcat => $index) {
                echo '<li><a href="inventario.php?categoria=' . $kcat . '">' . $index . '</a></li>';
            }
            ?>
        </ul>

        <table>
            <thead>
                <tr class="pular">
                    <th>id</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Unidade</th>
                    <th>Estoque</th>
                    <th>Situação</th>
                    <th>Preço</th>
                    <th>Total:</th>
                    <th>Baixa</th>
                    <th>Solicitar</th>
                    <th>Inserir</th>
                    <th>Efetuar</th>
                    <th>Remover</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $subTotal = 0;
                $categoria_get = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
                if (!empty($_SESSION['produtos'])) {
                    foreach ($_SESSION['produtos'] as $mat) {
                        $total = 0;
                        $limiteMinimo = 20;
                        $limiteMedio = 55;
                        $limiteMaximo = $mat['estoque'];
                        $resultado = '';

                        if ($mat['estoque'] > $limiteMinimo) {
                            $resultado = 'Médio';
                        }
                        if ($mat['estoque'] > $limiteMedio) {
                            $resultado = 'Muito';
                        }
                        if ($mat['estoque'] <= $limiteMinimo) {
                            $resultado = 'Pouco';
                        }
                        if ($mat['estoque'] == 0) {
                            $resultado = "esgotado";
                        }


                        $aviso = "";
                        if ($mat['estoque'] <= $mat['estoqueMinimo']) {
                            $aviso =  'style="color:red; font-weight: bold"';
                        } elseif ($mat['estoque'] <= $mat['estoqueMedio']) {
                            $aviso =  'style="color:orange; font-weight: bold"';
                        } else {
                            $aviso = 'style="color: green; font-weight: bold"';
                        }

                        $total = $mat['estoque'] * $mat['preco'];
                        $subTotal += $total;
                        $unidade = $mat['UniMed'] ?? '-';

                        if ($categoria_get == '' || $mat['categoria'] == $categoria_get) {
                            echo '
                    <tr class="tab-body">
                    <td class="centro">' . $mat['id'] . '</td>
                    <td class="aviso">' . $mat['nome'] . '</td>
                    <td class="aviso">' . $mat['categoria'] . '</td>
                    
                    <td class="aviso">' . $unidade . '</td>
                    <td class="aviso" ' . $aviso . '> ' . $mat['estoque'] . '</td>
                    <td class="aviso">' . $resultado . '</td>
                    <td class="aviso">' . $mat['preco'] . '</td>
                    <td class="aviso">' . $total . '</td>  
                    
                    <td class="meio">
                        <div>
                            <div class="menos"><a href="?baixa=remove&id=' . $mat['id'] . '"><div class="pad">-</div></a></div>
                            ' . $mat['valorBaixa'] . '
                            <div class="mais"> <a href="?baixa=add&id=' . $mat['id'] . '"><div class="pad">+</div></a></div>
                        </div>
                    </td>

                    <td class="meio">
                        <div>
                            <div class="menos"><a href="?solicitar=remove&id=' . $mat['id'] . '"><div class="pad">-</div></a></div>
                            ' . $mat['valorSolicitar'] . '
                            <div class="mais"><a href="?solicitar=add&id=' . $mat['id'] . '"><div class="pad">+</div></a></div>
                        </div>
                    </td>

                     <td>
                        <form-table action="?id_update=' . $mat['id'] . '" method="POST" style="display:flex;width:auto;flex-direction:column;justify-self:center">
                            <input type="text" class="input-table" name="valor">
                            <button class="btn-table" type="submit" name="atz_valor">Enviar</button>
                        </form>
                    </td>

                    <td class="centro">
                        <a href="?efetuar=sim&id=' . $mat['id'] . '">
                            <div class="dois">
                                ✔
                            </div>
                        </a>
                    </td>

                    <td class="centro"> 
                        <a href="?acao=apagar&id=' . $mat['id'] . '">
                            <div>
                                <img src="img/lixeira.png" alt="apagar tudo" class="remover">                        
                            </div>
                        </a>
                    </td>  
                    </tr>
                    ';
                        }
                    }
                } else {
                    echo '
                    <tr>
                        <td>
                            Sem produtos Cadastrados
                        </td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
            <!--  -->
            <tfoot>
                <tr class="pular">
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
                    <td></td>
                    <td></td>
                    <td class="alinhar">Subtotal: </td>
                    <td class="alinhar"><?php echo number_format($subTotal, 2, ',', '.') ?></td>
                </tr>
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