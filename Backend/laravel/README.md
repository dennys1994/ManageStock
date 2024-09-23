Aqui está a lista completa das funcionalidades que a **API de Controle de Estoque** terá:

21/09

criar usuario
criar produto via api key okay



### 1. **Autenticação e Gerenciamento de Usuários**
   - **Registro de Usuário**: Permite que novos usuários se registrem e obtenham uma chave de API para acessar seus estoques.
     - **Endpoint**: `POST /register`
   - **Login de Usuário**: Autentica o usuário e retorna a chave de API para futuras solicitações.
     - **Endpoint**: `POST /login`
   - **Autenticação com API Key**: Todas as operações devem ser feitas através da chave de API gerada no login ou registro. 

### 2. **Gerenciamento de Produtos**
   - **Criação de Produto**: Permite que o usuário adicione novos produtos ao seu estoque.
     - **Endpoint**: `POST /products`
   - **Listagem de Produtos**: Lista todos os produtos registrados pelo usuário autenticado.
     - **Endpoint**: `GET /products`
   - **Atualização de Produto**: Atualiza os detalhes de um produto, como nome, descrição, preço e quantidade em estoque.
     - **Endpoint**: `PUT /products/{id}`
   - **Exclusão de Produto**: Remove um produto do estoque.
     - **Endpoint**: `DELETE /products/{id}`

### 3. **Controle de Estoque**
   - **Atualização de Quantidade no Estoque**: Permite que o usuário altere manualmente a quantidade de um produto em estoque.
     - **Endpoint**: `PUT /products/{id}/update-stock`
   - **Registro de Venda**: Registra a venda de um produto, atualizando automaticamente a quantidade em estoque.
     - **Endpoint**: `POST /products/{id}/sell`
  
### 4. **Relatórios de Estoque**
   - **Verificação do Estoque Atual**: Lista todos os produtos com suas respectivas quantidades em estoque.
     - **Endpoint**: `GET /inventory`
   - **Produtos com Baixo Estoque**: Lista produtos cujo estoque está abaixo de uma quantidade mínima predefinida (exemplo: < 10 unidades).
     - **Endpoint**: `GET /inventory/low-stock`
   
### 5. **Relatórios de Vendas**
   - **Histórico de Vendas**: Exibe o histórico de vendas de um produto específico ou de todos os produtos do usuário.
     - **Endpoint**: `GET /sales`
   - **Relatório de Vendas por Período**: Filtra o histórico de vendas por um intervalo de datas.
     - **Endpoint**: `GET /sales?start_date={YYYY-MM-DD}&end_date={YYYY-MM-DD}`

### 6. **Gestão de Chave de API**
   - **Renovação de API Key**: Permite que o usuário renove sua chave de API se necessário.
     - **Endpoint**: `POST /users/renew-api-key`
  
### Funcionalidades Extras (Futuras Expansões):
   - **Exportação de Dados**: Permite exportar relatórios de vendas e estoque para formatos como CSV ou Excel.
     - **Endpoint**: `GET /export/inventory` e `GET /export/sales`
   - **Notificações de Baixo Estoque**: Notifica o usuário quando um produto atingir o limite mínimo de estoque via e-mail ou SMS.

---

 requisição:**
```json
{
  "name": "string|required",
  "email": "string|required|email|unique",
  "password": "string|required|min:8"
}
```## **AuthController**

Este controlador é responsável pela autenticação de usuários, incluindo o registro de novos usuários e a autenticação via login.

### **Registrar um novo usuário**

- **Rota:** `/register`
- **Método:** `POST`
- **Autenticação:** Não requer autenticação

#### **Parâmetros da

#### **Exemplo de requisição:**

```bash
POST /register HTTP/1.1
Host: example.com
Content-Type: application/json

{
  "name": "Usuário Exemplo",
  "email": "usuario@exemplo.com",
  "password": "senha_segura"
}
```

#### **Exemplo de resposta:**

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

#### **Códigos de status:**
- **201 Created** – Usuário registrado com sucesso.
- **422 Unprocessable Entity** – Erro de validação (e.g. email já registrado, senha muito curta).
- **500 Internal Server Error** – Erro inesperado ao registrar o usuário.

---

### **Login de um usuário**

- **Rota:** `/login`
- **Método:** `POST`
- **Autenticação:** Não requer autenticação

