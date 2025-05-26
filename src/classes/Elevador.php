<?php

namespace App\Classes;

/**
 * Classe Elevador
 * Representa um elevador com capacidade limitada e funcionalidade de chamada.
 */
class Elevador {
    private $filaChamados;
    private $andarAtual;
    private $capacidade;
    private $numAndares; // Número de andares do prédio

    /**
     * Construtor da classe Elevador.
     * @param int $capacidade A capacidade máxima do elevador, número de pessoas.
     * Inicializa a fila de chamados, o andar atual e a capacidade do elevador.
     */
    public function __construct(int $capacidade = 7, $numAndares = 10, $comSessao = true) {
        if ($capacidade <= 0) {
            throw new \InvalidArgumentException("Capacidade do elevador deve ser maior que zero.");
        }

        if ($numAndares <= 0) {
            throw new \InvalidArgumentException("Número de andares deve ser maior que zero.");
        }

        $this->filaChamados = new \SplQueue();

        if ($comSessao) {
            $this->atualizarFilaChamados();
        }

        $this->andarAtual = (empty($_SESSION['ANDAR_ATUAL']) || !$comSessao) ? 0 : $_SESSION['ANDAR_ATUAL']; // Andar inicial do elevador - Térreo

        $this->capacidade = $capacidade;
        $this->numAndares = $numAndares;
    }

    /**
     * Adiciona um chamado à fila do elevador.
     * @param int $andar O andar para o qual o elevador deve ir.
     * @return void
     */
    public function chamar(int $andar): int {
        if ($andar < 0 || $andar > $this->numAndares) {
            throw new \InvalidArgumentException("Andar inválido. Deve ser entre 0 e " . $this->numAndares . ".");
        }

        if ($this->andarAtual === $andar) {
            throw new \InvalidArgumentException("Se o elevador já está no andar solicitado, não adiciona à fila.");
        }

        // Verifica se o andar já está na fila de chamados
        if (in_array($andar, iterator_to_array($this->filaChamados))) {
            throw new \InvalidArgumentException("Andar já está na fila de chamados.");
        }

        $_SESSION['FILA_CHAMADOS'][] = $andar;
        $this->filaChamados->enqueue($andar);

        return $andar;
    }

    /**
     * Move o elevador para o próximo andar na fila de chamados.
     */
    public function mover(): string {
        // Verifica se há chamados pendentes
        if ($this->filaChamados->isEmpty()) {
            return "Nenhum chamado pendente.<br/>\n";
        }

        $andarAtual = $this->andarAtual;
        $_SESSION['ANDAR_ATUAL'] = $this->andarAtual = $this->filaChamados->dequeue();

        // Atualiza a sessão para refletir a fila de chamados
        $_SESSION['FILA_CHAMADOS'] = iterator_to_array($this->filaChamados);

        // Simula o movimento do elevador
        return "Elevador movendo do andar " . $andarAtual . " para o andar: " . $this->andarAtual . "<br/>\n";
    }

    /**
     * Retorna o andar atual do elevador.
     * @return int O andar atual do elevador.
     */
    public function getAndarAtual(): int {
        return $this->andarAtual;
    }

    /**
     * Retorna os chamados pendentes na fila do elevador.
     * @return SplQueue A fila de chamados pendentes.
     */
    public function getChamadosPendentes(): array {
        return iterator_to_array($this->filaChamados);
    }

    /**
     * Retorna a capacidade do elevador.
     * @return int A capacidade do elevador.
     */
    public function getCapacidade(): int {
        return $this->capacidade;
    }

    /**
     * Retorna o número de andares do prédio.
     * @return int O número de andares do prédio.
     */
    public function getNumAndares(): int
    {
        return $this->numAndares;
    }

    /**
     * Atualiza fila de chamados da sessão.
     */
    private function atualizarFilaChamados() {
        if (isset($_SESSION['FILA_CHAMADOS'])) {
            foreach ($_SESSION['FILA_CHAMADOS'] as $filaAndar) {
                $this->filaChamados->enqueue($filaAndar);
            }
        }
    }
}
