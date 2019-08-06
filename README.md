# writeit-reborn

Dentro de seu *php.ini* tire o ; da linha *extension=pdo_mysql* e reinicie sua maquina

Voce precisara de um banco local, no windowns instalar o xampp com mysql e apache.

De start do apache depois o mysql. 

Click em admin do mysql e crie um banco chamado *write_teste*

Para instalar executar *php composer install* na pasta do projeto.

Execute o *bin/console doctrine:schema:update --force* comando para criar as tabelas no banco.

Dentro da pasta public do projeto executar *php -S localhost:8080* em um terminal separa.

No navegador entrar em localhost:8080 e ver se a messagem se encontra.