#### **Parâmetros da requisição:**
```json
{
  "email": "string|required|email",
  "password": "string|required"
}
```

#### **Exemplo de requisição:**

```bash
POST /login HTTP/1.1
Host: example.com
Content-Type: application/json

{
  "email": "usuario@exemplo.com",
  "password": "senha_segura"
}
```

#### **Exemplo de resposta:**

```json
{
  "api_key": "f9ae3093e24b25e82ef0d92dc3f4593924b79fd0"
}
```

#### **Códigos de status:**
- **200 OK** – Login realizado com sucesso, retorna a `api_key` do usuário.
- **401 Unauthorized** – Credenciais inválidas (email ou senha incorretos).

---

## **Autenticação**

Para acessar as rotas protegidas, o usuário deve estar autenticado e fornecer uma chave de API válida no cabeçalho da solicitação.

**Cabeçalhos obrigatórios:**
- `Authorization: Bearer {API_KEY}`

---

## **ProductController**

Este controlador gerencia as operações de produtos para usuários autenticados. Abaixo estão as rotas disponíveis, com seus respectivos métodos HTTP, parâmetros, exemplos de requisição e resposta.

---

### **Criar um novo produto**

- **Rota:** `/products`
- **Método:** `POST`
- **Autenticação:** Requer chave de API válida

#### **Parâmetros da requisição:**
```json
{
  "name": "string|required",
  "description": "string|nullable",
  "price": "numeric|required",
  "quantity": "integer|required"
}
```

#### **Exemplo de requisição:**

```bash
POST /products HTTP/1.1
Host: example.com
Authorization: Bearer {API_KEY}
Content-Type: application/json

{
  "name": "Produto Exemplo",
  "description": "Descrição do produto",
  "price": 19.99,
  "quantity": 10
}
```

#### **Exemplo de resposta:**
```json
{
  "id": 1,
  "name": "Produto Exemplo",
  "description": "Descrição do produto",
  "price": 19.99,
  "quantity": 10,
  "user_id": 1,
  "created_at": "2024-09-22T12:34:56.000000Z",
  "updated_at": "2024-09-22T12:34:56.000000Z"
}
```

#### **Códigos de status:**
- **201 Created** – Produto criado com sucesso.
- **401 Unauthorized** – Falha de autenticação.
- **422 Unprocessable Entity** – Erro de validação dos dados.

---

### **Listar produtos do usuário autenticado**

- **Rota:** `/products`
- **Método:** `GET`
- **Autenticação:** Requer chave de API válida

#### **Exemplo de requisição:**

```bash
GET /products HTTP/1.1
Host: example.com
Authorization: Bearer {API_KEY}
```

#### **Exemplo de resposta:**
```json
[
  {
    "id": 1,
    "name": "Produto Exemplo",
    "description": "Descrição do produto",
    "price": 19.99,
    "quantity": 10,
    "user_id": 1,
    "created_at": "2024-09-22T12:34:56.000000Z",
    "updated_at": "2024-09-22T12:34:56.000000Z"
  },
  {
    "id": 2,
    "name": "Outro Produto",
    "description": "Mais uma descrição",
    "price": 29.99,
    "quantity": 5,
    "user_id": 1,
    "created_at": "2024-09-22T12:35:56.000000Z",
    "updated_at": "2024-09-22T12:35:56.000000Z"
  }
]
```

#### **Códigos de status:**
- **200 OK** – Produtos retornados com sucesso.
- **401 Unauthorized** – Falha de autenticação.

---

### **Atualizar um produto existente**

- **Rota:** `/products/{id}`
- **Método:** `PUT`
- **Autenticação:** Requer chave de API válida

#### **Parâmetros da requisição:**
```json
{
  "name": "string|required",
  "description": "string|nullable",
  "price": "numeric|required",
  "quantity": "integer|required"
}
```

#### **Exemplo de requisição:**

```bash
PUT /products/1 HTTP/1.1
Host: example.com
Authorization: Bearer {API_KEY}
Content-Type: application/json

{
  "name": "Produto Atualizado",
  "description": "Nova descrição",
  "price": 24.99,
  "quantity": 15
}
```

#### **Exemplo de resposta:**
```json
{
  "id": 1,
  "name": "Produto Atualizado",
  "description": "Nova descrição",
  "price": 24.99,
  "quantity": 15,
  "user_id": 1,
  "created_at": "2024-09-22T12:34:56.000000Z",
  "updated_at": "2024-09-22T13:45:00.000000Z"
}
```

