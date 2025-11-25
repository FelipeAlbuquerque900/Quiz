<?php
$perguntas = json_decode(file_get_contents("perguntas.json"), true);

if ($perguntas === null) {
    die("Erro ao carregar perguntas.json");
}

$acertos = 0;
$resultados = [];

foreach ($perguntas as $i => $p) {
    $campo = "resposta_" . $i;

    if (!isset($_POST[$campo])) {
        $respostaUsuario = null;
    } else {
        $respostaUsuario = intval($_POST[$campo]);
    }

    $correta = intval($p["correta"]);
    $acertou = ($respostaUsuario === $correta);

    if ($acertou) {
        $acertos++;
    }

    $resultados[] = [
        "pergunta" => $p["pergunta"],
        "alternativas" => $p["alternativas"],
        "respostaUsuario" => $respostaUsuario,
        "correta" => $correta,
        "acertou" => $acertou
    ];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Resultado do Quiz</h1>

    <?php foreach ($resultados as $r): ?>
        <div class="card">
            <p><strong><?php echo htmlspecialchars($r["pergunta"]); ?></strong></p>

            <p>
                <strong>Sua resposta:</strong>
                <?php 
                    if ($r["respostaUsuario"] === null) {
                        echo "<span style='color:red'>Não respondida</span>";
                    } else {
                        echo htmlspecialchars($r["alternativas"][$r["respostaUsuario"]]);
                    }
                ?>
            </p>

            <p>
                <strong>Resposta correta:</strong>
                <?php echo htmlspecialchars($r["alternativas"][$r["correta"]]); ?>
            </p>

            <?php if ($r["acertou"]): ?>
                <p style="color:green"><strong>✔ Acertou!</strong></p>
            <?php else: ?>
                <p style="color:red"><strong>✖ Errou!</strong></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <h2>Pontuação final: <?php echo $acertos . " / " . count($perguntas); ?></h2>

    <button><a href="index.php" class="btn">Refazer Quiz</a></button>
</div>

</body>
</html>
