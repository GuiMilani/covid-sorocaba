<?php
include 'api.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>covid Sorocaba</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site que calcula R0 na cidade de Sorocaba">
    <meta name="keywords" content="sorocaba, covid, r0, infecção">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

</head>

<body>
    <header>
        <div class="alert bg-color-red">
            <p><a>Aviso:</a> este site é amador e os dados são apenas aproximações matemáticas.</p>
        </div>
    </header>

    <main>
        <div class="container">
            <h1 id="value">O R0 atual da COVID-19 em Sorocaba é
                <a class=<?php $r0 = getR0();
                            if ($r0 > 1) {
                                echo "danger-color";
                            } else {
                                echo "safe-color";
                            } ?>><?= $r0 ?>
                </a>
            </h1>
        </div>
        <div class="container">
            <br><h2>O que é o R0?</h2><br>
            <p>
                O Número Básico de Reprodução, mais conhecido como R0, nos diz o número de pessoas que irão contrair a doença a partir de uma única
                pessoa que já está com o vírus, ou seja, este indivíduo contaminado servirá como fonte da doença. Por exemplo,
                se o R0 é estimado em dois, cada pessoa doente transmitirá para outras duas aproximadamente.
                O R0 é calculado quando se tem uma população não vacinada,
                sem contato prévio com o patógeno e quando não há formas de controlar sua dispersão.
                O “novo coronavírus” SARS-CoV-2 se encaixa nestes pré-requisitos.
            </p>

            <p>
                Para que possamos entender melhor a relação entre o valor do
                R0 e as consequências em termos de doenças contagiosas,
                veja as diferentes possibilidades abaixo:
            </p><br>
            <ol>
                <li><a>Se o R0 for menor que 1:</a> isto significa que cada indivíduo infectado gerará menos que um outro indivíduo infectado. A chance de transmissão é muito baixa e a doença tenderá a decair e a desaparecer.</li>
                <li><a>Se o R0 for igual a 1:</a> neste caso, cada indivíduo infectado causa uma nova infecção e a doença permanecerá, pois será transmitida de indivíduo em indivíduo, de forma estável, sem que ocorra uma epidemia. A doença pode permanecer na mesma região ou população por longos períodos de tempo.</li>
                <li><a>Se o R0 for maior que 1:</a> aqui a situação fica mais preocupante porque cada indivíduo infectado causa mais que uma nova infecção, isto é, infecta mais que um indivíduo. Nestes casos, ocorrerá um surto, uma epidemia ou uma pandemia. Quanto mais elevado o valor do R0, maior será a transmissibilidade e maior será a população potencialmente afetada pelo agente infeccioso.</li>
            </ol>
        </div>

        <div class = "container">
            <h2>R0 em Sorocaba ao longo dos dias:</h2>
        </div>

        <div class = "graph">
            <canvas id="myChart"></canvas>
        </div>

        <script> //javascript with chart.js
            let myChart = document.getElementById('myChart').getContext('2d');

            // Global Options
            var w = window; var x = w.innerWidth; var textsize = 14;
            if(x>768){
                textsize = 24;
            } // Manipulating the client window size to properly size the label font inside the graph
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = textsize;
            Chart.defaults.global.defaultFontColor = '#777';

            var xmlhttp = new XMLHttpRequest();
            var url = "r0_values.json";

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myArr = JSON.parse(this.responseText);
                    //a few steps to open the json with all the data needed 

                    var label = [];
                    var y = [];
                    for(const x of myArr['r0']){
                        label.push(x['date'])
                        y.push(x['value'])
                    } // putting the data inside formatted arrays


                    let lineChart = new Chart(myChart, {
                            type:'line', // line
                            data:{
                                labels: label,
                                datasets:[{
                                label:'R0',
                                data: y
                                }]
                            },
                            options:{
                                responsive: true,
                                title:{
                                display:false,
                                },
                                legend:{
                                display:false
                                },
                                layout:{
                                padding:{
                                    left:0,
                                    right:0,
                                    bottom:0,
                                    top:0
                                }
                                },
                                tooltips:{
                                enabled:true
                                }
                            }
                            });
                }
            };
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

        </script>

        <div class = "container">
            <h2>Referências:</h2><br>
            <ul>
                <li>
                    Os dados utilizados como fonte são providenciados pela
                    Prefeitura de Sorocaba no seguinte link: 
                    <a href="http://www.sorocaba.sp.gov.br/coronavirus/painel-grafico/">sorocaba.sp.gov.br/coronavirus/painel-grafico</a>
                </li><br>
                <li>
                    O R0 foi calculado utilizando como base este artigo:
                    <a href="https://flaviovdf.github.io/covid19/">
                    Um modelo matemático da epidemia de coronavírus na França</a>
                </li><br>
                <li>
                    Estimativas de R0 por Estados do Brasil: 
                    <a href="https://hal.archives-ouvertes.fr/hal-02509142v2/file/epidemie_pt.pdf">
                    flaviovdf.github.io/covid19/</a>
                </li><br>
                <li>
                    Uma simples explicação sobre o Número Básico de Reprodução: 
                    <a href="https://www.luciacangussu.bio.br/entenda_o_r0_na_covid-19_e_suas_consequencias/">
                    luciacangussu.bio.br/entenda_o_r0_na_covid-19_e_suas_consequencias/</a>
                </li><br>
                <li>
                Rede multidisciplinar com o objetivo de coletar, analisar, modelar e divulgar dados relativos a COVID-19 no Brasil: 
                <a href="https://redeaanalisecovid.wordpress.com/">
                Rede Análise COVID-19</a>
                </li><br>

            </ul>
        </div>

    </main>

    <footer>
        <p>Contribuintes: Guilherme Milani, Gabriel Kyomen, Marcos Santana, Jean Wylmer</p><br>
        <p>Link para o repositório:
            <a href="https://github.com/GuiMilani/covid-sorocaba">GuiMilani/covid-sorocaba</a>
        </p>
    </footer>
</body>

</html>