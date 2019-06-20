<?php

assert($a === true);

exec('echo 1;');

passthru('echo 1;');

shell_exec('echo 1;');

system('echo 1;');

md5($text);

serialize([]);

unserialize('');

popen('echo 1;');

proc_open('echo 1;');

create_function('args', 'code');

pcntl_exec('path/goes/here');

srand();

mt_srand();

mt_rand();
