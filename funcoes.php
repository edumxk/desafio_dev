<?php


if (isset($_POST['action'])) 
{
    if($_POST['action'] == 'propagate'){
        $tabelaSessao = $_POST['dados'];
        $novos = setDados($tabelaSessao);
        renderTable($novos);
    }
}

function renderTable($table){
    //limpa a tabela antes de renderizar
    echo "<table class='table' style='margin: 0 auto;'>";
        for ($i = 0; $i < 65 ; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 85 ; $j++) {
                $value = $table[$i][$j];
                $color = $value == 1 ? "green" : "white";
                $color = $value == 3 ? "red" : $color;
                $color = $value == 4 ? "blue" : $color;
                echo "<td style='background-color: $color; width: 8px; height: 8px'></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    echo "</div>";
}

function addBorder($matrix) {
    $rows = count($matrix);
    $cols = count($matrix[0]);

    // Adiciona uma borda de zeros à matriz
    for ($i = 0; $i < $rows; $i++) {
        array_unshift($matrix[$i], 0);
        array_push($matrix[$i], 0);
    }
    $matrix = array_merge([array_fill(0, $cols + 2, 0)], $matrix);
    $matrix = array_merge($matrix, [array_fill(0, $cols + 2, 0)]);

    return $matrix;
}

function removeBorder($matrix) {
    $rows = count($matrix);
    $cols = count($matrix[0]);

    // Remove a borda de zeros da matriz
    for ($i = 0; $i < $rows; $i++) {
        array_shift($matrix[$i]);
        array_pop($matrix[$i]);
    }
    array_shift($matrix);
    array_pop($matrix);

    return $matrix;
}

function getDados($path){
    $arquivo = fopen($path, "r");
    $dados = fread($arquivo, filesize($path));
    fclose($arquivo);
    $dadosArray = [];
    $dados = explode("\n", $dados);

    foreach ($dados as $linha) {
        $linha = explode(" ", $linha);
        $dadosArray[] = $linha;
    }
    return $dadosArray;
}

function setDados($dados){
    $dados = propagarMatriz(getDados("dados2.txt"));
    $arquivo = fopen("dados2.txt", "w");
    //limpa arquivo
    ftruncate($arquivo, 0);
    $dadosSalvar = [];
    foreach ($dados as $linha) {
        $linha = implode(" ", $linha);
        $dadosSalvar[] = $linha;
    }
    $dadosSalvar = implode("\n", $dadosSalvar);
    fwrite($arquivo, $dadosSalvar);
    fclose($arquivo);
    
    return getDados("dados2.txt");
}

function resetDados(){
    $arquivo = fopen("dados2.txt", "w");
    //limpa arquivo
    ftruncate($arquivo, 0);
    $dados = getDados("dados.txt");
    $dadosSalvar = [];
    foreach ($dados as $linha) {
        $linha = implode(" ", $linha);
        $dadosSalvar[] = $linha;
    }
    $dadosSalvar = implode("\n", $dadosSalvar);
    fwrite($arquivo, $dadosSalvar);
    fclose($arquivo);
}

function propagarMatriz($matriz) {
    $matriz = addBorder($matriz); // Adiciona uma borda de zeros à matriz
    //clona matriz
    $matrizClone = $matriz;
    $linhas = count($matriz);
    $colunas = count($matriz[0]);
    
    // Percorre a matriz, exceto as bordas
    for ($i = 1; $i < $linhas - 1; $i++) {
        for ($j = 1; $j < $colunas - 1; $j++) {
            $vizinhos = contarVizinhos($matrizClone, $i, $j);
            if ($matriz[$i][$j] == 0) {
                // Células de valor 0
                if ($vizinhos > 1 && $vizinhos < 5) {
                    $matriz[$i][$j] = 1;
                }
            } else {
                // Células de valor 1
                if ($vizinhos > 3 && $vizinhos < 6) {
                    $matriz[$i][$j] = 1;
                } else {
                    $matriz[$i][$j] = 0;
                }
            }
        }
    }
    $matriz = removeBorder($matriz); // Remove a borda de zeros da matriz
    //seta os valores 3 na primeira celula e 4 na ultima celula
    $matriz[0][0] = 3;
    $linhas = count($matriz);
    $colunas = count($matriz[0]);
    $matriz[$linhas - 1][$colunas - 1] = 4;
    return $matriz;
}

function contarVizinhos($matriz, $linha, $coluna) {
    $contador = 0;
    for ($i = $linha - 1; $i <= $linha + 1; $i++) {
        for ($j = $coluna - 1; $j <= $coluna + 1; $j++) {
            if ($i == $linha && $j == $coluna) {
                continue;
            }
            if ($matriz[$i][$j] == 1) {
                $contador++;
            }
        }
    }
    return $contador;
}


