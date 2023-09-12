<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Functions;

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
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var boolean
     */
    public $error = false;

    /**
     * List of patterns for forbidden functions.
     *
     * @var array
     */
    public $forbiddenFunctions = [
        '^bind_textdomain_codeset$' => null,
        '^bindtextdomain$' => null,
        '^bz.*$' => null,
        '^call_user_func$' => null,
        '^call_user_func_array$' => null,
        '^chdir$' => null,
        '^chgrp$' => null,
        '^chown$' => null,
        '^chroot$' => null,
        '^com_load_typelib$' => null,
        '^cyrus_connect$' => null,
        '^dba_.*$' => null,
        '^dbase_.*$' => null,
        '^dbx_.*$' => null,
        '^dcgettext$' => null,
        '^dcngettext$' => null,
        '^dgettext$' => null,
        '^dio_.*$' => null,
        '^dngettext$' => null,
        '^domxml_.*$' => null,
        '^fbsql_.*$' => null,
        '^fbsql$' => null,
        '^fdf_add_doc_javascript$' => null,
        '^fdf_open$' => null,
        '^ftp_.*$' => null,
        '^gz.*$' => null,
        '^header$' => null,
        '^highlight_file$' => null,
        '^show_source$' => null,
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
        '^move_uploaded_file$' => null,
        '^msession_.*$' => null,
        '^msg_send$' => null,
        '^msql$' => null,
        '^msql_.*$' => null,
        '^mssql_.*$' => null,
        '^mysql_.*$' => null,
        '^mysql.*$' => null,
        '^odbc_.*$' => null,
        '^openlog$' => null,
        '^ora_.*$' => null,
        '^ovrimos_.*$' => null,
        '^parse_ini_file$' => null,
        '^parsekit_compile_string$' => null,
        '^pcntl_.*$' => null,
        '^posix_.*$' => null,
        '^pfpro_.*$' => null,
        '^pfsockopen$' => null,
        '^pg_.*$' => null,
        '^php_check_syntax$' => null,
        '^print_r$' => null,
        '^printf$' => null,
        '^readgzfile$' => null,
        '^readlink$' => null,
        '^register_shutdown_function$' => null,
        '^register_tick_function$' => null,
        '^scandir$' => null,
        '^session_.*$' => null,
        '^set_include_path$' => null,
        '^ini_set$' => null,
        '^ini_alter$' => null,
        '^set_time_limit$' => null,
        '^setcookie$' => null,
        '^setrawcookie$' => null,
        '^sleep$' => null,
        '^socket_.*$' => null,
        '^stream_.*$' => null,
        '^sybase_.*$' => null,
        '^syslog$' => null,
        '^trigger_error$' => null,
        '^vprintf$' => null,
        '^mysqli.*$' => null,
        '^oci_connect$' => null,
        '^ocilogon$' => null,
        '^oci_pconnect$' => null,
        '^ociplogon$' => null,
        '^quotemeta$' => null,
        '^sqlite_popen$' => null,
        '^time_nanosleep$' => null,
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
        '^get_browser$' => null,
        '^get_headers$' => null,
        '^get_meta_tags$' => null,
        '^getallheaders$' => null,
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
        '^i18n_mime_header_decode$' => null,
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
        '^linkinfo$' => null,
        '^stat$' => null,
        '^lchgrp$' => null,
        '^lchown$' => null,
        '^is_executable$' => null,
        '^is_link$' => null,
        '^is_uploaded_file$' => null,
        '^ssh2_.*$' => null,
        '^file.*$' => null,
        '^chop$' => 'rtrim()',
        '^sizeof$' => 'count()',
        '^is_null$' => 'strict comparison "=== null"',
        '^intval$' => '(int) construction',
        '^strval$' => '(string) construction',
        '^getimagesize$' => 'getimagesizefromstring',
        '^date_sunrise$' => 'date_sun_info',
        '^date_sunset$' => 'date_sun_info',
        '^strptime$' => 'date_parse_from_format',
        '^strftime$' => 'IntlDateFormatter::format',
        '^gmstrftime$' => 'IntlDateFormatter::format',
        '^(mhash|mhash_.*)$' => 'hash_*',
        '^odbc_result_all$' => null
    ];
}
