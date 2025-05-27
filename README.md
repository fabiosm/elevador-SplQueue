Projeto Elevador (PHP + SplQueue + Sessão)

Este projeto simula o funcionamento de um elevador utilizando PHP e o conceito de fila (FIFO - First In, First Out) com SplQueue. As chamadas são persistidas em sessão e processadas em ordem.

▶️ Como rodar o projeto

1. Clone o repositório.

2. No terminal, execute:
    composer dump-autoload

⚙️ Funcionalidades:

    Chamada de andares (adicionados à fila).
    Movimentação do elevador de acordo com a ordem das chamadas (FIFO).
    Persistência da fila e do andar atual usando sessão ($_SESSION).
    Validações com InvalidArgumentException.

🔒 Validações
    A capacidade do elevador deve ser maior que zero. (Definida no construtor)
    O número de andares deve ser maior que zero. (Definido no construtor)
    Ao chamar o elevador:
        O andar deve estar entre 0 e o número máximo de andares.
        O andar não pode ser o mesmo onde o elevador já está.
        O andar não pode estar repetido na fila.

Interação
    O usuário pode adicionar quantos andares quiser.
    Cada chamada válida é adicionada à fila de forma persistente.
    Ao clicar em "Mover Elevador", ele se move para o próximo andar da fila, obedecendo a lógica FIFO.

Páginas incluídas
    index.php: Interface interativa com formulários para chamar o elevador e mover entre andares.
    teste.php: Script direto para testar funcionalidades do elevador sem interface

