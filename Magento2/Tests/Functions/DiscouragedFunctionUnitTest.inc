<?php

assert('2 < 1');

$domain = 'messages';
bindtextdomain($domain, 'path_to_messages_dir');
bind_textdomain_codeset($domain, 'ISO-8859-15');

$bz = bzopen('/tmp/foo.bz2', 'r');
bzoclose('/tmp/foo.bz2');

call_user_func(function ($arg) {
    echo($arg);
}, 8);

call_user_func_array(function ($arg1, $arg2) {
    echo($arg1 + $arg2);
}, [5, 8]);

chdir('somedir');

chgrp('somefile.txt', 8);

chmod('/somedir/somefile', 755);

chown('/somedir/somefile', 'root');

chroot('/path/to/your/chroot/');

com_load_typelib('SomeLib.Application');

copy('example.txt', 'example.txt.bk');

$func = create_function('$a,$b', 'return "ln($a) + ln($b) = " . log($a * $b);');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.example.com/');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);

cyrus_connect('http://www.example.com/');

$db = dba_open('/tmp/test.db', 'n', 'gdbm');
dba_close($db);

$db = dbase_open('/tmp/test.dbf', 0);
dbase_close($db);

$db = dbx_connect(DBX_MYSQL, 'localhost', 'db', 'username', 'password');
$result = dbx_query($conn, 'select id from non_existing_table');
dbx_close($db);

$message = dcgettext('domain', 'messsage', 'category');

$message = dcngettext('domain', 'msgid1', 'msgid2', 'n', 'category');

bindtextdomain('myapp', '/usr/share/myapp/locale');

dgettext('domain', 'message');

$fd = dio_open('/dev/ttyS0', O_RDWR);
dio_close($fd);

dirname('/etc/passwd') . PHP_EOL;

$message = dngettext('domain', 'msgid1', 'msgid2', 'n', 'category');

domxml_new_doc();

exec('whoami');

$conn = fbsql_connect();
fbsql_close($conn);

$fdf = fdf_open('test.fdf');
fdf_add_doc_javascript($fdf, 'plusOne', "function plusOne(x)\r{\r  return x+1;\r}\r");
fdf_save($fdf);

$handle = fopen('c:\\folder\\resource.txt', 'r');

$fp = fsockopen('www.example.com', 80, $errno, $errstr, 30);

$conn = ftp_connect('ftp_server');
$login_result = ftp_login($conn, 'username', 'password');
ftp_close($conn);

$fp = fopen('data.txt', 'w');
fwrite($fp, '1');
fwrite($fp, '23');
fclose($fp);

gettext('Some Text');

$gz = gzopen('somefile.gz', 'w9');
gzputs($gz, 'Добавлено в файл somefile.gz');
gzclose($gz);

header('Location: http://www.example.com/');

highlight_file('file.php');

$conn = ibase_connect('localhost:/path/to/your.gdb', 'username', 'password');
ibase_close($conn);

id3_set_tag('path/to/example.mp3', ['artist' => 'Radiohead']);

$conn = ifx_connect('mydb@ol_srv1', 'username', 'password');
ifx_close($conn);

$src = imagecreatefromgif('php.gif');
$img = imagecreatetruecolor(80, 40);

$mbox = imap_open('{localhost:143}INBOX', 'username', 'password');

$conn = ingres_connect('mydb', 'username', 'password');
ingres_close($conn);

ircg_get_username(1);

$conn = ldap_connect('ldap.example.com', 398);

link('source.ext', 'newfile.ext');

mail('test@example.com', 'My Subject', 'Text message');

mb_send_mail('test@example.com', 'My Subject', 'Text message');

mkdir('/test1/test2', 0777, true);

move_uploaded_file('name', 'dir_name');

msession_connect('host', 'port');

msg_send(msg_get_queue(1), 12, 'test', false);

msql('db', 'query');

$conn = msql_connect('host');
msql_close($conn);

$conn = mssql_connect('TEST\SERVER', 'username', 'password');
msql_close($conn);

$conn = mysql_connect('localhost', 'username', 'password');
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_close($conn);

$connection = odbc_connect('Driver={SQL Server Native Client 10.0};Server=S;Database=DB;', 'username', 'password');

opendir('/etc/php5/');

openlog('test', LOG_PID, 1);

$cursorId = ora_open($conn);
ora_do($cursorId, 'query');

