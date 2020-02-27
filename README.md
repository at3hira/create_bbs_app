# laravel_app

Dockerでlaravel環境を構築。
docker-composeでLaravelの環境を構築する。

# 構築環境

- OS Debian 10.2
- PHP 7.3.13-fpm
- nginx 1.17.6
- mysql 5.7
- redis 5.0.7

## dockerコマンド  

    $ docker-compose up -d --build # 初回build  
    $ $ docker-compose exec php laravel new # laravelプロジェクト作成      
