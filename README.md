
# はじめに

個人開発を進める際にどうしても無料で高性能なインフラを使いたいと思い、
その時にLaravel10をVercelにデプロイすることを決めました。
今回はその時の導入手順をまとめました！😆


![スクリーンショット 2023-04-22 10.15.10.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/e1daea9f-ad5c-3ebb-a8ae-c9075b0b4ef0.png)



海外文献も含めリサーチし、めちゃくちゃ失敗してきましたし、
成功までにGitHubに１００ push(commit)以上かけなければいけませんでした💦
記事を書いた理由としては他の人が二の轍を踏まないようにしていただければという意図も含んでいます！😊

# URL一覧
URL
https://qiita-laravel10-on-vercel.vercel.app/

完成Gitリポジトリ
https://github.com/Masanarea/qiita_laravel10_on_vercel


# 対象者
* Laravel使用者
* サーバーに無料でデプロイして、サイトを外部公開したいと考えている方
(=>Vercelの場合、SSL対応、容易なCI/CD構築)
* 自身のようにお金をかけずに無料でPHPアプリをデプロイをしたいと考えている方

# 記事を読むメリット
* VercelでのLaravelデプロイ方法を学べる
* 最新のLaravel 10でのVercel デプロイに対応
(自身でトライする場合、イントロダクション通りに実装してもデプロイできなかったり、できたとしてもバージョンが古かったり...おまけに情報量が少ない)

* Vercelに上げることで無料でSSL対応もできるし、GitHubにコードをアップしたら自動でデプロイも行ってくれる

## 事前準備していただきたいこと
Laravelをインストールする手順は省略しますので、
自身でLaravelをインストールする手順の確認をお願いします。

## 使用技術・プラットフォーム
* Vercel
* GitHub

## そもそもVercelとは何なのか?🤔
下記、Chat GPTより引用
>Vercelは、フロントエンドのWeb開発者向けのクラウドプラットフォームです。Webアプリケーションのホスティング、デプロイ、スケーリングを自動化することで、開発者がアプリケーションを簡単かつ迅速に構築、テスト、デプロイできるようになっています。

>SSLの自動設定:
Vercelは、無料でもSSL（Secure Sockets Layer）の自動設定を提供しています。この機能により、ユーザーがHTTPSで安全にアクセスできるようになります。

>CI/CDの自動化:
Vercelは、Gitリポジトリとの統合を提供しており、プルリクエストがマージされるたびに自動的にCI/CD（Continuous Integration/Continuous Deployment）が実行されます。

↑つまり、Gitにプッシュしたら自動でVercelにデプロイ(外部公開)してくれるということです！✨

>無料PaaS:
Vercelは、無料のPaaSとして提供されています。
 

# 導入方法

## 1.Github リポジトリを作成
まずはGithub リポジトリを作成しましょう

![スクリーンショット 2023-04-22 8.37.27.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/f6f4edee-df51-2d7d-a582-c46ecddda71a.png)

![スクリーンショット 2023-04-22 8.38.12.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/16bd353c-96cc-d502-b712-7d2dd5de7da5.png)


## 2.ローカルでLaravelをインストール
※今回はComposerを使用してLaravelをインストールします。

まずはローカル(自身のPC)でフォルダを作成し、以下のコマンドを実行して
Composer が使用できるかどうかを確認します。

```
composer -V 
// Composer version 2.5.4 2023-02-15 13:10:06
```

composer が使用できることを確認できたら、composer でLaravelをインストールします。
```
//例 composer create-project laravel/laravel <プロジェクト名>
composer create-project laravel/laravel vercel-laravel-app
```

作成したLaravel プロジェクトの階層部分に移動します。
```
cd vercel-laravel-app 
```
『ls』コマンドや『php artisan -V』コマンドで、
LaravelがインストールできていたらOKです。
```
ls
//README.md       artisan         composer.json   config          package.json    public          routes          tests           vite.config.js
app             bootstrap       composer.lock   database        phpunit.xml     resources       storage         vendor

php artisan -V
//Laravel Framework 10.4.1
```


## 3. Git 準備
Gitローカルリポジトリを作成し、
先ほど作成した自身のGitリモートリポジトリにpushできるように設定しましょう。
```
git init
```
```
//この下の『https://github.com/Masana....』の部分は適宜変更して下さい
git remote add origin https://github.com/Masanarea/qiita_laravel10_on_vercel.git

git remote -v
//origin  https://github.com/Masanarea/qiita_laravel10_on_vercel.git (fetch)
//origin  https://github.com/Masanarea/qiita_laravel10_on_vercel.git (push)
```

この部分を参照することになると思います。
![スクリーンショット 2023-04-22 8.44.51.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/446dd04e-e052-203a-9fbd-9bcb660f7018.png)

#### 参考リンク

https://www.sejuku.net/blog/71492

## 4.npm インストール

