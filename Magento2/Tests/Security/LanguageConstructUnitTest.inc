<?php

class TestLanguageConstruct
{
    public function go()
    {
        echo '123';
        $a = `ls`;
        $s = 'select echo, print, exit, die from `ls`';
        die();
    }
}

print(1);
exit();
