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
