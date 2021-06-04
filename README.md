# appmax

Crud Gestao Estoque

### versões

-   Laravel Framework 8.44.0
-   PHP 7.4.9
-   Mysql 8.0.25 (Docker-HUB mysql-latest)

### informações para uso

Usuario: default@test.com Senha: password

## Instalação

#### Clone este repositório

\$ git clone "URL" "nome da pasta"

#### Acesse a pasta do projeto no terminal/cmd

\$ cd "nome da pasta"

#### Instale as dependencias

\$ componser install

#### crie o arquivo de ambiente

\$ cp .env.example .env

#### gere a chave do larave

\$ php artisan key:generate

#### configuração da base de dados

Tendo o base de dados configurada, abra o arquivo .env e configure as variaveis para acesso a base de dados

#### inicialização da base de dados

Para iniciar a base de dados com os dados de teste, execute o seguinte comando
\$ php artisan migrate:refresh --seed

#### inicie o servidor local laravel

\$ php artisan serve

#### acessando o sistema

-   Acesse o sistema pelo link http://localhost:8000 (o número da porta pode alterar se a mesma já estiver sendo utilizada)
-   O sistema inicializa na tela de login e depois de autenticado, a tela de relatório é a primeira a ser exibida
-   o restante das telas seguem um processo auto explicativo

### Testes unitários

Para rodar os testes unitários desenvolvidos, tendo o servidor iniciado, rode em um terminal o comando
\$ php artisan test
São 5 testes executados e a documentação, está descrina no código dos teste

### Rodar frontend VueJS em modo desenvolvimento

Para isto é necessário possuir o NodeJS (npm) instalado, e então na raiz do projeto instalar as dependencias com o comando npm install e depois, rodar o seguinte comando:

-   compilação unica
    -   \$ npm run dev
-   compilação em tempo de desenvolvimento
    -   \$ npm run watch
-   compilação em produção
    -   \$ npm run prod
