Biblioteca API
==============

Descrição
---------

Este projeto é uma API RESTful para um sistema de gerenciamento de biblioteca desenvolvido com Laravel. A API permite gerenciar autores, livros e empréstimos, e inclui autenticação e documentação da API.

Tecnologias Utilizadas
----------------------

*   Laravel 10
*   MySQL
*   Swagger para documentação da API
*   Sanctum para autenticação

Instalação
----------

### Pré-requisitos

Certifique-se de ter o PHP, Composer e MySQL instalados em sua máquina.

### Passos para Instalação

1.  **Clone o Repositório**
    
        git clone https://github.com/seu-usuario/biblioteca-api.git
    
2.  **Acesse o Diretório do Projeto**
    
        cd biblioteca-api
    
3.  **Instale as Dependências**
    
        composer install
    
4.  **Configure o Ambiente**
    
    Copie o arquivo `.env.example` para `.env` e ajuste as configurações conforme necessário.
    
        cp .env.example .env
    
    Configure as variáveis de ambiente no arquivo `.env`, incluindo a configuração do banco de dados.
    
5.  **Gere a Chave de Aplicação**
    
        php artisan key:generate
    
6.  **Execute as Migrations**
    
        php artisan migrate
    
7.  **Instale o Swagger**
    
    Execute o comando para instalar o Swagger se não estiver incluído:
    
        composer require darkaonline/l5-swagger
    
    Publique o arquivo de configuração do Swagger:
    
        php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
    
    Atualize o arquivo de configuração do Swagger em `config/l5-swagger.php` para incluir sua documentação.
    
8.  **Execute o Servidor**
    
        php artisan serve
    
    A API estará disponível em [http://localhost:8000](http://localhost:8000).
    

Rotas da API
------------

### Autores

*   **Listar Autores**
    
        GET /authors
    
*   **Criar Autor**
    
        POST /authors
    
*   **Obter Autor**
    
        GET /authors/{id}
    
*   **Atualizar Autor**
    
        PUT /authors/{id}
    
*   **Deletar Autor**
    
        DELETE /authors/{id}
    

### Livros

*   **Listar Livros**
    
        GET /books
    
*   **Criar Livro**
    
        POST /books
    
*   **Obter Livro**
    
        GET /books/{id}
    
*   **Atualizar Livro**
    
        PUT /books/{id}
    
*   **Deletar Livro**
    
        DELETE /books/{id}
    

### Empréstimos

*   **Listar Empréstimos**
    
        GET /loans
    
*   **Criar Empréstimo**
    
        POST /loans
    
*   **Obter Empréstimo**
    
        GET /loans/{id}
    
*   **Atualizar Empréstimo**
    
        PUT /loans/{id}
    
*   **Deletar Empréstimo**
    
        DELETE /loans/{id}
    

Documentação da API
-------------------

A documentação da API está disponível em:

*   [Documentação Swagger](http://localhost:8000/docs)

Testes
------

Para executar os testes automatizados, use o comando:

    php artisan test
