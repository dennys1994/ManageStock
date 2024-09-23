# Sistema de Gestão de Produtos e Vendas

Este projeto é composto por uma API desenvolvida em Laravel para gerenciar autenticação de usuários, produtos e vendas, e um frontend em React.js. Atualmente, o projeto está em construção, mas já possui funcionalidades principais operacionais, como registro, login, criação e listagem de produtos, além de registro e listagem de vendas.

## Tecnologias Utilizadas

- **Backend (API)**: Laravel 11
- **Frontend**: React.js
- **Banco de Dados**: MySQL

## Funcionalidades Implementadas

### API (Laravel)

A API oferece as seguintes funcionalidades:

- **Registro de usuário**: Permite criar novos usuários com autenticação por senha.
- **Login de usuário**: Realiza a autenticação de usuários e gera uma chave de API.
- **CRUD de produtos**: Criação, listagem, atualização e exclusão de produtos.
- **Registro de vendas**: Permite registrar uma nova venda.
- **Listagem de vendas**: Exibe todas as vendas registradas no sistema.

### Frontend (React.js)

O frontend, desenvolvido em React.js, consome a API e oferece uma interface intuitiva para os usuários interagirem com o sistema. As telas atuais incluem:

- **Tela de Registro**: Formulário para criar novos usuários.
- **Tela de Login**: Autenticação de usuários existentes.
- **Gestão de Produtos**: Listagem e cadastro de novos produtos.
- **Gestão de Vendas**: Registro e visualização de vendas realizadas.

## Instalação e Execução

### Requisitos

- PHP 8.x
- Composer
- Node.js
- MySQL

### Backend (Laravel)

1. Clone o repositório:

    ```bash
    git clone https://github.com/dennys1994/ManageStock.git
    ```

2. Navegue até a pasta do projeto backend:

    ```bash
    cd ManageStock/backend/laravel
    ```

3. Instale as dependências do Laravel:

    ```bash
    composer install
    ```

4. Configure o arquivo `.env` com suas credenciais do banco de dados e outras configurações.

5. Execute as migrações para criar as tabelas:

    ```bash
    php artisan migrate
    ```

6. Inicie o servidor de desenvolvimento:

    ```bash
    php artisan serve
    ```

### Frontend (React.js)

1. Navegue até a pasta do projeto frontend:

    ```bash
    cd ManageStock/frontend
    ```

2. Instale as dependências do React:

    ```bash
    npm install
    ```

3. Inicie o servidor de desenvolvimento:

    ```bash
    npm start
    ```

O projeto estará disponível em `http://localhost:3000` para o frontend e `http://localhost:8000` para a API.

## Funcionalidades Futuras

- Melhorar a interface do usuário no frontend.
- Implementar relatórios de vendas e produtos.
- Adicionar funcionalidade de atualização e remoção de produtos e vendas no frontend.

## Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir uma issue ou enviar um pull request.

---

Essa documentação apresenta o projeto, as tecnologias usadas, funcionalidades disponíveis e as instruções para rodar a aplicação.