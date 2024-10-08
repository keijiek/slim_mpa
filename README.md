# php + slim + vite + tailwindcss のマルチページ・ウェブサイト

目次:

- [開発・修正の手順](#開発修正の手順)
- [本番環境で使う php ライブラリを composer でインストール](#本番環境で使う-php-ライブラリを-composer-でインストール)
- [SFTP拡張を利用したファイルのアップロード](#sftp-拡張を利用したファイルのアップロード)


## 開発・修正の手順

### bun のインストール

※[Bun.js のインストール](./documents/install_bun.md)を読み、開発環境に `bun` を導入すること。下記の操作の前提となる。

`Node.js` でもよいが、`volta` などのバージョン管理ツールでインストールする必要があるうえ、動作速度も遅いため `bun` を採用した。

### 開発・修正開始時に、必ず node_modules をインストール

開発や修正のために、このプロジェクトをローカルPCに持ってきたとき、次のコマンドを打つこと。

```bash
bun install

# 省略形
bun i
```

これにより、`package.json` に書かれた、開発に必須となるパッケージ群が自動的にインストールされる。それらが依存している他のパッケージも暗黙的にインストールされる。

開発や修正作業が終わったら、`node_modules` を削除してしまっても良い。`package.json` があれば、再び開発・修正するとき、`bun install` と打つことで同じパッケージ構成を何度でも再現できる。


### ビルドとアップロードの概要

ビルドとアップロードの概要は次の通り。

一言でまとめると、`bun run build`を実行した後は、ファイルを編集して保存していけば必要なファイルがアップロードされる仕組み。

1. `bun run build` で `vite build` が実行される。同時に、特定ファイル群の保存が実行されるたび `vite build` が自動で走るようになる。
2. `vite build` が実行されるたび、`/src` 内のファイルがビルドされ `/dist` に本番用ファイルが出力される。同時に、`/public` ディレクトリ内のファイルが、ビルドされない本番用ファイルとして `/.dist` にコピーされる。ビルドに絡まない php や html からそれらを参照するには、`/dist` ディレクトリ内のファイルを読み込むこと。開発時には存在しないファイルも、本番では存在しているので、ビルドに巻き込まれないファイルからは、それを見越して `/dist` 内を読み込みに行く必要がある。
3. VSCode の拡張 `sftp` が `/dist` へのファイル出力を監視しており、ファイル出力が確認されるたび、それらを本番へアップロードする。また `sftp` は、VSCode によるファイル保存(`Ctrl + S`)の実行を監視しており、保存を実行されたファイルを単体で本番へアップロードする。

次に挙げるディレクトリとファイルを編集してはいけない(頭の `/` はプロジェクトルートを表す)：

- ディレクトリ : `/node_modules`, `/vendor`, `/dist`
- ファイル : `/composer.lock`, `/package-lock.json`, `/bun.lockb`。 composer や bun(npm) が使う。

次に挙げるファイルは、よく解らないなら編集しないほうがよい。

- `.htaccess`, `composer.json`, `package.json`, `vite.config.json`, `tailwind.config.js`, `postcss.config.js`, `/.vscode/sftp.json`, `.gitignore`,

---

## 本番環境で使う php ライブラリを composer でインストール

### compose のインストール

※そもそも開発用PCに composer がインストールされていない場合、[composer インストール](./documents/install_composer.md)を読んでインストールしておくことをお勧めする。

※このプロジェクトは X-server レンタルサーバーの利用を想定している。その場合、composer と php のバージョンがかなり古いので、[composer インストール](./documents/install_composer.md) を読み、あるいは関連情報を検索し、レンタルサーバーにおいて、相応しいバージョンの composer と php を使える状態ににしておくことをお勧めする。試してはいないが、古いバージョンでもいけるかもしれない。

### 開発・修正開始時、ローカルプロジェクトに composer パッケージをインストール

リモートサーバー上で動作確認をするなら必須ではいかないが、開発や修正作業を始める時、プロジェクトルートで下記のコマンドを打つ。composer.json が参照され、バックエンドで使うパッケージが、 `vendor` ディレクトリにインストールされる。その際、それらパッケージが依存する他のパッケージも暗黙的にインストールされる。

```bash
composer install
```

作業が終わったら、`vendor` ディレクトリを削除してしまっても良い。composer.json があれば、`composer install` で何度でも同じパッケージ構成を再現できる。

### 本番環境上のプロジェクトに composer パッケージをインストール

このプロジェクトでは、ルーティングとそのエラー処理のために、 `slim/slim` や `slim/psr7` などを、 `composer` で `vendor` ディレクトリにインストールしている。

それらは本番環境(開発中にリモートサーバー上で確認する場合も含む)で使うためのものなので、サーバー上に存在しなければならない。

正しくは次の手順で行う。これにより、本番で使うと指定されたライブラリだけが本番環境にインストールされる。 `vendor` ディレクトリ自体をアップロードすると、開発でしか使わないものもアップロードされるので注意。

1. `composer.json` と `composer.lock` の2ファイルを本番サイトのプロジェクトルートにアップロードする。なお、通常はプロジェクトルートの中にドキュメントルートを置くが、故あってこのプロジェクトでは、プロジェクトルートとドキュメントルートが同じだ。
2. 本番サーバーに ssh でログインしたあと、本番サイトのプロジェクトルート(composer.json があるところ)をカレントディレクトリとして `composer install` を実行。次の通り。

```bash
cd /path/to/project/root/
composer install
```

これで、本番で使うライブラリが、本番の `vendor` ディレクトリに入った。エントリーポイントの `index.php` が、`require __DIR__ . '/vendor/autoload.php';` の記述で `vendor` 内のパッケージを自動読み込みしているので、あとは `use` すればどこからでも使える。

---

## sftp 拡張を利用したファイルのアップロード

この開発環境では、VSCodeの拡張である [sftp 拡張](https://marketplace.visualstudio.com/items?itemName=Natizyskunk.sftp) に、ファイルのアップロードを依存する方法を採用している。

`/.vscode/sftp.json` に設定を書いて挙動を制御する。

### 1. 設定例

```json
{
  "name": "any_name",
  "host": "hoge.com",// 書き換える
  "protocol": "ftp",// 値を sftp にするなら、port を 22 にし、passphrase も設定すること。
  "port": 21,
  "username": "ftp_user_name",// 書き換える
  "password": "ftp_users_password",// 書き換える
  "remotePath": "/",
  "uploadOnSave": true,// 保存時にアップロード。安易にアップロードしたくないなら false 
  "useTempFile": false,
  "openSsh": false,
  "ignore": [
    ".vscode",
    ".git",
  ],
  "watcher": {
    "files": "dist/**/*",// vite によるファイル出力を監視している
    "autoUpload": true,// 出力を確認した場合はアップロード
    "autoDelete": false
  }
}
```

- `host`, `username`, `password` などの設定値を、あなたの環境にあった値に書き換える。

### 2. uploadOnSave 設定

- `uploadOnSave` 設定は、VSCode によってファイルが保存された時に、そのファイルをアップロードするか否かの設定。 `true` なら保存時に自動アップロード。安易にアップロードしたくないなら `false` で。

### 3. watcher 設定

- `watcher.files` 設定は sftp に監視させたいファイルを指定している。設定値が `dist/**/*` なら `/dist` 内の全ファイルが監視対象。`vite.config.js` の設定により vite.js がビルドするファイルは `/dist` に出力されるのだが、ここではそれを監視対象に指定している。 sftp 拡張は、 VSCode が行ったファイル作成・保存をいつも監視しているが、VSCode によらないファイル作成・保存は無視する。この `watcher` 設定で、特別な監視対象の追加と、その後の処理を指示できる。
- `watcher.autoUpload` 設定は、監視対象ファイルの出力を sftp が確認した時、自動的にアップロードするか否かの設定。設定値が `true` なら自動アップロードするということ。上記の `uploadOnSave` 設定とは別個の設定なので注意。

### 4. sftp.json 自動生成

- なお、vscode 上で `Ctrl + Shift + p` で開くコマンドパレットに `SFTP: Config` と入力すれば `/.vscode/sftp.json` に設定のひな形が生成される。なお、それは `protocol` 設定値が `sftp` の場合のひな形。

---

## その他の設定ファイルの概説

- postcss.config.js : postcss による、tailwindcss のビルドと、その際の autoprefixer による介入が設定されている。そのまま放置。
- .gitignore : git 管理時、無視する(無視しない)ディレクトリやファイルのリスト。gitignore.io で作成した。