#### **Códigos de status:**
- **200 OK** – Produto atualizado com sucesso.
- **403 Forbidden** – O produto não pertence ao usuário autenticado.
- **404 Not Found** – Produto não encontrado.
- **401 Unauthorized** – Falha de autenticação.

---

### **Excluir um produto**

- **Rota:** `/products/{id}`
- **Método:** `DELETE`
- **Autenticação:** Requer chave de API válida

#### **Exemplo de requisição:**

```bash
DELETE /products/1 HTTP/1.1
Host: example.com
Authorization: Bearer {API_KEY}
```

#### **Exemplo de resposta:**
```json
{
  "message": "Produto excluído com sucesso."
}
```

#### **Códigos de status:**
- **204 No Content** – Produto excluído com sucesso.
- **403 Forbidden** – O produto não pertence ao usuário autenticado.
- **404 Not Found** – Produto não encontrado.
- **401 Unauthorized** – Falha de autenticação.

---

## **SalesController**

Este controlador é responsável por registrar e listar vendas, além de permitir filtrar o histórico de vendas por períodos específicos.

### **Registrar uma venda**

- **Rota:** `/products/{id}/sell`
- **Método:** `POST`
- **Autenticação:** Requer autenticação via chave de API

#### **Parâmetros da requisição:**
```json
{
  "quantity": "integer|required|min:1"
}
```

#### **Exemplo de requisição:**

```bash
POST /products/1/sell HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
Content-Type: application/json

{
  "quantity": 3
}
```

#### **Exemplo de resposta:**

```json
{
  "id": 1,
  "user_id": 1,
  "product_id": 1,
  "quantity": 3,
  "created_at": "2024-09-20T14:48:29.000000Z",
  "updated_at": "2024-09-20T14:48:29.000000Z"
}
```

#### **Códigos de status:**
- **201 Created** – Venda registrada com sucesso.
- **400 Bad Request** – Estoque insuficiente para a quantidade solicitada.
- **403 Forbidden** – O produto não pertence ao usuário autenticado.
- **404 Not Found** – Produto não encontrado.

---

### **Listar todas as vendas**

- **Rota:** `/sales`
- **Método:** `GET`
- **Autenticação:** Requer autenticação via chave de API

#### **Exemplo de requisição:**

```bash
GET /sales HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
```

#### **Exemplo de resposta:**

```json
[
  {
    "id": 1,
    "user_id": 1,
    "product_id": 1,
    "quantity": 3,
    "product": {
      "id": 1,
      "name": "Produto Exemplo"
    },
    "created_at": "2024-09-20T14:48:29.000000Z"
  },
  {
    "id": 2,
    "user_id": 1,
    "product_id": 2,
    "quantity": 5,
    "product": {
      "id": 2,
      "name": "Outro Produto"
    },
    "created_at": "2024-09-21T15:15:15.000000Z"
  }
]
```

#### **Códigos de status:**
- **200 OK** – Lista de vendas retornada com sucesso.

---

### **Filtrar vendas por intervalo de datas**

- **Rota:** `/sales/period`
- **Método:** `GET`
- **Autenticação:** Requer autenticação via chave de API

#### **Parâmetros de query:**
- `start_date`: Data de início (formato: `YYYY-MM-DD`)
- `end_date`: Data de término (formato: `YYYY-MM-DD`)

#### **Exemplo de requisição:**

```bash
GET /sales/period?start_date=2024-09-01&end_date=2024-09-30 HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
```

#### **Exemplo de resposta:**

```json
[
  {
    "id": 1,
    "user_id": 1,
    "product_id": 1,
    "quantity": 3,
    "product": {
      "id": 1,
      "name": "Produto Exemplo"
    },
    "created_at": "2024-09-20T14:48:29.000000Z"
  }
]
```

#### **Códigos de status:**
- **200 OK** – Lista de vendas filtradas retornada com sucesso.
- **400 Bad Request** – Parâmetros de data inválidos.

---

## **InventoryController**

Este controlador é utilizado para gerenciar a exibição do inventário de produtos, mostrando todos os produtos e aqueles com baixo estoque.

### **Listar todos os produtos com quantidade em estoque**

