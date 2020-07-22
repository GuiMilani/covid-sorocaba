# R0 da COVID-19 na cidade de Sorocaba

## Conceito do projeto

O projeto visa calcular e projetar o Número de Reprodução Básico (R0) da COVID-19 em Sorocaba-SP, um dado que, por muitas vezes, é deixado de lado por orgãos públicos, porém tem sua eficácia comprovada em analisar o contágio da doença e mensurar os esforços no controle da pandemia, visto que nos mostra quantas pessoas serão infectadas a partir de um único indivíduo portador do patógeno.
  
## Pré-requisitos e recursos utilizados

Utilizamos a linguagem PHP na implementação geral do projeto, com uso também de HTML, CSS, JavaScript e JSON, além de testar o site em servidor Apache local por meio do pacote XAMPP.
Importamos a biblioteca [Charts.js](https://www.chartjs.org/) em JavaScript para montagem de gráfico e os seguintes tutoriais como base para trechos do código:
1. [Efficiently counting the number of lines of a text file.](https://stackoverflow.com/questions/2162497/efficiently-counting-the-number-of-lines-of-a-text-file-200mb)
2. [how to rewind() an http stream file in PHP other than fclose() and fopen() again?](https://stackoverflow.com/questions/4986335/how-to-rewind-an-http-stream-file-in-php-other-than-fclose-and-fopen-again/6518288#6518288?newreg=435a966ca5a646fca605703fa27bec30)
3. [php.net/manual/strtok](https://www.php.net/manual/en/function.strtok)

## Passo a passo

1. Passamos por um processo de pesquisa sobre o cálculo do R0 e busca de fontes de estudo epidemiológicas confiáveis. (Caso deseje mais informações sobre esse passo entre em contato com [GuiMilani](https://github.com/GuiMilani/))
2. Foi criado um protótipo em C que lia um arquivo .csv providenciado pela Prefeitura e calculava o R0.
3. Protótipo foi transformado em código PHP e um formato base em HTML(index.php) também foi criado.
4. Colocamos as funções que tratavam explicitamente do R0 numa API(api.php).
5. Passamos a guardar os valores previamente calculados num arquivo JSON(r0_values.json).
6. Estilização do site criada(style.css).
7. Adicionamos um gráfico alimentado pelo json criado, depois o tornamos responsivo.
8. Um domínio foi comprado e hospedado para divulgação do site com a comunidade. Pode ser encontrado em http://covidsorocaba.online até Julho de 2021.

## Instalação / Execução

  * Baixe a pasta com todos os arquivos e instale XAMPP na sua máquina.
  * Execute, no terminal, o comando:
  ```
  php -S localhost:4000
  ```
  * Abra seu navegador em " localhost:4000/(caminho até o arquivo index.php) "

## Bugs/problemas conhecidos
Alguns problemas envolvendo o armazenamento dos dados no arquivo r0_values.json, como a atribuição de valores nulos quando o arquivo é manipulado de forma específica e erros em atualizar automaticamente o arquivo. Possíveis causas não são claras mas há chances do problema estar na função store_r0 dentro do arquivo api.php.

## Autores


* Guilherme Milani de Oliveira - Pesquisa, desenvolvedor back-end e detalhes no front-end
* Jean Wylmer Flores - Estilização do site e implementação do gŕafico
* Gabriel Kyomen - Formatação da estrutura básica HTML

## Demais anotações e referências

#### O que é o R0?

O Número Básico de Reprodução, mais conhecido como R0 (pronuncia-se "R-zero"), nos diz o número de pessoas que irão contrair a doença a partir de uma única pessoa que já está com o vírus, ou seja, este indivíduo contaminado servirá como fonte da doença. Por exemplo, se o R0 é estimado em dois, cada pessoa doente transmitirá para outras duas aproximadamente. O R0 é calculado quando se tem uma população não vacinada, sem contato prévio com o patógeno e quando não há formas de controlar sua dispersão. O “novo coronavírus” SARS-CoV-2 se encaixa nestes pré-requisitos.

Os dados utilizados como fonte são providenciados pela Prefeitura de Sorocaba no seguinte link: http://www.sorocaba.sp.gov.br/coronavirus/painel-grafico/

O R0 foi calculado utilizando como base este artigo: https://hal.archives-ouvertes.fr/hal-02509142v2/file/epidemie_pt.pdf

Uma simples explicação sobre o Número Básico de Reprodução: https://www.luciacangussu.bio.br/entenda_o_r0_na_covid-19_e_suas_consequencias/

## Imagens/screenshots

Função que calcula o R0 a partir dos valores dados:

![Imagem](https://github.com/GuiMilani/covid-sorocaba/blob/master/example-1.png)

Como ficou a página inicial do site:

![Imagem](https://github.com/GuiMilani/covid-sorocaba/blob/master/example-2.png)

Como ficou o gráfico na versão desktop:

![Imagem](https://github.com/GuiMilani/covid-sorocaba/blob/master/example-3.png)

Atila Iamarino me respondendo no Twitter:

![Imagem](https://github.com/GuiMilani/covid-sorocaba/blob/master/example-4.jpeg)
