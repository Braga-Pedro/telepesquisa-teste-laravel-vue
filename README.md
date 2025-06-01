<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Como rodar o projeto com Docker

Siga os passos abaixo para subir o ambiente completo:

1. **Derrube e suba os containers (com build):**
   ```sh
   docker-compose down -v
   docker-compose up --build -d
   ```

2. **Dê permissão nas pastas necessárias:**
   ```sh
   docker-compose exec app chmod -R 777 storage bootstrap/cache public
   ```

3. **Execute as migrations do banco de dados:**
   ```sh
   docker-compose exec app php artisan migrate
   ```

4. **Gere os assets do frontend para produção:**
   ```sh
   docker-compose exec app npm run build
   ```

5. **Acesse o sistema:**
   - Backend: [http://localhost:8080](http://localhost:8080)


Pronto! O ambiente estará disponível para uso.

## Cadastro de Empresas

O sistema de cadastro de empresas faz parte de uma avaliação para cargo de desenvolvedor PHP | Laravel da empresa Telepesquisa. É desenvolvido com `Inertia` utilizando `Breeze` e `PHP 8.2` | `Laravel 12` | `Vue 3.4`.

## Requisitos

[Docx - Requisitos do Sistema de Cadastro de Empresas](https://docs.google.com/document/d/1iIXaX1HaxUNxrEwDiDhiaw1SZK_MEw4ejbETtvlapa8/edit?usp=sharing)

## License

O Cadastro de Empresas contém a lincensa [MIT license](https://opensource.org/licenses/MIT).