手軽にVercel にLaravelをデプロイするためにパッケージを導入します。


先ほどインストールした Laravel アプリのルートディレクトリで、
下記コマンドを実行します。
```
composer require revolution/laravel-vercel-installer --dev
php artisan vercel:install
```
すると色々ファイルが追加されます。
その中で、今回は『vercel.json』のみを編集します。
『vercel.json』を開いて以下のように変更して下さい。(差分を参考にして下さい)
```
   "version": 2,
    "builds": [
        {
            "src": "api/index.php",
            "use": "vercel-php@0.5.2"
        },
        {
            "src": "public/**",
            "use": "vercel-php@0.5.2"
        }
    ],
    "routes": [
        {
            "src": "/(.*)",
            "dest": "/api/index.php"
        }
    ],

<省略(この下はそのままで問題無いです。)>

```

#### 『vercel.json』の差分(変更点)
![スクリーンショット 2023-04-22 9.24.09.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/8f214152-4a4f-76d0-e978-5c431a154b99.png)


##### 今回使用する npm パッケージ 参考リンク

https://packagist.org/packages/revolution/laravel-vercel-installer

## 5.GitHubに反映

pushして GitHub リモートリポジトリに反映しましょう！
```
git add -A
git commit -m "Vercel にデプロイ"   
git push origin master
```

すると、先ほど自身のGithubで作成したリポジトリがこんな感じになると思います。

![スクリーンショット 2023-03-23 8.24.10.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/3b7947b4-a0c2-32e5-4586-c651d6d455f3.png)

## 6.Vercel 側での設定
あとは Vercel 側での設定のみです。

Vercelアカウントを作成して下さい。
また、GitHubとの連携も行って下さい。
その後『新規プロジェクト』を作成し、今回作成したGitリポジトリを選択します。

![スクリーンショット 2023-04-22 9.32.23.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/5241c8d8-4bca-b676-fc45-2b6e94e96619.png)


![スクリーンショット 2023-04-22 9.33.04.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/4f8cb59c-37dc-779a-3932-f8a87e54336d.png)

ここからプロジェクトの設定をします。
* 『Flamework preset』は 『Other』で選択
* APP_KEY という環境変数を設定
(Laravel の .env ファイルのAPP_KEYをそのまま入れて下さい)
![スクリーンショット 2023-04-22 9.36.16.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/65410eb7-466e-332b-6654-1d2b498af439.png)

![スクリーンショット 2023-04-22 9.34.13.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/ee896948-80e2-c1f1-00df-c841e3f5fc17.png)

後は下の『Deploy』ボタンを押すだけです。

![スクリーンショット 2023-04-22 9.38.37.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/2806e5b7-69eb-176f-3291-ce481914d14f.png)


![スクリーンショット 2023-04-22 9.38.26.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/ff849b47-c1b1-159d-78cf-dd31d632f419.png)

完成版(Laravel 10 URL)

https://qiita-laravel10-on-vercel.vercel.app/

# 終わりに
ここまで慣れてしまえばQiita記事(本記事)を書き進めながら30分でデプロイできてしまいます。
デプロイ先の１つとして、一度検討してみてはいかがでしょうか？
今回は以上です。👋

# おまけ

### DB接続方法

>こちらの記事ではDBとの接続されたりはしたでしょうか？？

というご質問をいただいたのですが、
今回のようなケースで、DBに接続できるかは気になるところですよね💦
結論、できます！

２通りの方法があり、
✅APP_KEYと同様、Vercel側で環境変数を設定する
具体例
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
// ↓ Planet Scale という PaaSを使用する場合
MYSQL_ATTR_SSL_CA=
```
もしくは
✅vercel.json ファイルに記述する

具体例
```
"env": {
       "APP_NAME": "Laravel Vercel",
       "APP_DEBUG": "true",
       "DB_CONNECTION": "mysql",
       "DB_HOST": "",
       "DB_PORT": "",
<省略>
   }
```
のどちらかで接続できます。

下記、自身がVercel側で環境変数を設定し、DBに接続してAPIを叩いた時のキャプチャーになります！
![スクリーンショット 2023-05-03 11.06.13.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/244b6614-1c9c-dcfc-2829-3d868f8ff482.png)

![スクリーンショット 2023-05-03 10.49.23.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/2980785/99406957-8d8e-8b00-17ae-804006e8c724.png)





### そもそも、何でPHPをVercelで動かしたのかについて

* PHP => サーバーサイド言語
* Vercel =>主にフロントエンド界隈で使用されているPaaS


※Heroku も最初考慮していましたが、いつの間にか有料化してました💦
※また、お金が有り余っていたとしたら、PaaSを AWS にしてました！

https://twitter.com/Masa36940064/status/1649650544569634816

### 関連ツイート

https://twitter.com/Masa36940064/status/1649607245985120257?cxt=HHwWgoDUvZvDyuQtAAAA
