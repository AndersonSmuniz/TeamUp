# TeamUp
Projeto Laravel - Guia de Instalação
Este é um guia passo a passo para ajudar você a instalar e configurar o ambiente para um projeto Laravel. Certifique-se de seguir cada passo cuidadosamente para garantir uma instalação bem-sucedida.

# Pré-requisitos
Antes de começar, certifique-se de que seu sistema atenda aos seguintes requisitos:

PHP >= 8
Composer (https://getcomposer.org/)
Banco de dados PostgreSQL
Node.js e NPM (https://nodejs.org/)
Git

# Configure o arquivo .env
Abra o arquivo .env em um editor de texto e configure as variáveis de ambiente, como o banco de dados, URL do aplicativo, etc.

# Gere a chave de aplicativo
php artisan key:generate

# Execute as migrações do banco de dados
php artisan migrate

# Rode as seeds para popular o banco de dados
php artisan db:seed

# Instale as dependências do Node.js e compile os ativos
npm install
npm run dev

# Inicie o servidor embutido
php artisan serve
