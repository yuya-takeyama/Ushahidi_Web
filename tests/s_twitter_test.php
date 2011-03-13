<?php
$trueCases = array(
    'hoge RT: @hogefuga fuga',
    'hoge QT: @hogefuga fuga',
    'hoge RT @hogefuga fuga',
    'hoge QT @hogefuga fuga',
);

$falseCases = array(
    'foo'
);

runTest($trueCases, $falseCases);

/**
 * Tweet が非公式 Retweet だったら true.
 */
function isUnofficealRetweet($tweet)
{
    return preg_match('/^(.+?) *(R|Q)T( |:)*(@[a-zA-Z0-9_]+)( |:)/u', $tweet->text) > 0;
}

function stringToTweet($str)
{
    $tweet = new stdClass;
    $tweet->text = $str;
    return $tweet;
}

function runTest($trueCases, $falseCases)
{
    $okCount = $ngCount = 0;

    echo "非公式 Retweet として検出されるべきもの.", PHP_EOL;
    foreach ($trueCases as $case) {
        $tweet = stringToTweet($case);
        if (isUnofficealRetweet($tweet)) {
            echo "OK.";
            $okCount++;
        } else {
            echo "NG!";
            $ngCount++;
        }
        echo " => ", $case, PHP_EOL;
    }

    echo PHP_EOL;

    echo "検出されるべきでないもの.", PHP_EOL;
    foreach ($falseCases as $case) {
        $tweet = stringToTweet($case);
        if (isUnofficealRetweet($tweet) === false) {
            echo "OK.";
            $okCount++;
        } else {
            echo "NG!";
            $ngCount++;
        }
        echo " => ", $case, PHP_EOL;
    }

    echo PHP_EOL;

    if ($okCount) {
        echo "Success: {$okCount}", PHP_EOL;
    }
    if ($ngCount) {
        echo "Failure: {$ngCount}", PHP_EOL;
    } else {
        echo "All passed!", PHP_EOL;
    }
}
