# Exam_20240519
Computer Enginnering 課題
---

# はじめに

以下のプログラムおよびシステムのできるだけシンプルな設計・実装をおこなってください。

- 全部の設問に対して解答する必要はありません。1つでも2つでも結構です。
- 概ね、1週間を目安に、長くとも2週間程度で返信ください。

1. 資料は、出典を示せば書籍や電子化情報を参照してもかまいません
2. プログラムを作成できない場合、動作を示す手順を言葉や図を用いて記述してもかまいません
3. ExcelなどのGUI環境を前提とするものでなければ、用いる言語の指定はありません
   C, Java, Ruby, Pythonなどのプログラミング言語ではなく、bash、shなどシェルを用いてもかまいません。
   余裕があれば、1つの問題を、複数の言語/手法でそれぞれ解答してみてください
4. 作成したプログラムを動作させるのに必要な条件を記述してください
5. 動作結果を提示してください
6. 複数の解法を示せる場合には、複数の解法を示し、比較解説してください
7. 導き出した答案について、自身による詳しい解説・解釈を記してください

※ 問題によっては、正解が無いものもあるかもしれません。


# A. 基礎統計処理

- A1. ランダムな正の整数を1行に1つずつ20行、ファイルもしくは標準出力に対して出力するプログラムを作成してください

- A2. 1行に1つの要素が記述されたデータを、ファイルまたは標準入力から読み取り、以下の計算をおこなってください
  1. データを昇順に並べてください
  
  2. 最大値と最小値を抽出してください
  
  3. 中央値を抽出してください
  
  4. 平均と標準偏差を算出してください

  5. 5を含むデータすべてを抽出してください

入力データサンプル
```
18990
17642
30874
19785
4661
1501
7385
29589
22820
30087
29222
11819
10002
8203
17944
23397
32567
24
13584
13822
```

**=> 実行環境構築**
**Dockerビルド**
1. GitHubURL:
2. `git clone git@github.com:Haruka9404/Exam_20240519.git`を実行しgitのクローンを作成する
3. DockerDesktopアプリを立ち上げる
4. `docker-compose up -d --build`を実行しコンテナを作成する

**MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがある。エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追記する。**

``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`を実行
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。
  または、新しく.envファイルを作成。
4. .envに以下の環境変数を追加

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
7. アプリケーションキーの作成
``` bash
php artisan key:generate
```

8. マイグレーションの実行
``` bash
php artisan migrate
```

**実行環境**
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

**URL**
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/

# B. 運用時の効果的なテキスト処理

以下のシステム障害発生時に対応したワークアラウンドを設計し、障害発生時に自動で復旧するためのスクリプトを作成してください。スクリプトは、root権限で実行することを前提として結構です。

Issue: 特定のLinux環境上でavahi-daemonは、DHCPからのIPv4アドレスの再取得時に、自身のホスト名が衝突していると誤認識する問題があります。問題が生じると、ローカルネットワーク中で名前によるアドレス解決ができなくなるので、avahi-daemonを再起動するなどの対応が必要になります。

avahi-daemonが誤動作した場合、/var/log/daemon.log に以下の文字列を含んだログが追記されます。
```
Host name conflict, retrying with
```

avahi-daemonの再起動は、以下のコマンドで実施できます。
```shell
$ systemctl restart avahi-daemon
```

=> 前提：ホスト名有り=>ログに'Host name conflict, retrying with'が出力される。

  ログに'Host name conflict, retrying with'が出力された時にshellで
  
  '$ systemctl restart avahi-daemon'を実行させるプログラムを実行する

# C. プログラムロジック

以下の要求を満たすプログラムを作成してください。

- 文字種`i`, `r`, `v`, `n`, `e`の5種の文字で構成された文字列(1行)を入力する
- プログラムは、入力文字列を1文字ずつ読み取り、それぞれの文字に対応する以下の処理を実施する
  - `i` アキュムレータ(内部レジスタ:初期値0, 最小値0)をインクリメントする
  - `r` 入力文字列を表示する
  - `v` 'Happy, Hacking! 'という文字列をアキュムレータ値の回数表示する
  - `n` アキュムレータの値を表示し、アキュムレータをデクリメントする
  - `e` 'HALT'と表示してプログラムを停止する
  - 文字列最後尾に改行がある場合には無視する
  - もしも`irvne`以外の文字が読まれたら、'?'を出力して処理を継続

## 例
入力
```
irvine
```

出力
```

irvine
Happy, Hacking!

