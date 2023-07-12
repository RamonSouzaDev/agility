<h1 align="center">Olá 👋, Eu sou Ramon Mendes</h1>
<h3 align="center">Um desenvolvedor back-end apaixonado por tecnologia</h3>

- 🔭 Atualmente estou trabalhando em [Desenvolvimento de projeto Back-end](https://github.com/RamonSouzaDev/agility)

- 🌱 Atualmente estou aprendendo **Laravel e MYSQL**

- 📫 Como chegar até mim **dwmom@hotmail.com**

<h3 align="left">Vamos fazer networking:</h3>
<p align="left">
<a href="https://linkedin.com/in/https://www.linkedin.com/in/ramon-mendes-b44456164/" target="blank"><img align="center" src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/linked-in-alt.svg" alt="https://www.linkedin.com/in/ramon-mendes-b44456164/" height="30" width="40" /></a>
</p>

<h3 align="left">Linguagens e ferramentas:</h3>
<p align="left"> <a href="https://www.docker.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/docker/docker-original-wordmark.svg" alt="docker" width="40" height="40"/> </a> <a href="https://hadoop.apache.org/" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/apache_hadoop/apache_hadoop-icon.svg" alt="hadoop" width="40" height="40"/> </a> <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="40" height="40"/> </a> <a href="https://laravel.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="laravel" width="40" height="40"/> </a> <a href="https://www.linux.org/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/linux/linux-original.svg" alt="linux" width="40" height="40"/> </a> <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> </p>


- **Instalando Projeto**

1. Clone o repositório :
git clone git@github.com:RamonSouzaDev/agility.git

2. Entre na pasta do projeto
cd "nome do projeto"

3. Faça uma cópia do env.
cp .env.example .env

4. Instale as dependências
composer install

5. Gerando a chave
php artisan key:generate

6. Execute a migrate para gerar as tabelas do banco de dados
php artisan migrate

7. Execute o projeto
php artisan serve

- **Rotas**

## Métodos
Requisições para a API devem seguir os padrões:
| Método | Rota | Descrição |
|---|---|---|
| `POST` | /api/register | Rota para registrar um usuário |
```json
{
  "name": "Nome do usuário",
  "email": "emaildousuario@hotmail.com",
  "password": "developer"
}
```
|  |  |  |
|---|---|---|
| `POST` | /login | Rota para fazer login |
```json
{
  "email": "dwmom@hotmail.com",
  "password": "developer"
}
```
|  |  |  |
|---|---|---|
| `POST` | /logout | Rota para fazer logout |
```json

```
|  |  |  |
|---|---|---|
| `POST` | /stores | Rota para cadastrar uma Loja |
```json
{
    "name" : "Primeira Loja",
    "cep" : "07023-022"
}
```
| `GET` | /stores | Rota para listar todas as rotas |
| `GET` | /stores/stores | Rota para listar as Lojas do usuário logado |
| `PUT` | '/stores/{store} | Rota para Editar uma Loja|
| `DELETE` | '/stores/{store} | Rota para deletar uma Loja |