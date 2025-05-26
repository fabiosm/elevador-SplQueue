<?php
require_once 'vendor/autoload.php';

use App\Classes\Elevador;

$Elevador = new Elevador(7, 10, false);

// Faz as chamadas para os andares
$Elevador->chamar(3);
$Elevador->chamar(5);
$Elevador->chamar(7);
$Elevador->chamar(9);
$Elevador->chamar(10);

echo 'Fila de andares chamados: ' . implode(', ', (array)$Elevador->getChamadosPendentes()) . '<br/>';
echo '<br/><hr/><br/>';
echo 'Processa as chamadas: <br/>';
while ($Elevador->getChamadosPendentes()) {
    $msgMovimentacao = $Elevador->mover();
    echo $msgMovimentacao . '<br/>';
}

echo 'Andar Atual: ' . $Elevador->getAndarAtual() . '<br/>';
