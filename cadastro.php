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

    </header>
    <div class="conteinerCad">
        <div class=" cadastroProd">
            <form action="" method="POST">
                <div class="lado-e">
                    <img src="img/cimento.jpg" alt="">
                </div>
                <div class="lado-d">
                    <div class="caixa-form">
                        <div class="form-intro">
                            <h1>Faça seu Cadastro de Produto</h1>
                        </div>
                        <input type="text" name="nome" placeholder="Digite o Nome do Produto" id="nomeProduto"> <!-- coloquei password no nome para escondelo-->
                        <input type="text" name="preco" placeholder="Digite o Preço do Produto" id="precoProduto">
                        <input type="text" name="descricao" placeholder="Digite a Descrição do Produto" id="catagoriaProduto">
                        <select name="categoria" id="catagoriaProduto">
                            <option>Tipo Categoria</option>
                            <option value="Bruto">Bruto</option>
                            <option value="Ferramentas">Ferramentas</option>
                            <option value="Acabamento">Acabamento</option>
                        </select>
                        <input type="url" name="imagem" placeholder="Cole a URL da Imagem (ex: https://example.com/img.jpg)" id="imagemProduto">
                        <button id="btnEnviar" name="enviar" type="submit">Enviar</button>
                        <p class="text-form1" id="paragrafo">Preencha o Formulário</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <footer>
        
    </footer>
</body>

</html>