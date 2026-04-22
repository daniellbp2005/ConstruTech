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
        'estoqueMinimo' => 20,
        'estoqueMedio' => 55,
        'valorBaixa' => 0,
        'valorSolicitar' => 0,
    ];
    exit;
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
        <div class=" cadastroProd">
            <form action="inventario.php" method="POST">
                <div class="lado-e">
                    <img src="img/image.png" alt="">
                </div>
                <div class="lado-d">
                    <div class="caixa-form">
                        <div class="form-intro">
                            <h1 class="titulo-form">Cadastro de Material <span> de Contrução</span></h1>
                        </div>
                        <input type="text" name="nome" placeholder="Digite o Nome do Material" id="">
                        <input type="text" name="preco" placeholder="Digite o Preço Unitário" id="">
                        <input type="text" name="estoque" placeholder="Digite a Quantidade Máxima" id="">
                        <div class="alinhar">
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
                        </div>
                        <input type="url" name="imagem" placeholder="Cole a URL da Imagem (ex: https://example.com/img.jpg)" id="">
                        <button id="btnEnviar" name="enviar" type="submit">Enviar</button>
                        <p class="text-form1" id="paragrafo">Preencha o Formulário</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <?php
        require_once 'partials/footer.php'
        ?>
    </footer>
</body>

</html>