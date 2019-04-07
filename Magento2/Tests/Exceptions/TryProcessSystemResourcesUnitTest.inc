<?php

namespace Foo\Bar;

use Exception;

class StreamHandler
{
    public function handleException()
    {
        try {
            $strChar = stream_get_contents(STDIN, 1);
        } catch (Exception $exception) {

        }
    }

    public function execute()
    {
        // Rule find: Try block detected when processing system resources
        $strChar = stream_get_contents(STDIN, 1);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://www.example.com/");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
        } catch (Exception $exception) {

        }
    }
}

function executeStream()
{
    // Rule find: Try block detected when processing system resources
    $strChar = stream_get_contents(STDIN, 1);
    // Rule find: Try block detected when processing system resources
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    // Rule find: Try block detected when processing system resources
    socket_bind($sock);
    // Rule find: Try block detected when processing system resources
    socket_close($sock);
}
