
# Documentação da API - Laravel

Esta API foi desenvolvida em Laravel e é responsável por gerenciar autenticação de usuários, produtos e vendas. As operações principais incluem registro e login de usuários, CRUD de produtos e o controle de vendas, com autenticação via chave de API para operações protegidas.


## AuthController

O AuthController é responsável pelo registro de novos usuários e autenticação via login.```markdown
# Documentação da API - Laravel

Esta API foi desenvolvida em Laravel e é responsável por gerenciar autenticação de usuários, produtos e vendas. As operações principais incluem registro e login de usuários, CRUD de produtos e o controle de vendas, com autenticação via chave de API para operações protegidas.

## AuthController

O `AuthController` é responsável pelo registro de novos usuários e autenticação via login.

### Registrar um novo usuário
#### Método: POST
```http
POST /api/register
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name`      | `string`   | **Obrigatório**. Nome do usuário.   |
| `email`     | `string`   | **Obrigatório**. Único, formato válido. |
| `password`  | `string`   | **Obrigatório**. Mínimo de 8 caracteres. |

#### Exemplo de requisição:

```json
POST /api/register HTTP/1.1
Host: example.com
Content-Type: application/json

{
  "name": "Usuário Exemplo",
  "email": "usuario@exemplo.com",
  "password": "senha_segura"
}
```

#### Exemplo de resposta:

```json
{
  "data": {
    "id": 1,
    "name": "Usuário Exemplo",
    "api_key": "f9ae3093e24b25e82ef0d92dc3f4593924b79fd0"
  },
  "status": "success"
}
```

### Códigos de status:
- **201 Created** – Usuário registrado com sucesso.
- **422 Unprocessable Entity** – Erro de validação (e.g., email já registrado, senha muito curta).
- **500 Internal Server Error** – Erro inesperado ao registrar o usuário.

---

### Login de usuário
#### Método: POST
```http
POST /api/login
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email`     | `string`   | **Obrigatório**. Email do usuário.  |
| `password`  | `string`   | **Obrigatório**. Senha do usuário.  |

#### Exemplo de requisição:

```json
POST /api/login HTTP/1.1
Host: example.com
Content-Type: application/json

{
  "email": "usuario@exemplo.com",
  "password": "senha_segura"
}
```

#### Exemplo de resposta:

```json
{
  "api_key": "f9ae3093e24b25e82ef0d92dc3f4593924b79fd0"
}
```

### Códigos de status:
- **200 OK** – Login realizado com sucesso, retorna a `api_key` do usuário.
- **401 Unauthorized** – Credenciais inválidas (email ou senha incorretos).

---

## Produtos

O `ProductController` gerencia as operações CRUD para os produtos.

### Criar produto
#### Método: POST
```http
POST /api/products
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name`      | `string`   | **Obrigatório**. Nome do produto.   |
| `price`     | `float`    | **Obrigatório**. Preço do produto.  |
| `stock`     | `integer`  | **Obrigatório**. Quantidade em estoque. |

#### Exemplo de requisição:

```json
POST /api/products HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
Content-Type: application/json

{
  "name": "Produto Exemplo",
  "price": 49.99,
  "stock": 10
}
```

#### Exemplo de resposta:

```json
{
  "data": {
    "id": 1,
    "name": "Produto Exemplo",
    "price": 49.99,
    "stock": 10,
    "created_at": "2024-09-23T10:00:00Z"
  },
  "status": "success"
}
```

### Códigos de status:
- **201 Created** – Produto criado com sucesso.
- **401 Unauthorized** – Chave de API inválida ou ausente.
- **422 Unprocessable Entity** – Erro de validação dos dados.

---

### Consultar produto
#### Método: GET
```http
GET /api/products/{id}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`        | `integer`  | **Obrigatório**. ID do produto.     |

#### Exemplo de resposta:

```json
{
  "data": {
    "id": 1,
    "name": "Produto Exemplo",
    "price": 49.99,
    "stock": 10,
    "created_at": "2024-09-23T10:00:00Z"
  },
  "status": "success"
}
```

### Códigos de status:
- **200 OK** – Produto encontrado com sucesso.
- **404 Not Found** – Produto não encontrado.

---

## Vendas

O `SaleController` é responsável pelo controle de vendas. Cada venda deve conter informações sobre o cliente, os produtos vendidos e a quantidade.

### Registrar venda
#### Método: POST
```http
POST /api/sales
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `product_id`| `integer`  | **Obrigatório**. ID do produto.     |
| `quantity`  | `integer`  | **Obrigatório**. Quantidade vendida.|
| `customer_name` | `string` | **Obrigatório**. Nome do cliente.  |

#### Exemplo de requisição:

```json
POST /api/sales HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2,
  "customer_name": "Cliente Exemplo"
}
```

#### Exemplo de resposta:

```json
{
  "data": {
    "sale_id": 1,
    "product_id": 1,
    "quantity": 2,
    "customer_name": "Cliente Exemplo",
    "total_price": 99.98,
    "created_at": "2024-09-23T10:00:00Z"
  },
  "status": "success"
}
```

### Códigos de status:
- **201 Created** – Venda registrada com sucesso.
- **401 Unauthorized** – Chave de API inválida ou ausente.
- **422 Unprocessable Entity** – Erro de validação dos dados.
```
