<?php

$nomeLoja = "ConstruTech";

$categoria = [
    'Bruto' => 'Bruto',
    'Acabamento' => 'Acabamento',
    'Ferramentas' => 'Ferramentas',
];

$produtosBase = [
    [

        'id' => 1,
        'nome' => 'Cimento',
        'preco' => 15.99,
        // 'descricao' => 'algo',
        'imagem' => 'img/cimento.jpg',
        'categoria' => 'Bruto',
        'qtd' => 1,
        'UniMed' => 'kg',
        'estoque' => 20
    ],
    [
        'id' => 2,
        'nome' => 'Areia',
        'preco' => 4.99,
        // 'descricao' => "",
        'imagem' => 'img/areia.webp',
        'categoria' => 'Bruto',
        'qtd' => 1,
        'UniMed' => 'kg',
        'estoque' => 20
    ],
    [
        'id' => 3,
        'nome' => 'Martelo',
        'preco' => 29.99,
        // 'descricao' => "",
        'imagem' => 'img/martelo.jpg',
        'categoria' => 'Ferramentas',
        'qtd' => 1,
        'UniMed' => '-',
        'estoque' => 15
    ],
    [
        'id' => 4,
        'nome' => 'Piso de Cerâmico',
        'preco' => 24.99,
        // 'descricao' => "",
        'imagem' => 'img/piso.jpg',
        'categoria' => 'Acabamento',
        'qtd' => 1,
        'UniMed' => 'm2',
        'estoque' => 25
    ],
];
