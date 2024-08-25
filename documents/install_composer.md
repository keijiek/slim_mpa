# composer をインストール

## ubuntu の場合

```bash
sudo apt install composer
```

Mac なら brew など、それぞれのOSに応じたパッケージマネージャを使う。

---

## X-server レンタルサーバーに導入する場合

グローバルにインストールされてはいるが、バージョンが古すぎるので、ローカルに新バージョンをインストールしたうえでパスを通す方法を示す。

まず、コマンドの場所とバージョンを確認。

```bash
which composer
# /usr/bin/composer と出ればグローバルのものが使われている。
# ~/bin/composer などとホームディレクトリ内のものが出れば、既にローカルに入っている。

composer -V
# バージョンが表示される。現在の最新バージョンと比べてみる。
```

グローバルの古いものが使われていることが確認できたら、次の手順を踏んでいく。

1. [composer の公式サイト・ダウンロード](https://getcomposer.org/download/) にインストール用コードが書いてあるので、それをシェルにコピペして実行。
2. ~/bin/ ディレクトリがなければそれを作成し、手順1でインストールされた `composer.phar` をそこに移動させる。

```bash
ls $HOME | grep bin
# bin と表示されれば存在するので、mkdir は無用

# なければ mkdir を実行
mkdir $HOME/bin

# composer.phar を bin に移動。拡張子(phar)は消してしまう。
mv composer.phar $HOME/bin/composer
```

3. パスを通す。`~/.bashrc` か `~/.bash_profile` に、 `export PATH=$PATH:$HOME/bin` の1行がある、または、`PATH=$PATH:$HOME/bin`と`export PATH` の2行があればよいと思われる。

```bash
cat $HOME/.bashrc | grep PATH
cat $HOME/.bash_profile | grep PATH
# export PATH=$PATH:$HOME/bin の行や、 PATH=$PATH:$HOME/bin と export PATH の組み合わせが表示されればOK

# なければ追加して再読み込み。
vi $HOME/.bashrc
source $HOME/.bashrc

vi $HOME/.bash_profile
source $HOME/.bash_profile
```

次で確認。

```bash
which composer
# ~/bin/composer とでればOK

composer -V
# 新しいバージョンが表示されればOK
```

なぜか上手くいかないとき、ログインしなおすとうまくいく可能性が高い。

---

## ついでにシェルの php バージョンも指定する

```bash
# バージョン確認。希望するバージョンならOK
php -v

# 希望するバージョンの usr/bin/php* のシンボリックリンクを ~/bin/php として作成。例では8.1系。
ln -s /usr/bin/php8.1 ~/bin/php
```

もういちどバージョンを確認。うまくいかない場合、ログインしなおすとうまくいっている可能性大。

x-server が推奨していないほどの最新バージョンを使うこともできるが、composer や wp-cli など php 系コマンドの使用時に非推奨エラーがたくさん出るので、控えめにしておくのがよさそう。
