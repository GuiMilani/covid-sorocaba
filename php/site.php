<?php
include 'api.php'; ?>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site que calcula R0 na cidade de Sorocaba">
    <meta name="keywords" content="sorocaba, covid, r0, infecção">
    <title>covid Sorocaba</title>
</head>

<body>
    <p id="disclaimer">Aviso: este site é amador e os dados são apenas aproximações matemáticas</p>

    <h1 id="value">O R0 é <?php echo getR0(); ?>
    </h1>

    <h2>O que é o R0?</h2>
    <p>É o número de pessoas infectadas a partir de um único indivíduo infectado por Covid-19</p>

    <footer>
        <p>Contribuintes: Guilherme Milani, Gabriel Kyomen, Marcos Santana</p>
        <p>Link para o repositório:
            <a href="https://github.com/GuiMilani/covid-sorocaba">GuiMilani/covid-sorocaba</a>
        </p>
        <p>Referência</p>
    </footer>
</body>

</html>