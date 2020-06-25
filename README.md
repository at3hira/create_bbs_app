# laravel_ap

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
    $ docker-compose exec php laravel new # laravelプロジェクト作成      

## 注意点
Bootstrapインストール
		laravel6以降、bootstrapがデフォルトで含まれなくなったためlaravel/uiを使用しインストールする。
		まずはcomposerを使ってlaravel/uiをインストールするが現時点でlaravel/uiのバージョンが2.x。
		laravel/ui:2.xにはLaravel7.x以上が必要となりエラーでインストールに失敗するため、旧バージョンをインストール。

		$ composer require laravel/ui:v1.2.0
		https://laracasts.com/discuss/channels/laravel/composer-require-laravelui-error?page=1#reply=586951

		bootstrapとVue.jsをインストール。vueを指定するとbootstrapも組み込まれる
		$ php artisan ui vue

		パッケージのインストール＆ビルド
		$ npm install
		$npm run dev
