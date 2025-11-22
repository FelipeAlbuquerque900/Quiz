<?php
$perguntas = json_decode(file_get_contents("perguntas.json"), true);
if ($perguntas === null) {
    die("Erro ao carregar perguntas.json. Verifique o arquivo.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h1>Quiz</h1>
    <form action="resultado.php" method="POST">
        <?php foreach($perguntas as $i => $p): ?>
            <div class="card">
                <p><strong><?php echo ($i+1) . ". " . htmlspecialchars($p['pergunta'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                <?php foreach($p['alternativas'] as $j => $alt): ?>
                    <label>
                        <input type="radio" name="resposta_<?php echo $i; ?>" value="<?php echo $j; ?>" required>
                        <?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button class="btn" type="submit">Finalizar Quiz</button>
    </form>
</div>
</body>
</html>