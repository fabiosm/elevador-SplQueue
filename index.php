<?php
session_start();
require_once 'vendor/autoload.php';

use App\Classes\Elevador;

try {
    /**
     * Classe Elevador
     */
    $Elevador = new Elevador(7, 10);

    $msgMovimentacao = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $andar = isset($_POST['andar']) ? (int)$_POST['andar'] : false;
        $mover = isset($_POST['mover']) ? true : false;

        if ($mover) {
            $msgMovimentacao = $Elevador->mover();
        } else {
            $chamada = $Elevador->chamar($andar);
        }
    }

} catch (InvalidArgumentException $e) {
    echo "Erro: " . $e->getMessage();
    echo "<br/><button onclick=\"location.href = location.href;\">Voltar</button>";
    die();
}

if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Elevador</title>
    </head>
    <body>
        <h1>Elevador</h1>

        <p>
            Andar Atual: <b><?=$Elevador->getAndarAtual();?></b><br/>
            Capacidade do Elevador: <b><?=$Elevador->getCapacidade();?></b><br/>
            Número de Andares: <b><?=$Elevador->getNumAndares();?></b><br/>
        </p>

        <hr/>
        <p>Fila de Chamados: <b><?=implode(', ', (array)$Elevador->getChamadosPendentes());?></b><br/></p>
        <p>Movimentação: <b><?=$msgMovimentacao?></b></p>

        <form method="POST">
            <label for="andar">Chamar Elevador para o andar:</label>
            <input type="number" id="andar" name="andar" min="0" max="<?=$Elevador->getNumAndares();?>" required>
            <button type="submit">Chamar</button>
        </form>

        <br/><br/>

        <form method="post">
            <label for="mover">Mover elevador:</label>
            <input type="hidden" id="mover" name="mover" value="1">
            <button type="submit">Mover elevador</button>
        </form>
        <br/><br/>
        <form method="get">
            <button type="submit" name="reset" value="1">Resetar Sessão</button>
        </form>
    </body>
</html>
