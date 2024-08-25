# Bun.js のインストール

package.json に記述されたパッケージをインストールする時や、package.json の scripts を実行する時のために、開発PCに bun をインストールしておく。

[Bun.js 公式サイト](https://bun.sh/) のトップページに、インストール用コマンドが書いてあるので、それ1行で終わり。

インストール後、次を実行して確認

```bash
bun -v

# bun 自体をアップグレード(バージョンアップ)するコマンド。
bun upgrade
```

---

## package.json で指定されているパッケージのインストール

`package.json` の `dependencies` や `devDependencies` に記述されたパッケージをインストールする方法は、package.json があるディレクトリで次のコマンドを打つ。

```bash
bun install
```

---

## package.json で指定されているスクリプトの実行

`package.json` の `scripts` を使う方法は次

例えば、package.json の scripts が次のようになっているとする。

```json
{
  // 略
  "scripts": {
    "build": "vite build",
    "dev": "vite dev"
  },
  // 略
}
```

次の様にコマンドを打つことで script を利用する。

```bash
bun run build  # vite build が実行される。
bun run dev  # vite dev が実行される
```

---

## パッケージを指定してインストール

`bun add -D vite` とコマンドを打つと、そこディレクトリの node_modules に vite と、それが依存する他パッケージがインストールされる。加えて、package.json の `devDependencies` に、vite のパッケージ名とバージョンが記述される。`devDependencies` に書かれたパッケージは、開発用に使われるもの。

`bun add @splidejs/splide` などと打つと、そのディレクトリの node_modules に `@splidejs/splide` と、それが依存する他パッケージがインストールされる。加えて、package.json の dependencies に、@splidejs/splide のパッケージ名とバージョンが記述される。`dependencies` に書かれたパッケージは、本番で使うもの(ブラウザから読み込まれるもの)。

ただ、本番で使うことが想定されたそれらのパッケージも、ビルド時に一つのファイルにバンドルされて本番サーバーに置かれることが多い。そうする場合は devDependencies へのインストールで十分だと思われる。

```bash
bun add -D パッケージ名 # 開発用にパッケージをインストール。package.json の devDependencies に自動でパッケージ名とバージョンが記述される。

bun add パッケージ名 # 本番用のパッケージをインストール。package.json の dependencies に自動でパッケージ名とバージョンが記述される。
```

node.js の `npm` と使い方がよく似ているので、そちらも検索してみると参考になるはず。
