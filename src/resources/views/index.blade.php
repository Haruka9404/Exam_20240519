<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Exam</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                Exam
            </a>
        </div>
    </header>

    <main>
        <div class="q1-1">
            <p>A1. ランダムな正の整数を1行に1つずつ20行、ファイルもしくは標準出力に対して出力するプログラムを作成してください</p>
            <?php
                function getRandomNum(){
                    return rand();
                }

                $array = [];
                for ($i = 1; $i <= 20; $i++) {
                    $array[$i] = getRandomNum();
	            }
            ?>
            <p>1. データを昇順に並べてください</p>
            <?php
                sort($array);

                foreach ($array as $int) {
                    echo $int.'<br>';
                }
            ?>
            <div class="reference_url">
                <a href="https://qiita.com/TetsuTaka/items/bb020642e75458217b8a" target="_blank">参考URL：Qiita ランダムな英数字の文字列を作成</a>
                <br>
                <a href="https://ameblo.jp/linking/entry-10289895826.html" target="_blank">参考URL：Ameblo phpでランダムな英数字を好きな文字数で取得する関数</a>
            </div>
        </div>

        <div class="q1-2">
            <p>2. 最大値と最小値を抽出してください</p>
            <?php
                echo '最大値：'.max($array).'<br>';
                echo '最小値：'.min($array).'<br>';
            ?>
            <div class="reference_url">
                <a href="https://qiita.com/delph/items/22d7a81d827c22c2c8e2" target="_blank">参考URL：Qiita PHP で最大値・最小値を取り出す</a>
            </div>
        </div>

        <div class="q1-3">
            <p>3. 中央値を抽出してください</p>
            <?php
                function calculateMidian($array) {
                    $count = count($array);
                    $middleIndex = floor($count/2);
                    $midian = ($array[$middleIndex -1]+ $array[$middleIndex]) /2;
                    return $midian;
                }
                echo '中央値：'.calculateMidian($array)."\n".'<br>';
            ?>
            <div class="reference_url">
                <a href="https://tomodigi.com/web/php%E3%81%A7%E5%B9%B3%E5%9D%87%E5%80%A4%E3%81%A8%E4%B8%AD%E5%A4%AE%E5%80%A4/" target="_blank">参考URL：トモデジ PHPで平均値と中央値 (PHP)</a>
            </div>
        </div>

        <div class="q1-4">
            <p>4. 平均と標準偏差を算出してください</p>
            <?php
            // 平均
                function calculateAverage($array) {
                    if(count($array)===0){
                        return 0;
                    }
                    $sum = array_sum($array);
                    $count = count($array);
                    $average = $sum/$count/2;
                    return $average;
                }
                echo '平均値：'.calculateAverage($array)."\n".'<br>';

            // 偏差
                function calculateStandardDeviation($array) {
                    $count = count($array);
                    if ($count <2 ) {
                        return 0;
                    }
                    $sum = array_sum($array)/$count;
                    $sumOfSquares = 0;
                    foreach ($array as $int) {
                        $sumOfSquares += pow($int - $sum,2);
                    }
                    $variance = $sumOfSquares / $count;
                    $standardDeviation = sqrt($variance);
                    return $standardDeviation;
                }
                echo '標準偏差：'.calculateStandardDeviation($array)."\n".'<br>';
            ?>
        </div>

        <div class="q1-5">
            <p>5. 5を含むデータすべてを抽出してください</p>
            <?php
                $result = preg_grep('/5/',$array);
                print_r($result);

// $result = in_array("5", $array);
// $result = preg_grep('/5/', $array);
// echo $result;

            ?>
            <div class="reference_url">
                <a href="https://qiita.com/PaGe1000/items/c65a79dbbfe97252acd7" target="_blank">参考URL：Qiita PHPで配列の要素を部分一致で検索する方法</a>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>