<?php

$input = "Test Input.";
echo preg_replace(
    "/([a-z]*)/Xe",
    "strtoupper('\\1')",
    $input
);

echo preg_replace(
    '|^(.*)$|ei',
    '"\1"',
    'get_input'
);

$html = preg_replace('(<h([1-6])>(.*?)</h\1>)xes', '"<h$1>" . strtoupper("$2") . "</h$1>"', $html);

$a = preg_replace(
    '#<h([1-6])>(.*?)</h\1>#e',
    '"<h$1>" . strtoupper("$2") . "</h$1>"',
    $html
);

$string = 'April 15, 2003';
$replacement = '${1}1,$3';
$b = preg_replace('/(\w+) (\d+), (\d+)/i', $replacement, $string);