- **Rota:** `/inventory`
- **Método:** `GET`
- **Autenticação:** Não é especificado, mas pode ser necessário adicionar autenticação, dependendo das permissões.

#### **Exemplo de requisição:**

```bash
GET /inventory HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}  // Se a autenticação for necessária
```

#### **Exemplo de resposta:**

```json
[
  {
    "id": 1,
    "name": "Produto Exemplo",
    "quantity": 50
  },
  {
    "id": 2,
    "name": "Outro Produto",
    "quantity": 15
  }
]
```

#### **Códigos de status:**
- **200 OK** – Lista de produtos retornada com sucesso.

---

### **Listar produtos com baixo estoque**

- **Rota:** `/inventory/low-stock`
- **Método:** `GET`
- **Autenticação:** Não é especificado, mas pode ser necessário adicionar autenticação, dependendo das permissões.

#### **Descrição:**
Esta rota retorna produtos cujo estoque está abaixo de um limite pré-definido (por exemplo, abaixo de 10 unidades).

#### **Exemplo de requisição:**

```bash
GET /inventory/low-stock HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}  // Se a autenticação for necessária
```

#### **Exemplo de resposta:**

```json
[
  {
    "id": 3,
    "name": "Produto Quase Esgotado",
    "quantity": 5
  },
  {
    "id": 4,
    "name": "Outro Produto Quase Esgotado",
    "quantity": 3
  }
]
```

#### **Códigos de status:**
- **200 OK** – Produtos com baixo estoque retornados com sucesso.

---

### **Personalização e Limites de Estoque**
- O limite para "baixo estoque" pode ser facilmente ajustado alterando o valor da variável `$lowStockThreshold` dentro do método `lowStock()`.

---

## **ExportController**

Este controlador é responsável por gerar e exportar arquivos Excel contendo os dados de inventário e vendas.

### **Exportar Inventário**

- **Rota:** `/export/inventory`
- **Método:** `GET`
- **Autenticação:** Necessária (via middleware de API key)

#### **Descrição:**
Esta rota gera um arquivo Excel com o inventário de produtos, incluindo nome e quantidade em estoque.

#### **Exemplo de requisição:**

```bash
GET /export/inventory HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
```

#### **Exemplo de resposta:**

- Um arquivo `inventory.xlsx` contendo os dados de inventário é enviado como resposta.

#### **Códigos de status:**
- **200 OK** – O arquivo Excel foi gerado e está pronto para download.
- **401 Unauthorized** – Chave de API inválida ou ausente.

---

### **Exportar Vendas**

- **Rota:** `/export/sales`
- **Método:** `GET`
- **Autenticação:** Necessária (via middleware de API key)

#### **Descrição:**
Esta rota gera um arquivo Excel com o histórico de vendas, incluindo informações do produto, quantidade vendida e data.

#### **Exemplo de requisição:**

```bash
GET /export/sales HTTP/1.1
Host: example.com
Authorization: Bearer {api_key}
```

#### **Exemplo de resposta:**

- Um arquivo `sales.xlsx` contendo os dados de vendas é enviado como resposta.

#### **Códigos de status:**
- **200 OK** – O arquivo Excel foi gerado e está pronto para download.
- **401 Unauthorized** – Chave de API inválida ou ausente.

---

### **Dependências**
Este controlador depende do pacote `maatwebsite/excel` para gerar os arquivos Excel. Certifique-se de que a biblioteca está instalada no projeto:

```bash
composer require maatwebsite/excel
```

### **Classes de Exportação**

As classes `InventoryExport` e `SalesExport` são responsáveis por definir os dados que serão incluídos nos arquivos Excel:

- **InventoryExport:** Exporta dados da tabela `Product`.
- **SalesExport:** Exporta dados da tabela `Sale`.

---

## **UserController**

### **Método: `renewApiKey`**

Este método é responsável por renovar a chave de API (API Key) de um usuário autenticado, gerando uma nova chave e salvando-a no banco de dados.

---

### **Rota:** `/api/user/renew-api-key`

- **Método HTTP:** `POST`
- **Autenticação:** Requerida (via token de autenticação)

#### **Descrição:**
Quando um usuário autenticado faz uma solicitação para essa rota, uma nova chave de API é gerada e associada ao usuário. A nova chave de API é então retornada na resposta.

#### **Exemplo de requisição:**

```bash
POST /api/user/renew-api-key HTTP/1.1
Host: example.com
Authorization: Bearer {token_de_autenticacao}
```

