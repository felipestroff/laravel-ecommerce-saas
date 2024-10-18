# laravel-ecommerce-saas

Este projeto é uma plataforma de E-commerce SaaS onde administradores podem gerenciar lojas, e os proprietários das lojas podem gerenciar suas lojas e configurações.

O código terá atualizações constantes até se tornar uma plataforma de ecommerce completa, no estilo Shopee, porém sempre buscando a facilidade de manutenção e novas funcionalidades além do padrão.

## Requisitos

Antes de iniciar o projeto, certifique-se de que você tem os seguintes requisitos instalados:

- **PHP >= 8.0**
- **Composer**
- **MySQL** ou **PostgreSQL** (ou outro banco de dados compatível com Laravel)
- **Node.js & NPM**
- **Laravel >= 9.x**

## Configuração do Projeto

### 1. Clonar o Repositório

Clone o projeto em sua máquina local:

```bash
git clone https://github.com/felipestroff/laravel-ecommerce-saas.git
```

### 2. Instalar Dependências

Após clonar o repositório, navegue até o diretório do projeto e instale as dependências com o Composer:

```bash
cd laravel-ecommerce-saas
composer install
```

### 3. Configurar o Ambiente

Duplique o arquivo .env.example e renomeie para .env:

```bash
cp .env.example .env
```

Abra o arquivo .env e configure as variáveis de ambiente, como:

```ini
APP_NAME="E-commerce SaaS"
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Gerar Chave da Aplicação

Gere a chave da aplicação Laravel:

```bash
php artisan key:generate
```

### 5. Executar as Migrações e Seeders

Agora, crie as tabelas no banco de dados com as migrations e popule o banco de dados com alguns dados iniciais:

```bash
php artisan migrate --seed
```

### 6. Instalar Dependências do NPM

Instale as dependências do frontend:

```bash
npm install
```

### 7. Compilar os Assets

Compile os arquivos de frontend:

```bash
npm run dev
```

Para ambiente de produção:

```bash
npm run build
```

### 8. Iniciar o Servidor de Desenvolvimento

Por fim, inicie o servidor de desenvolvimento do Laravel:

```bash
php artisan serve
```

Agora, a aplicação estará acessível no navegador em http://localhost:8000.


## Gerenciamento de Usuários

### Administrador

Possui acesso completo ao sistema, incluindo o gerenciamento de lojas e usuários.

### Loja (Store)

Usuário responsável por gerenciar uma loja específica.

## Rotinas Básicas

Rodar Migrações:

```bash
php artisan migrate
```

Rodar Seeders:

```bash
php artisan db:seed
```

Limpar o Cache:

```bash
php artisan cache:clear
```

Compilar os Assets de Produção:

```bash
npm run build
```
