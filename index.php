<?php
require_once 'init.php';
require_once 'data.php';
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
    <header>
        <!-- <nav>
            <img src="..." alt="">
            <ul class="menu">
                <li>Home</li>
                <li>Cadastro Produto</li>
                <li>Login</li>
            </ul>
        </nav> -->
    </header>
    <div class="conteiner">
        <div class="row">
            <?=
            print '
            <h2>Catálogo de Produtos</h2>
            <ul>
                <li><a href="cadastro.php">Todos</a></li>
            ';
            foreach ($categoria as $kcat => $catNome) {
                print '<li><a href="index.php?=categoria=' . $kcat . '">' . $catNome . '</a></li>';
            }
            print '</ul>'
            ?>

        </div>
        <div class="paicard">
            <?php
            foreach ($produtosBase as $produto){
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
                            <div class="NomeProd">' . $produto['descricao'] . ' </div>
                            <!-- <button class="button-col">comprar</button> -->
                            <p class="preco">R$: ' . $produto['preco'] . '</p>
                        </a>
                    </div>
            </div>
            ';
            }
            ?>
        </div>
        
        </div>
        
    </div>
    <footer>

    </footer>
</body>

</html>