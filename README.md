<p align="center"><img src="https://impa.br/wp-content/uploads/2018/06/pesquisas-eleitorais-1200x637.png" width="400"></p>

<p align="center">
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

## Campaign RVSYSTEM - Laravel 6

Projeto de pesquisa eleitoral.

<p align="center">
<img src="images/print-examples/panel.png"  width="500" />
<img src="images/print-examples/campanha.png"  width="500" />
<img src="images/print-examples/questao.png"  width="500" />
<img src="images/print-examples/opcao.png"  width="500" />
<img src="images/print-examples/resposta.png"  width="500" />
</p>

## Instalação (comandos)

git clone https://github.com/lucianopalhares/campaign_rvsystem.git 

composer install

verifique se existe o arquivo .env se nao existir faça uma copia de .env.example com o nome .env 

php artisan key:generate

crie um banco de dados com o nome que desejar

preencha o arquivo .env com os dados do banco de dados na linha:

DB_CONNECTION=mysql<br />
DB_HOST=127.0.0.1<br />
DB_PORT=3306<br />
DB_DATABASE=nomedobancodedados<br />
DB_USERNAME=usuariodobancodedados<br />
DB_PASSWORD=senhadobancodedados

php artisan migrate (ira criar as tabelas no banco de dados)

php artisan db:seed (ira cadastrar o usuario admin, os estados e as cidades)

dados de acesso:
admin@admin.com
12345678

## License

[MIT license](https://opensource.org/licenses/MIT).
