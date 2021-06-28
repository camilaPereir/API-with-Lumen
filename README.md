# API Restful With Lumen

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

## Objetivo da API: 

O objetivo é realizar transações simplificadas atendendo os requisitos abaixo.

### Requisitos:

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.
- Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.
- Lojistas **só recebem** transferências, não enviam dinheiro para ninguém.
- Validar se o usuário tem saldo antes da transferência.
- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).
- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.
- No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).
- Este serviço deve ser RESTFul.

### Dependências:

- [Composer](https://getcomposer.org/download/)

- PHP >= 7.3

### Instalação e Configuração

- Clone com o comando `git clone https://github.com/camilaPereir/API-with-Lumen.git`  ou faça o download deste repositório
- Execute `cp .env.example .env` no Mac/Unix ou `COPY .env.example .env` no Windows
- Configure sua conexão com o SGBD de sua preferência no arquivo .env
- Execute `composer install` para instalar todas as dependências
- Execute `php artisan migration` para criar as tabelas
- Execute `php -S localhost:8000 -t public` para rodar o projeto
- Se tudo funcionou corretamente, você pode navegar para `http://localhost:8000/types` 🚀

### Modelagem do problema:
![image](https://user-images.githubusercontent.com/56832086/123687591-7bf65f00-d827-11eb-9cb7-33fdb30304f4.png)


### Rotas para tipo de usuário:

Em tipos de usuário é possível cadastrar, listar todos, alterar e deletar os tipos. 

#### Rotas:

- GET/POST: http://localhost:8000/types
- PUT/DELETE: http://localhost:8000/types/{id}

Exemplo de cadastro de um tipo de usuário:

```php
{
    "description" : "Lojista"
}
```

### Rotas para usuário:

Em usuário é possível cadastrar, listar todos, listar somente um, alterar e deletar o usuário. 

#### Rotas:

- GET/POST: http://localhost:8000/users
- GET/PUT/DELETE: http://localhost:8000/users/{id}

Exemplo de cadastro de um tipo de usuário:

```php
{
    "name" : "Teste da Silva",
    "cpf_cnpj" : "9876543210",
    "email" : "teste.silva@gmail.com",
    "password" : "123456789",
    "type_id" : 1
}
```


### Rotas para transação:

Em transação é possível cadastrar, listar todos e listar somente uma transação. 

#### Rotas:

- GET/POST: http://localhost:8000/transactions
- GET: http://localhost:8000/transactions/{id}

Exemplo de cadastro de um tipo de usuário:

```php
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```
