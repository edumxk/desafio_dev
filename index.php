<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DADOS</title>
</head>
<body> 
    <?php
        $arquivo = fopen("dados.txt", "r");
        $dados = fread($arquivo, filesize("dados.txt"));
        fclose($arquivo);
        //echo $dados;
        ?>

    <table>
        <tbody>
            <?php //foreach em dados em uma tabela 65 linhas e 85 colunas
            $dados = explode("\n", $dados);
    foreach ($dados as $linha) {
        $linha = explode(" ", $linha);
        echo "<tr>";
        foreach ($linha as $coluna) {
            echo "<td>$coluna</td>";
        }
        echo "</tr>";
    }

            ?>

        </tbody>
    </table>

    
</body>
</html>