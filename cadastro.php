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
    // header('Location: produto.php?produtoadd=1');
    exit;
}
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
        <div class=" cadastroProd">
            <form action="index.php" method="POST">
                <div class="lado-e">
                    <img src="img/cimento.jpg" alt="">
                </div>
                <div class="lado-d">
                    <div class="caixa-form">
                        <div class="form-intro">
                            <h1>Faça seu Cadastro de Material</h1>
                        </div>
                        <input type="text" name="nome" placeholder="Digite o Nome do Material" id="">
                        <input type="text" name="preco" placeholder="Digite o Preço Unitário" id="">
                        <input type="text" name="qtd" placeholder="Digite a Descrição do Material" id="">
                        <select name="categoria" id="">
                            <option>Tipo Categoria</option>
                            <option value="Bruto">Bruto</option>
                            <option value="Ferramentas">Ferramentas</option>
                            <option value="Acabamento">Acabamento</option>
                        </select>
                        <select name="UniMed" id="">
                            <option>Tipo Medida</option>
                            <option value="m2">m²</option>
                            <option value="kg">kg</option>
                            <option value="-">-</option>
                        </select>
                        <input type="url" name="imagem" placeholder="Cole a URL da Imagem (ex: https://example.com/img.jpg)" id="">
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