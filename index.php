<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>DADOS</title>
</head>
<body> 
    <div style="text-align: center;">
        <h2 id="gen"></h2>

    </div>
    <?php
        require_once "funcoes.php";
        resetDados2();
        $dadosArray = getDados("dados.txt");
    echo '<div class="container">';
        renderTable($dadosArray);
    echo '</div>';

?>
<button type="button" onclick="propagate()">Propagar</button>


<script>
    var cont = 0;
    //rodar a propagate a cada 200ms
    setInterval(propagate, 200);

    function propagate() {
       

        //chamar função Propagate no arquivo funcoes.php passando como parâmetro a tabela
        
        $.ajax({
            url: 'funcoes.php',
            type: 'POST',
            data: {action: 'propagate', dados: <?php echo json_encode($dadosArray); ?>},
            success: function(response) {
                console.log(response);
                $(".table").html("");
                $(".table").html(response);
                $("#gen").html("Geração: " + cont);
                cont++;
            }
        });
    }

</script>    
</body>
</html>