$conn = ovrimos_connect('db_host', '8001', 'username', 'password');
ovrimos_close($conn);

$iniArray = parse_ini_file('sample.ini', true);

$str = 'first=value&arr[]=foo+bar&arr[]=baz';
parse_str($str);

$url = 'http://username:password@hostname:9090/path?arg=value#anchor';
parse_url($url, PHP_URL_USER);

$ops = parsekit_compile_string('echo "Foo\n";', $errors);

passthru('test.zip', $err);

pcntl_alarm(300);

posix_access('some_file', POSIX_R_OK | POSIX_W_OK);

pfpro_init();
pfpro_cleanup();

pfsockopen('ssl://www.example.com', 443, $errno, $errstr);

$conn = pg_connect('dbname=test');
pg_close($conn);

php_check_syntax('filename');

$handle = popen('/bin/ls', 'r');

print_r(['key' => 'value']);

printf('%d', '17,999');

proc_open('php', [0 => ['pipe', 'r']], $pipes, '/tmp', ['some_option' => 'test']);

putenv('USER=test');

readfile('test.gif');

readgzfile('test.html.gz');

readline('Command: ');

readlink('/vmlinuz');

register_shutdown_function(function () {
    echo 'Script executed with success', PHP_EOL;
});

register_tick_function(function () {
    echo 'cript executed with success', PHP_EOL;
});

rename('/tmp/tmp_file.txt', '/home/user/login/docs/my_file.txt');

rmdir('examples');

scandir('/tmp');

session_start();

set_include_path('/usr/lib/pear');

ini_set('display_errors', 1);

set_time_limit(3);

setcookie('TestCookie', 'Something from somewhere', time() + 3600);

setlocale(LC_ALL, 'nl_NL');

setrawcookie('TestCookie', 'Something from somewhere', time() + 3600);

shell_exec('ls -l');

sleep(10);

socket_connect($socket, $address, $port);

if ($stream = fopen('http://www.example.com', 'r')) {
    echo stream_get_contents($stream, -1, 10);
    fclose($stream);
}

$conn = sybase_connect('SYBASE', '', '');
sybase_close($conn);

symlink('uploads.php', 'uploads');

syslog(LOG_WARNING, 'Message');

system('ls', $retval);

touch('some_file.txt', time() - 3600);

if ($divisor == 0) {
    trigger_error('Cannot divide by zero', E_USER_ERROR);
}

unlink('some_file.txt');

vprintf('%04d-%02d-%02d', explode('-', '1988-8-1'));

mysqli_close($conn);

$conn = oci_connect('username', 'password', 'localhost');

$conn = oci_pconnect('username', 'password', 'localhost');

quotemeta('Hello world. (can you hear me?)');

sqlite_popen('filename');

time_nanosleep(0, 500000000);

base64_decode('VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==');

base_convert('a37334', 16, 2);

basename('/');

chr(27);

convert_cyr_string('string', 'feom', 'to');

dba_nextkey($handle);

dns_get_record('php.net');

$varArray = [
    'color' => 'blue',
    'size' => 'medium',
    'shape' => 'sphere',
];
extract($varArray, EXTR_PREFIX_SAME, 'wddx');

$outfdf = fdf_create();
fdf_set_value($outfdf, 'volume', $volume, 0);

$file = fopen(__FILE__, 'r');
$input = fgetc($file);
$line = fgets($file);
$contents = fread($file, 100);
fflush($file);

$browser = get_browser(null, true);

get_headers('http://www.example.com');

$tags = get_meta_tags('http://www.example.com/');

$headers = getallheaders();

$ip = getenv('REMOTE_ADDR');

$options = getopt('f:hp:');

$headersList = headers_list();

$decodedText = hebrev('טקסטים מנוקדים');

$decodedText = hebrevc('טקסטים מנוקדים');

highlight_string('<?php echo"<div>text</div>"; ?>');

html_entity_decode('html&lt;span&gt;string&lt;/span&gt;&amp;&lt;div&gt;block&lt;/div&gt;');

ibase_connect('/path/to/employees.gdb', 'username', 'password');
$blob = ibase_blob_import($file);

$tag = id3_get_tag('path/to/example.mp3');

import_request_variables('gP', 'rvar_');

$nickname = ircg_nickname_unescape('nickname');

$values = ldap_get_values('ds', 'entry', 'mail');