2
HALT
```

=> 入力文字の格納
  1.入力文字数分の条件チェック
  
  2.i=>アキュムレータのカウント+
  
  3.r=>文字列出力のコード記述
  
  4.v=>アキュムレータのカウント文の繰り返し（繰り返し処理内に'Happy, Hacking! 'の出力コードを記述）
  
  5.n=>アキュムレータのカウント出力コードの記述
  
  6.e=>'HALT'の出力コードを記述と停止コードの記述
  
  7.それ以外=>'?'の出力コードの記述

  （プログラム未作成となります）

# D. コードレビュー

次のプログラムの問題点/危険な点を(何点でも)指摘してください。

数値を3つ(x,y,z)受け取り、sqrt(x/y-z) を計算する
```python
#!/usr/bin/python3

import sys
import math

args=sys.argv
x=int(args[1])
y=int(args[2])
z=int(args[3])

print(math.sqrt(x/y-z))
```
=> 'x/y-z'の計算がエラーとなる場合がある。

- 配列表記でない？ args=[]
  
- 'x=int(args[1]) y=int(args[2]) z=int(args[3])'が配列への格納の場合、[0]から取り出す必要がある
- 'x=int(args[0]) y=int(args[1]) z=int(args[2])'

# E. 暗号解析

次の暗号を解読してください。解読できてもできなくても、どのようにアプローチし、何を手がかりとしたか、作業工程とどのように考えたかを記述してください。

```暗号メッセージ
Ig. Sqlod, qz fro Iulqg Zugi, ruc aqmeoc fro rol-rqhdod zqg fro lxkrf, nhf
yud fqq cghle fq goioinog fq drhf fro bqb-rqaod. Yxfr fro gxlk qz axkrf
zgqi rxd aulfogl culmxlk zgqi dxco fq dxco, ro ahgmroc umgqdd fro wugc,
exmeoc qzz rxd nqqfd uf fro nume cqqg, cgoy rxidoaz u audf kaudd qz noog
zgqi fro nuggoa xl fro dmhaaogw, ulc iuco rxd yuw hb fq noc, yrogo
Igd. Sqlod yud uagoucw dlqgxlk.

