<?php

$result = get_web_page("http://www.footballradar.com/quiz/");

if ($result['errno'] != 0)
    echo "error";

if ($result['http_code'] != 200)
    echo "error";

$page = $result['content'];
$openBrackPos = strpos($page, "{");
$closeBrackPos = strpos($page, "}");
$brackets = array("{", "}");
$resolveThisString = str_replace($brackets, "", substr($page, $openBrackPos, $closeBrackPos));
echo $resolveThisString . "<br/>";
$answerLink = "http://www.footballradar.com/quiz/answer/" . evalmath($resolveThisString);
echo $answerLink;
$resultContent = get_web_page($answerLink);
echo $resultContent['content'];
//var_dump($resultContent);



function get_web_page($url) {
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    $options = array(
        CURLOPT_CUSTOMREQUEST => "GET", 
        CURLOPT_POST => false,
        CURLOPT_USERAGENT => $user_agent, 
        CURLOPT_COOKIEFILE => "cookie.txt", 
        CURLOPT_COOKIEJAR => "cookie.txt", 
        CURLOPT_RETURNTRANSFER => true, 
        CURLOPT_HEADER => false, 
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_MAXREDIRS => 10,
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);

    $header['errno'] = $err;
    $header['errmsg'] = $errmsg;
    $header['content'] = $content;
    return $header;
}

function evalmath($eq) {
    if (strpos($eq, "*") == false && strpos($eq, "+") == false && strpos($eq, "-") == false) {
        $result = intval($eq);
    } else {
        if (strpos($eq, "*") !== false) {
            $pieces = explode("*", $eq);
            $result = evalmath($pieces[0]) * evalmath($pieces[1]);
        }
        if (strpos($eq, "+") !== false) {
            $pieces = explode("+", $eq);
            $result = evalmath($pieces[0]) + evalmath($pieces[1]);
        }
        if (strpos($eq, "-") !== false) {
            $pieces = explode("-", $eq);
            $result = evalmath($pieces[0]) - evalmath($pieces[1]);
        }
    }

    return $result;
}
