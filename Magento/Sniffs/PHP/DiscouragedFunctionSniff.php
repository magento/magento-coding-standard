<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;

/**
 * Detects possible usage of discouraged functions.
 */
class DiscouragedFunctionSniff extends ForbiddenFunctionsSniff
{
    /**
     * Pattern flag.
     *
     * @var bool
     */
    protected $patternMatch = true;

    /**
     * List of patterns for forbidden functions.
     *
     * @var array
     */
    public $forbiddenFunctions = [
        '^assert$' => null,
        '^bind_textdomain_codeset$' => null,
        '^bindtextdomain$' => null,
        '^bz.*$' => null,
        '^call_user_func$' => null,
        '^call_user_func_array$' => null,
        '^chdir$' => null,
        '^chgrp$' => null,
        '^chmod$' => null,
        '^chown$' => null,
        '^chroot$' => null,
        '^com_load_typelib$' => null,
        '^copy$' => null,
        '^create_function$' => null,
        '^curl_.*$' => null,
        '^cyrus_connect$' => null,
        '^dba_.*$' => null,
        '^dbase_.*$' => null,
        '^dbx_.*$' => null,
        '^dcgettext$' => null,
        '^dcngettext$' => null,
        '^dgettext$' => null,
        '^dio_.*$' => null,
        '^dirname$' => null,
        '^dngettext$' => null,
        '^domxml_.*$' => null,
        '^exec$' => null,
        '^fbsql_.*$' => null,
        '^fdf_add_doc_javascript$' => null,
        '^fdf_open$' => null,
        '^fopen$' => null,
        '^fclose$' => null,
        '^fsockopen$' => null,
        '^ftp_.*$' => null,
        '^fwrite$' => null,
        '^gettext$' => null,
        '^gz.*$' => null,
        '^header$' => null,
        '^highlight_file$' => null,
        '^ibase_.*$' => null,
        '^id3_set_tag$' => null,
        '^ifx_.*$' => null,
        '^image.*$' => null,
        '^imap_.*$' => null,
        '^ingres_.*$' => null,
        '^ircg_.*$' => null,
        '^ldap_.*$' => null,
        '^link$' => null,
        '^mail$' => null,
        '^mb_send_mail$' => null,
        '^mkdir$' => null,
        '^move_uploaded_file$' => null,
        '^msession_.*$' => null,
        '^msg_send$' => null,
        '^msql$' => null,
        '^msql_.*$' => null,
        '^mssql_.*$' => null,
        '^mysql_.*$' => null,
        '^odbc_.*$' => null,
        '^opendir$' => null,
        '^openlog$' => null,
        '^ora_.*$' => null,
        '^ovrimos_.*$' => null,
        '^parse_ini_file$' => null,
        '^parse_str$' => null,
        '^parse_url$' => null,
        '^parsekit_compile_string$' => null,
        '^passthru$' => null,
        '^pathinfo$' => null,
        '^pcntl_.*$' => null,
        '^posix_.*$' => null,
        '^pfpro_.*$' => null,
        '^pfsockopen$' => null,
        '^pg_.*$' => null,
        '^php_check_syntax$' => null,
        '^popen$' => null,
        '^print_r$' => null,
        '^printf$' => null,
        '^proc_open$' => null,
        '^putenv$' => null,
        '^readfile$' => null,
        '^readgzfile$' => null,
        '^readline$' => null,
        '^readlink$' => null,
        '^register_shutdown_function$' => null,
        '^register_tick_function$' => null,
        '^rename$' => null,
        '^rmdir$' => null,
        '^scandir$' => null,
        '^session_.*$' => null,
        '^set_include_path$' => null,
        '^ini_set$' => null,
        '^set_time_limit$' => null,
        '^setcookie$' => null,
        '^setlocale$' => null,
        '^setrawcookie$' => null,
        '^shell_exec$' => null,
        '^sleep$' => null,
        '^socket_.*$' => null,
        '^stream_.*$' => null,
        '^sybase_.*$' => null,
        '^symlink$' => null,
        '^syslog$' => null,
        '^system$' => null,
        '^touch$' => null,
        '^trigger_error$' => null,
        '^unlink$' => null,
        '^vprintf$' => null,
        '^mysqli.*$' => null,
        '^oci_connect$' => null,
        '^oci_pconnect$' => null,
        '^quotemeta$' => null,
        '^sqlite_popen$' => null,
        '^time_nanosleep$' => null,
        '^base64_decode$' => null,
        '^base_convert$' => null,
        '^basename$' => null,
        '^chr$' => null,
        '^convert_cyr_string$' => null,
        '^dba_nextkey$' => null,
        '^dns_get_record$' => null,
        '^extract$' => null,
        '^fdf_.*$' => null,
        '^fget.*$' => null,
        '^fread$' => null,
        '^fflush$' => null,
        '^get_browser$' => null,
        '^get_headers$' => null,
        '^get_meta_tags$' => null,
        '^getallheaders$' => null,
        '^getenv$' => null,
        '^getopt$' => null,
        '^headers_list$' => null,
        '^hebrev$' => null,
        '^hebrevc$' => null,
        '^highlight_string$' => null,
        '^html_entity_decode$' => null,
        '^ibase_blob_import$' => null,
        '^id3_get_tag$' => null,
        '^import_request_variables$' => null,
        '^ircg_nickname_unescape$' => null,
        '^ldap_get_values$' => null,
        '^mb_decode_mimeheader$' => null,
        '^mb_parse_str$' => null,
        '^mcrypt_decrypt$' => null,
        '^mdecrypt_generic$' => null,
        '^msg_receive$' => null,
        '^ngettext$' => null,
        '^ob_get_contents$' => null,
        '^ob_get_flush$' => null,
        '^ob_start$' => null,
        '^rawurldecode$' => null,
        '^shm_get_var$' => null,
        '^stripcslashes$' => null,
        '^stripslashes$' => null,
        '^token_get_all$' => null,
        '^unpack$' => null,
        '^convert_uudecode$' => null,
        '^iconv_mime_decode$' => null,
        '^iconv_mime_decode_headers$' => null,
        '^iconv_mime_encode$' => null,
        '^iconv_set_encoding$' => null,
        '^php_strip_whitespace$' => null,
        '^addcslashes$' => null,
        '^addslashes$' => null,
        '^escapeshellarg$' => null,
        '^escapeshellcmd$' => null,
        '^gettype$' => null,
        '^var_dump$' => null,
        '^tempnam$' => null,
        '^realpath$' => null,
        '^linkinfo$' => null,
        '^lstat$' => null,
        '^stat$' => null,
        '^lchgrp$' => null,
        '^lchown$' => null,
        '^show_source$' => null,
        '^is_dir$' => null,
        '^is_executable$' => null,
        '^is_file$' => null,
        '^is_link$' => null,
        '^is_readable$' => null,
        '^is_writable$' => null,
        '^is_writeable$' => null,
        '^is_uploaded_file$' => null,
        '^glob$' => null,
        '^ssh2_.*$' => null,
        '^delete$' => null,
        '^file.*$' => null,
        '^chop$' => 'rtrim()',
        '^sizeof$' => 'count()',
        '^is_null$' => 'strict comparison "=== null"',
        '^intval$' => '(int) construction',
        '^strval$' => '(string) construction',
        '^md5$' => 'improved hash functions (SHA-256, SHA-512 etc.)',
        '^serialize$' => 'json_encode',
        '^unserialize$' => 'json_decode',
    ];

    /**
     * Generates warning for this sniff.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the forbidden function in the token array.
     * @param string $function The name of the forbidden function.
     * @param string $pattern The pattern used for the match.
     *
     * @return void
     */
    protected function addError($phpcsFile, $stackPtr, $function, $pattern = null)
    {
        $data = [$function];
        $warningMessage = 'The use of function %s() is discouraged';
        $warningCode = 'Found';
        if ($pattern === null) {
            $pattern = $function;
        }
        if ($this->forbiddenFunctions[$pattern] !== null) {
            $warningCode .= 'WithAlternative';
            $data[] = $this->forbiddenFunctions[$pattern];
            $warningMessage .= '; use %s instead.';
        }
        $phpcsFile->addWarning($warningMessage, $stackPtr, $warningCode, $data);
    }
}