Ud dqql ud fro axkrf xl fro nocgqqi yolf qhf frogo yud u dfxggxlk ulc u
zahffogxlk uaa frgqhkr fro zugi nhxacxlkd. Yqgc ruc kqlo gqhlc chgxlk fro
cuw fruf qac Iusqg, fro bgxjo Ixccao Yrxfo nqug, ruc ruc u dfgulko cgoui
ql fro bgotxqhd lxkrf ulc yxdroc fq mqiihlxmufo xf fq fro qfrog ulxiuad.
Xf ruc nool ukgooc fruf frow drqhac uaa ioof xl fro nxk nugl ud dqql ud
Ig. Sqlod yud duzoaw qhf qz fro yuw. Qac Iusqg (dq ro yud uayuwd muaaoc,
frqhkr fro luio hlcog yrxmr ro ruc nool ovrxnxfoc yud Yxaaxlkcql Nouhfw)
yud dq rxkraw gokugcoc ql fro zugi fruf otogwqlo yud phxfo goucw fq aqdo
ul rqhg'd daoob xl qgcog fq roug yruf ro ruc fq duw.
```

=>

# F. データ操作

次のデータ操作を実施してください。

## 準備
各表は、以下の通り。1行目は、カラム名を表します。
データをデータベースなどに適切にロードしてください。
テキストファイルとして処理する場合には、それぞれの表を独立したファイルとして保存してください。

Table: s (供給者)
|sno|供給者名|状態|都市|
|--|--|--|--|
|s1|鈴木|20|東京|
|s2|山本|10|大阪|
|s3|平井|30|大阪|
|s4|倉田|10|東京|
|s5|安達|10|名古屋|

Table: p (部品)
|pno|部品名|色|重さ|都市|
|--|--|--|--|--|
|p1|ナット|赤|12|東京|
|p2|ボルト|緑|17|大阪|
|p3|ネジ|青|17|博多|
|p4|ネジ|赤|14|東京|
|p5|カム|青|12|大阪|
|p6|歯車|赤|19|東京|

Table: sp (仕入)
|sno|pno|数量|
|--|--|--|
|s1|p1|300|
|s1|p2|200|
|s1|p3|400|
|s1|p4|200|
|s1|p5|100|
|s1|p6|100|
|s2|p1|300|
|s2|p2|400|
|s3|p3|200|
|s4|p4|200|
|s4|p5|300|
|s4|p6|400|

=>

## 課題
ただし、色について(アルファベット)降順で結果を表示してください

- F1. **東京の供給者の状態を2倍にした結果**を求めてください
- F2. **重さが15以下の部品**を求めてください
- F3. Table:p から「重さが10を超える」かつ「都市が大阪ではない」**色**と**都市**を重複なく抽出し、色について(アルファベット)降順に結果を表示してくださいてください
- F4. それぞれの部品に対し、**部品番号(pno)**と**その部品を納品する供給者のいるすべての都市名**を一覧表示してください
- F5. **供給者の総数**を求めてください
- F6. **部品を供給する供給者の総数**を求めてください
- F7. **部品p2の総数**を求めてください
- F8. それぞれの部品に対し、**部品番号(pno)**と**その部品の総数量**を一覧で表示してください

=>

# G. Gitの基本操作

下記のコマンドライン操作をgitを用いて実施し、その手順を記してください
- G1. 作業用のディレクトリを作成し、

=> mkdir ディレクトリ名

- G2. その中にGitリポジトリを作成してください

=> git init

- G3. 作業用ディレクトリ内にREADME.mdというファイル(内容は任意のテキスト)を作成してください

=> touch README.md

- G4. リポジトリインデックスにREADME.mdを加え

=> git add README.md

- G5. 変更をリポジトリに反映してください(コメントは任意のテキスト)

=> git commit -m "任意のメッセージ"

- G6. この状態のログを表示してください

=> git status

- G7. ファイルREADME.mdをrmコマンド(git rmではない)で削除して、

=> rm READEME.md

- G8. lsでファイルがなくなっていることを確認

=> ls (-a)

- G9. リポジトリから、削除したファイルを復元してください

=> 

https://jp.easeus.com/mac-file-recovery/recover-files-deleted-by-command-line-on-mac.html?source=dsa&gad_source=1&gclid=Cj0KCQjwgJyyBhCGARIsAK8LVLOQHMGWarmW6NZgVrEd1X-HGuVFJSVAZctlspDssrBaBzwUeMlAvssaAmCTEALw_wcB

# H. 正規表現

以下の要求を満たすの正規表現式を記述してください

- H1. 日付の形式(YYYY-MM-DD)にマッチする正規表現式

=>

- H2. IPv4アドレスにマッチする、ERE式 
  テストケース:
  入力
  ```
  192.168.0.1
  0.0.0.0
  8.8.8.8
  文中にIPアドレス172.16.24.2が含まれているケース
  256.256.224.128
  012.123.234.111
  文中にIPアドレスのようなもの256.256.224.128が含まれているケース
  ```

  出力
  ```
  192.168.0.1
  0.0.0.0
  8.8.8.8
  文中にIPアドレス172.16.24.2が含まれているケース
  ```

=>

- H3. IPv4アドレスにマッチする、PCRE式
  テストケースは、H2と同じ

=>

- H4. 「5文字以上で、数字と小文字を1文字以上含む」パスワードとして適切かを判定する、ERE式
  テストケース:
  ```入力1 NG判定
  12345
  abcde   
  ABCDE6
  ABCDEa
  ab12    
  Abcdef  
  ......0.
  .....s..
  ........
  s...s   
  ```

  ```入力2 OK判定
  t.0..   
  0.t..   
  t0...
  0t...
  t...0   
  0...t   
  .0.t.
  .t.0.
  ..0.t
  ..t.0
  ...0t
  ...t0
  thisis0k
  ```

  =>

- H5. 「5文字以上で、数字と小文字を1文字以上含む」パスワードとして適切かを判定する、PCRE式
  テストケースは、H3と同じ

  =>

- H6. 数字列を含む文字列中の数字列のうち整数部分のみを、3桁ごとに`,`で区切る、PCRE式を用いた(Perl, JavaScriptなどによる)置換ワンライナー
  テストケース:
  ```入力
  12356789012
  12345678.1234567890
  a12345678901
  a12345678901234.123456
  123456789012345z
  12345687890123.123456z
  ```

  ```出力
  12,356,789,012
  12,345,678.1234567890
  a12,345,678,901
  a12,345,678,901,234.123456
  123,456,789,012,345z
  12,345,687,890,123.123456z
  ```

  参考:整数数字列を3桁区切りにするPerlによるワンライナー
  ```bash
  $ perl -pe 's/(\d)(?=(\d{3})+(\D|$))/$1\,/g;'
  ```
  
  =>

# I. プログラムの解析

以下は、**あるプログラミング言語**で記述されたプログラムです。続く設問に答えてください。

```
q([],[]).
q([H|T],S) :-
    p(T,H,L1,L2),
    q(L1,S1), q(L2,S2),
    a(S1,[H|S2], S).

p([X|L],Y,[X|L1],L2) :- X =< Y, !, p(L,Y,L1,L2).
p([X|L],Y,L1,[X|L2]) :- p(L,Y,L1,L2).
p([],_,[],[]).

a([],L,L).
a([H|X],Y,[H|Z]) :- a(X,Y,Z).
```

- I1. このプログラムは、なんの言語で書かれたプログラムですか。

  =>Prolog
  
  https://qiita.com/Yappii_111/items/9991b666511632cc79bb

- I2. 任意の整数で構成されたリストを、述語qの第一引数に渡すと、どのような処理を実施しますか。

  =>
  
- I3. この処理は、なんというアルゴリズムの実装でしょうか。

  =>
  