#### **Exemplo de resposta:**

```json
{
    "api_key": "new_generated_api_key"
}
```

#### **Códigos de status:**

- **200 OK** – Nova chave de API gerada e retornada com sucesso.
- **401 Unauthorized** – O usuário não está autenticado ou o token de autenticação é inválido.

---

### **Fluxo de execução do método:**

1. **Verificação de Autenticação:**
   O método primeiro verifica se o usuário está autenticado ao verificar a presença de um usuário no objeto `$request->user`.

2. **Gerar Nova Chave de API:**
   Se o usuário estiver autenticado, o método utiliza `Str::random(60)` para gerar uma nova chave de API com 60 caracteres.

3. **Salvar Nova Chave:**
   A nova chave de API é atribuída ao campo `api_key` do usuário e salva no banco de dados.

4. **Resposta:**
   O método retorna a nova chave de API no corpo da resposta com um status HTTP 200 (OK).

---

### **Considerações adicionais:**
- Para garantir a autenticação, certifique-se de que as rotas que chamam este método estão protegidas com middleware de autenticação, como `auth:api`.

Aqui está uma análise e explicação sobre o funcionamento do `NotificationController`, mais especificamente do método `checkLowStock`, que monitora o estoque baixo e envia notificações por e-mail.

---

## **NotificationController**

### **Método: `checkLowStock`**

O método `checkLowStock` é responsável por verificar os produtos que estão com o estoque abaixo de um determinado limite e enviar notificações por e-mail para o administrador ou responsável.

---

### **Rota:** `/api/notifications/low-stock`

- **Método HTTP:** `GET`
- **Autenticação:** Depende do contexto, mas pode ser restrito a usuários administradores.

#### **Descrição:**
Este método busca todos os produtos com o estoque abaixo de um valor limite (neste caso, 10 unidades) e envia uma notificação por e-mail para um endereço especificado (ex: `user@example.com`).

#### **Exemplo de resposta:**

```json
{
    "message": "Low stock notifications sent."
}
```

#### **Códigos de status:**

- **200 OK** – As notificações de estoque baixo foram enviadas com sucesso.
- **500 Internal Server Error** – Algum erro ocorreu ao tentar enviar os e-mails.

---

### **Fluxo de execução do método:**

1. **Consulta de Produtos com Estoque Baixo:**
   O método utiliza o modelo `Product` para buscar todos os produtos cuja quantidade (`quantity`) é menor que 10:
   
   ```php
   $lowStockProducts = Product::where('quantity', '<', 10)->get();
   ```

2. **Envio de Notificações:**
   Para cada produto com estoque baixo, um e-mail é enviado para o endereço configurado (`user@example.com` no exemplo) usando a classe `LowStockNotification`. O e-mail contém detalhes sobre o produto que está com baixo estoque:

   ```php
   Mail::to('user@example.com')->send(new LowStockNotification($product));
   ```

3. **Resposta:**
   Após enviar as notificações, o método retorna uma mensagem de sucesso:

   ```php
   return response()->json(['message' => 'Low stock notifications sent.'], 200);
   ```

---

### **Considerações adicionais:**

1. **Classe `LowStockNotification`:**
   O método está utilizando uma notificação chamada `LowStockNotification`, que é presumivelmente uma classe de e-mail que deve ser criada e configurada para enviar detalhes do produto. Essa classe deve ser implementada, caso ainda não exista:

   - Crie a notificação usando o comando Artisan:
     ```bash
     php artisan make:mail LowStockNotification
     ```

   - Dentro da classe `LowStockNotification`, você pode definir o conteúdo do e-mail, que poderia incluir o nome do produto, a quantidade em estoque e um link para repor o estoque.

2. **Configuração do Servidor de E-mail:**
   Certifique-se de que o Laravel está configurado corretamente para envio de e-mails. Verifique as configurações no arquivo `.env`, como:
   
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS=from@example.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

3. **Melhorias Futuras:**
   - O limite de estoque baixo poderia ser configurável para permitir maior flexibilidade.
   - Poderia ser implementado um sistema para enviar essas notificações de forma agendada, usando tarefas cron (scheduler do Laravel).

---

Esse método pode ser útil para monitorar automaticamente o estoque e notificar responsáveis para evitar rupturas de estoque, garantindo um gerenciamento eficiente dos produtos.