mb_decode_mimeheader($str);

mb_parse_str('email=kehaovista@qq.com&city=shanghai&job=Phper', $result);

$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
mcrypt_decrypt(MCRYPT_RIJNDAEL_256, 'key', 'text', MCRYPT_MODE_ECB, $iv);

$td = mcrypt_module_open('des', '', 'ecb', '');
$cryptedText = mcrypt_generic($td, 'plain text');
$plainText = mdecrypt_generic($td, $cryptedText);

$key = msg_get_queue(ftok('/tmp/php_msgqueue.stat', 'R'), 0666 | IPC_CREAT);
msg_receive($key, 1, 1, 16384, 'message', true, 0);

ngettext('%d window', '%d windows', 21);

$out = ob_get_contents();
$out = ob_get_flush();

rawurldecode('foo%20bar%40baz');

$var = shm_get_var(55, 'key');

$string = stripcslashes('He\xallo');

$string = stripslashes("Is your name O\'reilly?");

$tokens = token_get_all('<?php echo; ?>');

$array = unpack('cchars/nint', '\x04\x00\xa0\x00');

$decodedText = convert_uudecode("+22!L;W9E(%!(4\"$`\n`");

$decodedText = iconv_mime_decode('Subject: =?UTF-8?B?UHLDvGZ1bmcgUHLDvGZ1bmc=?=', 0, 'ISO-8859-1');

$headersString = <<<EOF
Subject: =?UTF-8?B?UHLDvGZ1bmcgUHLDvGZ1bmc=?=
To: example@example.com
Date: Thu, 1 Jan 1970 00:00:00 +0000
Message-Id: <example@example.com>
Received: from localhost (localhost [127.0.0.1]) by localhost
    with SMTP id example for <example@example.com>;
    Thu, 1 Jan 1970 00:00:00 +0000 (UTC)
    (envelope-from example-return-0000-example=example.com@example.com)
Received: (qmail 0 invoked by uid 65534); 1 Thu 2003 00:00:00 +0000
EOF;
$headers = iconv_mime_decode_headers($headersString, 0, 'ISO-8859-1');

$preferences = [
    'input-charset' => 'ISO-8859-1',
    'output-charset' => 'UTF-8',
    'line-length' => 76,
    'line-break-chars' => "\n",
    'scheme' => 'Q',
];
iconv_mime_encode('Subject', 'Prüfung Prüfung', $preferences);

iconv_set_encoding('internal_encoding', 'UTF-8');

php_strip_whitespace(__FILE__);

$connection = ssh2_connect('shell.example.com', 22);
$auth_methods = ssh2_auth_none($connection, 'user');

$lines = file(__FILE__);
$atime = fileatime(__FILE__);

$message = addcslashes('foo[ ]', 'A..z');

$message = addslashes("Is your name O'Reilly?");

$message = escapeshellarg('shell:command:string');

$message = escapeshellcmd('shell string');

gettype(['a' => 5]);

var_dump($message);

tempnam('./tmp/', 'filePrefix');

realpath('./../../etc/passwd');

linkinfo('/');

lstat('./');

stat('./');

lchgrp('__FILE__', 8);

lchown('__FILE__', 8);

show_source(__FILE__);

is_dir('./');

is_executable('./');

is_file('./');

is_link('./');

is_readable('./');

is_writable('./');

is_writeable('./');

is_uploaded_file('uploads.php');

glob('*.txt');

$size = sizeof($array);

$check = is_null($size);

$str = strval($str);

$int = intval($int);

$str = chop($text, 'ttt');

md5($text);

htmlspecialchars('text');

file_exists('./');

file_get_contents('file.txt');

file_put_contents($file, 'test');

fgetcsv($fp,'r');

fputcsv($fp, $fields);

ftell($file);

fseek($file, 0);

feof($fp);

flock($fp, LOCK_EX);

$test = date_sunrise(0);

$test = date_sunset(0);

$test = strptime('12.12.12 00:00:00', 'D, d M Y H:i:s');

strftime('D, d M Y H:i:s');

gmstrftime('D, d M Y H:i:s');

$test = mhash(1000, 'test_value');

$test = mhash_count();

$test = mhash_get_block_size(1000);

$test = mhash_get_hash_name(1000);

$test = mhash_keygen_s2k(1000, 'password', 'abccdf' , 10);

$test = odbc_result_all('test_value', 'test_value');
