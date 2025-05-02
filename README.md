# Desafio TodoApp

Este é um desafio técnico para vaga de estágio como desenvolvedor PHP/Laravel na SES-MT. O objetivo foi criar uma aplicação simples de gestão de tarefas (To-Do List) com funcionalidades básicas de CRUD, autenticação e uma interface responsiva utilizando Bootstrap e Blade.

## 🚀 Tecnologias Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Blade Template Engine + Bootstrap 5
- **Banco de Dados:** MySQL ou SQLite
- **Autenticação:** Laravel Breeze
- **Versionamento:** Git

## ✅ Funcionalidades

- [x] Cadastro de tarefas
- [x] Edição de tarefas
- [x] Exclusão de tarefas
- [x] Marcação de tarefas como concluídas
- [x] Filtro de tarefas por status (pendente/concluída)
- [x] Autenticação de usuários
- [x] Interface responsiva com Bootstrap 5
- [x] 100% de Teste Coverage usando PHP UNIT

## 📦 Instalação e Execução

### 1. Clone o repositório

```bash
git clone https://github.com/RichardGL11/desafio-todoapp.git
cd desafio-todoapp
```
### 2. Instale As Dependências

```bash
composer install
npm install
```
### 3. Gere uma Chave
```bash
cp .env.example .env
php artisan key:generate
```
### 4. Configure seu banco de dados

```bash
# Configure o .env com os dados do seu banco:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=todoapp
# DB_USERNAME=root
# DB_PASSWORD=
```
### 5. Para Rodar o Projeto
```bash
php artisan migrate --seed
npm run dev
php artisan serve
```
### 6. Para rodar os testes com coverage
```bash
npm run build
php artisan test --coverage
```
