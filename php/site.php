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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

</head>

<body>
    <header>
        <div class="alert bg-color-red">
            <p><a>Aviso:</a> este site é amador e os dados são apenas aproximações matemáticas.</p>
        </div>
    </header>

    <main>
        <div class="container">
            <h1 id="value">O R0 atual de Sorocaba é
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
            <h2>O que é o R0?</h2>
            <p>
                O Número Básico de Reprodução, mais conhecido como R0, nos diz o número de pessoas que serão contaminadas a partir de um único indivíduo
                infectado, que servirá como fonte da doença.
                O R0 é calculado quando se tem uma população não vacinada,
                sem contato prévio com o patógeno e quando não há formas de controlar sua dispersão.
                O “novo coronavírus” SARS-CoV-2 se encaixa nestes pré-requisitos.
            </p>

            <p>
                Para que possamos entender melhor a relação entre o valor do
                R0 e as consequências em termos de doenças infecto-contagiosas,
                veja as diferentes possibilidades abaixo:
            </p>
            <ol>
                <li><a>Se o R0 for menor que 1:</a> isto significa que cada indivíduo infectado gerará menos que um outro indivíduo infectado. A chance de transmissão é muito baixa e a doença tenderá a decair e a desaparecer.</li>
                <li><a>Se o R0 for igual a 1:</a> neste caso, cada indivíduo infectado causa uma nova infecção e a doença permanecerá, pois será transmitida de indivíduo em indivíduo, de forma estável, sem que ocorra uma epidemia. A doença pode permanecer na mesma região ou população por longos períodos de tempo.</li>
                <li><a>Se o R0 for maior que 1:</a> aqui a situação fica mais preocupante porque cada indivíduo infectado causa mais que uma nova infecção, isto é, infecta mais que um indivíduo. Nestes casos, ocorrerá um surto, uma epidemia ou uma pandemia. Quanto mais elevado o valor do R0, maior será a transmissibilidade e maior será a população potencialmente afetada pelo agente infeccioso.</li>
            </ol>
        </div>

        <div class="container">
            <canvas id="myChart"></canvas>
        </div>

        <script>
            let myChart = document.getElementById('myChart').getContext('2d');

            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#777';

            var xmlhttp = new XMLHttpRequest();
            var url = "r0_values.json";

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myArr = JSON.parse(this.responseText);
                    

                    var label = [];
                    var y = [];
                    for(const x of myArr['r0']){
                        label.push(x['date'])
                        y.push(x['value'])
                    }


                    let lineChart = new Chart(myChart, {
                            type:'line', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                            data:{
                                labels: label,
                                datasets:[{
                                label:'Dia',
                                data: y
                                }]
                            },
                            options:{
                                title:{
                                display:true,
                                text:'Valores R0 pelo tempo',
                                fontSize:25
                                },
                                legend:{
                                display:true,
                                position:'right',
                                labels:{
                                    fontColor:'#000'
                                }
                                },
                                layout:{
                                padding:{
                                    left:50,
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


    </main>

    <footer>
        <p>Contribuintes: Guilherme Milani, Gabriel Kyomen, Marcos Santana, Jean Wylmer</p>
        <p>Link para o repositório:
            <a href="https://github.com/GuiMilani/covid-sorocaba">GuiMilani/covid-sorocaba</a>
        </p>
        <p>Referência</p>
    </footer>
</body>

</html>