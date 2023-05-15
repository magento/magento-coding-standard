<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\PHPCompatibility;

use Magento2\Helpers\Assert;
use PHP_CodeSniffer_File as File;

/**
 * @inheritdoc
 */
class RemovedFunctionsSniff extends \PHPCompatibility\Sniffs\FunctionUse\RemovedFunctionsSniff
{
    /**
     * {@inheritdoc}
     * @var array
     */
    protected $removedFunctions = [
        'crack_check' => [
            '5.0'       => true,
        ],
        'crack_closedict' => [
            '5.0'       => true,
        ],
        'crack_getlastmessage' => [
            '5.0'       => true,
        ],
        'crack_opendict' => [
            '5.0'       => true,
        ],

        'php_check_syntax' => [
            '5.0.5' => true,
        ],

        'pfpro_cleanup' => [
            '5.1'       => true,
        ],
        'pfpro_init' => [
            '5.1'       => true,
        ],
        'pfpro_process_raw' => [
            '5.1'       => true,
        ],
        'pfpro_process' => [
            '5.1'       => true,
        ],
        'pfpro_version' => [
            '5.1'       => true,
        ],
        'm_checkstatus' => [
            '5.1'       => true,
        ],
        'm_completeauthorizations' => [
            '5.1'       => true,
        ],
        'm_connect' => [
            '5.1'       => true,
        ],
        'm_connectionerror' => [
            '5.1'       => true,
        ],
        'm_deletetrans' => [
            '5.1'       => true,
        ],
        'm_destroyconn' => [
            '5.1'       => true,
        ],
        'm_destroyengine' => [
            '5.1'       => true,
        ],
        'm_getcell' => [
            '5.1'       => true,
        ],
        'm_getcellbynum' => [
            '5.1'       => true,
        ],
        'm_getcommadelimited' => [
            '5.1'       => true,
        ],
        'm_getheader' => [
            '5.1'       => true,
        ],
        'm_initconn' => [
            '5.1'       => true,
        ],
        'm_initengine' => [
            '5.1'       => true,
        ],
        'm_iscommadelimited' => [
            '5.1'       => true,
        ],
        'm_maxconntimeout' => [
            '5.1'       => true,
        ],
        'm_monitor' => [
            '5.1'       => true,
        ],
        'm_numcolumns' => [
            '5.1'       => true,
        ],
        'm_numrows' => [
            '5.1'       => true,
        ],
        'm_parsecommadelimited' => [
            '5.1'       => true,
        ],
        'm_responsekeys' => [
            '5.1'       => true,
        ],
        'm_responseparam' => [
            '5.1'       => true,
        ],
        'm_returnstatus' => [
            '5.1'       => true,
        ],
        'm_setblocking' => [
            '5.1'       => true,
        ],
        'm_setdropfile' => [
            '5.1'       => true,
        ],
        'm_setip' => [
            '5.1'       => true,
        ],
        'm_setssl_cafile' => [
            '5.1'       => true,
        ],
        'm_setssl_files' => [
            '5.1'       => true,
        ],
        'm_setssl' => [
            '5.1'       => true,
        ],
        'm_settimeout' => [
            '5.1'       => true,
        ],
        'm_sslcert_gen_hash' => [
            '5.1'       => true,
        ],
        'm_transactionssent' => [
            '5.1'       => true,
        ],
        'm_transinqueue' => [
            '5.1'       => true,
        ],
        'm_transkeyval' => [
            '5.1'       => true,
        ],
        'm_transnew' => [
            '5.1'       => true,
        ],
        'm_transsend' => [
            '5.1'       => true,
        ],
        'm_uwait' => [
            '5.1'       => true,
        ],
        'm_validateidentifier' => [
            '5.1'       => true,
        ],
        'm_verifyconnection' => [
            '5.1'       => true,
        ],
        'm_verifysslcert' => [
            '5.1'       => true,
        ],
        'dio_close' => [
            '5.1'       => true,
        ],
        'dio_fcntl' => [
            '5.1'       => true,
        ],
        'dio_open' => [
            '5.1'       => true,
        ],
        'dio_read' => [
            '5.1'       => true,
        ],
        'dio_seek' => [
            '5.1'       => true,
        ],
        'dio_stat' => [
            '5.1'       => true,
        ],
        'dio_tcsetattr' => [
            '5.1'       => true,
        ],
        'dio_truncate' => [
            '5.1'       => true,
        ],
        'dio_write' => [
            '5.1'       => true,
        ],
        'fam_cancel_monitor' => [
            '5.1'       => true,
        ],
        'fam_close' => [
            '5.1'       => true,
        ],
        'fam_monitor_collection' => [
            '5.1'       => true,
        ],
        'fam_monitor_directory' => [
            '5.1'       => true,
        ],
        'fam_monitor_file' => [
            '5.1'       => true,
        ],
        'fam_next_event' => [
            '5.1'       => true,
        ],
        'fam_open' => [
            '5.1'       => true,
        ],
        'fam_pending' => [
            '5.1'       => true,
        ],
        'fam_resume_monitor' => [
            '5.1'       => true,
        ],
        'fam_suspend_monitor' => [
            '5.1'       => true,
        ],
        'yp_all' => [
            '5.1'       => true,
        ],
        'yp_cat' => [
            '5.1'       => true,
        ],
        'yp_err_string' => [
            '5.1'       => true,
        ],
        'yp_errno' => [
            '5.1'       => true,
        ],
        'yp_first' => [
            '5.1'       => true,
        ],
        'yp_get_default_domain' => [
            '5.1'       => true,
        ],
        'yp_master' => [
            '5.1'       => true,
        ],
        'yp_match' => [
            '5.1'       => true,
        ],
        'yp_next' => [
            '5.1'       => true,
        ],
        'yp_order' => [
            '5.1'       => true,
        ],
        'udm_add_search_limit' => [
            '5.1'       => true,
        ],
        'udm_alloc_agent_array' => [
            '5.1'       => true,
        ],
        'udm_alloc_agent' => [
            '5.1'       => true,
        ],
        'udm_api_version' => [
            '5.1'       => true,
        ],
        'udm_cat_list' => [
            '5.1'       => true,
        ],
        'udm_cat_path' => [
            '5.1'       => true,
        ],
        'udm_check_charset' => [
            '5.1'       => true,
        ],
        'udm_clear_search_limits' => [
            '5.1'       => true,
        ],
        'udm_crc32' => [
            '5.1'       => true,
        ],
        'udm_errno' => [
            '5.1'       => true,
        ],
        'udm_error' => [
            '5.1'       => true,
        ],
        'udm_find' => [
            '5.1'       => true,
        ],
        'udm_free_agent' => [
            '5.1'       => true,
        ],
        'udm_free_ispell_data' => [
            '5.1'       => true,
        ],
        'udm_free_res' => [
            '5.1'       => true,
        ],
        'udm_get_doc_count' => [
            '5.1'       => true,
        ],
        'udm_get_res_field' => [
            '5.1'       => true,
        ],
        'udm_get_res_param' => [
            '5.1'       => true,
        ],
        'udm_hash32' => [
            '5.1'       => true,
        ],
        'udm_load_ispell_data' => [
            '5.1'       => true,
        ],
        'udm_set_agent_param' => [
            '5.1'       => true,
        ],
        'w32api_deftype' => [
            '5.1'       => true,
        ],
        'w32api_init_dtype' => [
            '5.1'       => true,
        ],
        'w32api_invoke_function' => [
            '5.1'       => true,
        ],
        'w32api_register_function' => [
            '5.1'       => true,
        ],
        'w32api_set_call_method' => [
            '5.1'       => true,
        ],
        'cpdf_add_annotation' => [
            '5.1'       => true,
        ],
        'cpdf_add_outline' => [
            '5.1'       => true,
        ],
        'cpdf_arc' => [
            '5.1'       => true,
        ],
        'cpdf_begin_text' => [
            '5.1'       => true,
        ],
        'cpdf_circle' => [
            '5.1'       => true,
        ],
        'cpdf_clip' => [
            '5.1'       => true,
        ],
        'cpdf_close' => [
            '5.1'       => true,
        ],
        'cpdf_closepath_fill_stroke' => [
            '5.1'       => true,
        ],
        'cpdf_closepath_stroke' => [
            '5.1'       => true,
        ],
        'cpdf_closepath' => [
            '5.1'       => true,
        ],
        'cpdf_continue_text' => [
            '5.1'       => true,
        ],
        'cpdf_curveto' => [
            '5.1'       => true,
        ],
        'cpdf_end_text' => [
            '5.1'       => true,
        ],
        'cpdf_fill_stroke' => [
            '5.1'       => true,
        ],
        'cpdf_fill' => [
            '5.1'       => true,
        ],
        'cpdf_finalize_page' => [
            '5.1'       => true,
        ],
        'cpdf_finalize' => [
            '5.1'       => true,
        ],
        'cpdf_global_set_document_limits' => [
            '5.1'       => true,
        ],
        'cpdf_import_jpeg' => [
            '5.1'       => true,
        ],
        'cpdf_lineto' => [
            '5.1'       => true,
        ],
        'cpdf_moveto' => [
            '5.1'       => true,
        ],
        'cpdf_newpath' => [
            '5.1'       => true,
        ],
        'cpdf_open' => [
            '5.1'       => true,
        ],
        'cpdf_output_buffer' => [
            '5.1'       => true,
        ],
        'cpdf_page_init' => [
            '5.1'       => true,
        ],
        'cpdf_place_inline_image' => [
            '5.1'       => true,
        ],
        'cpdf_rect' => [
            '5.1'       => true,
        ],
        'cpdf_restore' => [
            '5.1'       => true,
        ],
        'cpdf_rlineto' => [
            '5.1'       => true,
        ],
        'cpdf_rmoveto' => [
            '5.1'       => true,
        ],
        'cpdf_rotate_text' => [
            '5.1'       => true,
        ],
        'cpdf_rotate' => [
            '5.1'       => true,
        ],
        'cpdf_save_to_file' => [
            '5.1'       => true,
        ],
        'cpdf_save' => [
            '5.1'       => true,
        ],
        'cpdf_scale' => [
            '5.1'       => true,
        ],
        'cpdf_set_action_url' => [
            '5.1'       => true,
        ],
        'cpdf_set_char_spacing' => [
            '5.1'       => true,
        ],
        'cpdf_set_creator' => [
            '5.1'       => true,
        ],
        'cpdf_set_current_page' => [
            '5.1'       => true,
        ],
        'cpdf_set_font_directories' => [
            '5.1'       => true,
        ],
        'cpdf_set_font_map_file' => [
            '5.1'       => true,
        ],
        'cpdf_set_font' => [
            '5.1'       => true,
        ],
        'cpdf_set_horiz_scaling' => [
            '5.1'       => true,
        ],
        'cpdf_set_keywords' => [
            '5.1'       => true,
        ],
        'cpdf_set_leading' => [
            '5.1'       => true,
        ],
        'cpdf_set_page_animation' => [
            '5.1'       => true,
        ],
        'cpdf_set_subject' => [
            '5.1'       => true,
        ],
        'cpdf_set_text_matrix' => [
            '5.1'       => true,
        ],
        'cpdf_set_text_pos' => [
            '5.1'       => true,
        ],
        'cpdf_set_text_rendering' => [
            '5.1'       => true,
        ],
        'cpdf_set_text_rise' => [
            '5.1'       => true,
        ],
        'cpdf_set_title' => [
            '5.1'       => true,
        ],
        'cpdf_set_viewer_preferences' => [
            '5.1'       => true,
        ],
        'cpdf_set_word_spacing' => [
            '5.1'       => true,
        ],
        'cpdf_setdash' => [
            '5.1'       => true,
        ],
        'cpdf_setflat' => [
            '5.1'       => true,
        ],
        'cpdf_setgray_fill' => [
            '5.1'       => true,
        ],
        'cpdf_setgray_stroke' => [
            '5.1'       => true,
        ],
        'cpdf_setgray' => [
            '5.1'       => true,
        ],
        'cpdf_setlinecap' => [
            '5.1'       => true,
        ],
        'cpdf_setlinejoin' => [
            '5.1'       => true,
        ],
        'cpdf_setlinewidth' => [
            '5.1'       => true,
        ],
        'cpdf_setmiterlimit' => [
            '5.1'       => true,
        ],
        'cpdf_setrgbcolor_fill' => [
            '5.1'       => true,
        ],
        'cpdf_setrgbcolor_stroke' => [
            '5.1'       => true,
        ],
        'cpdf_setrgbcolor' => [
            '5.1'       => true,
        ],
        'cpdf_show_xy' => [
            '5.1'       => true,
        ],
        'cpdf_show' => [
            '5.1'       => true,
        ],
        'cpdf_stringwidth' => [
            '5.1'       => true,
        ],
        'cpdf_stroke' => [
            '5.1'       => true,
        ],
        'cpdf_text' => [
            '5.1'       => true,
        ],
        'cpdf_translate' => [
            '5.1'       => true,
        ],
        'ircg_channel_mode' => [
            '5.1'       => true,
        ],
        'ircg_disconnect' => [
            '5.1'       => true,
        ],
        'ircg_eval_ecmascript_params' => [
            '5.1'       => true,
        ],
        'ircg_fetch_error_msg' => [
            '5.1'       => true,
        ],
        'ircg_get_username' => [
            '5.1'       => true,
        ],
        'ircg_html_encode' => [
            '5.1'       => true,
        ],
        'ircg_ignore_add' => [
            '5.1'       => true,
        ],
        'ircg_ignore_del' => [
            '5.1'       => true,
        ],
        'ircg_invite' => [
            '5.1'       => true,
        ],
        'ircg_is_conn_alive' => [
            '5.1'       => true,
        ],
        'ircg_join' => [
            '5.1'       => true,
        ],
        'ircg_kick' => [
            '5.1'       => true,
        ],
        'ircg_list' => [
            '5.1'       => true,
        ],
        'ircg_lookup_format_messages' => [
            '5.1'       => true,
        ],
        'ircg_lusers' => [
            '5.1'       => true,
        ],
        'ircg_msg' => [
            '5.1'       => true,
        ],
        'ircg_names' => [
            '5.1'       => true,
        ],
        'ircg_nick' => [
            '5.1'       => true,
        ],
        'ircg_nickname_escape' => [
            '5.1'       => true,
        ],
        'ircg_nickname_unescape' => [
            '5.1'       => true,
        ],
        'ircg_notice' => [
            '5.1'       => true,
        ],
        'ircg_oper' => [
            '5.1'       => true,
        ],
        'ircg_part' => [
            '5.1'       => true,
        ],
        'ircg_pconnect' => [
            '5.1'       => true,
        ],
        'ircg_register_format_messages' => [
            '5.1'       => true,
        ],
        'ircg_set_current' => [
            '5.1'       => true,
        ],
        'ircg_set_file' => [
            '5.1'       => true,
        ],
        'ircg_set_on_die' => [
            '5.1'       => true,
        ],
        'ircg_topic' => [
            '5.1'       => true,
        ],
        'ircg_who' => [
            '5.1'       => true,
        ],
        'ircg_whois' => [
            '5.1'       => true,
        ],
        'dbx_close' => [
            '5.1'       => true,
        ],
        'dbx_compare' => [
            '5.1'       => true,
        ],
        'dbx_connect' => [
            '5.1'       => true,
        ],
        'dbx_error' => [
            '5.1'       => true,
        ],
        'dbx_escape_string' => [
            '5.1'       => true,
        ],
        'dbx_fetch_row' => [
            '5.1'       => true,
        ],
        'dbx_query' => [
            '5.1'       => true,
        ],
        'dbx_sort' => [
            '5.1'       => true,
        ],
        'ingres_autocommit' => [
            '5.1'       => true,
        ],
        'ingres_close' => [
            '5.1'       => true,
        ],
        'ingres_commit' => [
            '5.1'       => true,
        ],
        'ingres_connect' => [
            '5.1'       => true,
        ],
        'ingres_fetch_array' => [
            '5.1'       => true,
        ],
        'ingres_fetch_object' => [
            '5.1'       => true,
        ],
        'ingres_fetch_row' => [
            '5.1'       => true,
        ],
        'ingres_field_length' => [
            '5.1'       => true,
        ],
        'ingres_field_name' => [
            '5.1'       => true,
        ],
        'ingres_field_nullable' => [
            '5.1'       => true,
        ],
        'ingres_field_precision' => [
            '5.1'       => true,
        ],
        'ingres_field_scale' => [
            '5.1'       => true,
        ],
        'ingres_field_type' => [
            '5.1'       => true,
        ],
        'ingres_num_fields' => [
            '5.1'       => true,
        ],
        'ingres_num_rows' => [
            '5.1'       => true,
        ],
        'ingres_pconnect' => [
            '5.1'       => true,
        ],
        'ingres_query' => [
            '5.1'       => true,
        ],
        'ingres_rollback' => [
            '5.1'       => true,
        ],
        'ovrimos_close' => [
            '5.1'       => true,
        ],
        'ovrimos_commit' => [
            '5.1'       => true,
        ],
        'ovrimos_connect' => [
            '5.1'       => true,
        ],
        'ovrimos_cursor' => [
            '5.1'       => true,
        ],
        'ovrimos_exec' => [
            '5.1'       => true,
        ],
        'ovrimos_execute' => [
            '5.1'       => true,
        ],
        'ovrimos_fetch_into' => [
            '5.1'       => true,
        ],
        'ovrimos_fetch_row' => [
            '5.1'       => true,
        ],
        'ovrimos_field_len' => [
            '5.1'       => true,
        ],
        'ovrimos_field_name' => [
            '5.1'       => true,
        ],
        'ovrimos_field_num' => [
            '5.1'       => true,
        ],
        'ovrimos_field_type' => [
            '5.1'       => true,
        ],
        'ovrimos_free_result' => [
            '5.1'       => true,
        ],
        'ovrimos_longreadlen' => [
            '5.1'       => true,
        ],
        'ovrimos_num_fields' => [
            '5.1'       => true,
        ],
        'ovrimos_num_rows' => [
            '5.1'       => true,
        ],
        'ovrimos_prepare' => [
            '5.1'       => true,
        ],
        'ovrimos_result_all' => [
            '5.1'       => true,
        ],
        'ovrimos_result' => [
            '5.1'       => true,
        ],
        'ovrimos_rollback' => [
            '5.1'       => true,
        ],
        'ovrimos_close_all' => [
            '5.1'       => true,
        ],
        'ora_bind' => [
            '5.1'       => true,
        ],
        'ora_close' => [
            '5.1'       => true,
        ],
        'ora_columnname' => [
            '5.1'       => true,
        ],
        'ora_columnsize' => [
            '5.1'       => true,
        ],
        'ora_columntype' => [
            '5.1'       => true,
        ],
        'ora_commit' => [
            '5.1'       => true,
        ],
        'ora_commitoff' => [
            '5.1'       => true,
        ],
        'ora_commiton' => [
            '5.1'       => true,
        ],
        'ora_do' => [
            '5.1'       => true,
        ],
        'ora_error' => [
            '5.1'       => true,
        ],
        'ora_errorcode' => [
            '5.1'       => true,
        ],
        'ora_exec' => [
            '5.1'       => true,
        ],
        'ora_fetch_into' => [
            '5.1'       => true,
        ],
        'ora_fetch' => [
            '5.1'       => true,
        ],
        'ora_getcolumn' => [
            '5.1'       => true,
        ],
        'ora_logoff' => [
            '5.1'       => true,
        ],
        'ora_logon' => [
            '5.1'       => true,
        ],
        'ora_numcols' => [
            '5.1'       => true,
        ],
        'ora_numrows' => [
            '5.1'       => true,
        ],
        'ora_open' => [
            '5.1'       => true,
        ],
        'ora_parse' => [
            '5.1'       => true,
        ],
        'ora_plogon' => [
            '5.1'       => true,
        ],
        'ora_rollback' => [
            '5.1'       => true,
        ],
        'mysqli_embedded_connect' => [
            '5.1' => true,
        ],
        'mysqli_server_end' => [
            '5.1' => true,
        ],
        'mysqli_server_init' => [
            '5.1' => true,
        ],

        'msession_connect' => [
            '5.1.3'     => true,
        ],
        'msession_count' => [
            '5.1.3'     => true,
        ],
        'msession_create' => [
            '5.1.3'     => true,
        ],
        'msession_destroy' => [
            '5.1.3'     => true,
        ],
        'msession_disconnect' => [
            '5.1.3'     => true,
        ],
        'msession_find' => [
            '5.1.3'     => true,
        ],
        'msession_get_array' => [
            '5.1.3'     => true,
        ],
        'msession_get_data' => [
            '5.1.3'     => true,
        ],
        'msession_get' => [
            '5.1.3'     => true,
        ],
        'msession_inc' => [
            '5.1.3'     => true,
        ],
        'msession_list' => [
            '5.1.3'     => true,
        ],
        'msession_listvar' => [
            '5.1.3'     => true,
        ],
        'msession_lock' => [
            '5.1.3'     => true,
        ],
        'msession_plugin' => [
            '5.1.3'     => true,
        ],
        'msession_randstr' => [
            '5.1.3'     => true,
        ],
        'msession_set_array' => [
            '5.1.3'     => true,
        ],
        'msession_set_data' => [
            '5.1.3'     => true,
        ],
        'msession_set' => [
            '5.1.3'     => true,
        ],
        'msession_timeout' => [
            '5.1.3'     => true,
        ],
        'msession_uniq' => [
            '5.1.3'     => true,
        ],
        'msession_unlock' => [
            '5.1.3'     => true,
        ],

        'mysqli_resource' => [
            '5.1.4' => true,
        ],

        'mysql_createdb' => [
            '5.1.7'     => true,
        ],
        'mysql_dropdb' => [
            '5.1.7'     => true,
        ],
        'mysql_listtables' => [
            '5.1.7'     => true,
        ],

        'hwapi_attribute_new' => [
            '5.2'       => true,
        ],
        'hwapi_content_new' => [
            '5.2'       => true,
        ],
        'hwapi_hgcsp' => [
            '5.2'       => true,
        ],
        'hwapi_object_new' => [
            '5.2'       => true,
        ],
        'filepro_fieldcount' => [
            '5.2'       => true,
        ],
        'filepro_fieldname' => [
            '5.2'       => true,
        ],
        'filepro_fieldtype' => [
            '5.2'       => true,
        ],
        'filepro_fieldwidth' => [
            '5.2'       => true,
        ],
        'filepro_retrieve' => [
            '5.2'       => true,
        ],
        'filepro_rowcount' => [
            '5.2'       => true,
        ],
        'filepro' => [
            '5.2'       => true,
        ],

        'ifx_affected_rows' => [
            '5.2.1'     => true,
        ],
        'ifx_blobinfile_mode' => [
            '5.2.1'     => true,
        ],
        'ifx_byteasvarchar' => [
            '5.2.1'     => true,
        ],
        'ifx_close' => [
            '5.2.1'     => true,
        ],
        'ifx_connect' => [
            '5.2.1'     => true,
        ],
        'ifx_copy_blob' => [
            '5.2.1'     => true,
        ],
        'ifx_create_blob' => [
            '5.2.1'     => true,
        ],
        'ifx_create_char' => [
            '5.2.1'     => true,
        ],
        'ifx_do' => [
            '5.2.1'     => true,
        ],
        'ifx_error' => [
            '5.2.1'     => true,
        ],
        'ifx_errormsg' => [
            '5.2.1'     => true,
        ],
        'ifx_fetch_row' => [
            '5.2.1'     => true,
        ],
        'ifx_fieldproperties' => [
            '5.2.1'     => true,
        ],
        'ifx_fieldtypes' => [
            '5.2.1'     => true,
        ],
        'ifx_free_blob' => [
            '5.2.1'     => true,
        ],
        'ifx_free_char' => [
            '5.2.1'     => true,
        ],
        'ifx_free_result' => [
            '5.2.1'     => true,
        ],
        'ifx_get_blob' => [
            '5.2.1'     => true,
        ],
        'ifx_get_char' => [
            '5.2.1'     => true,
        ],
        'ifx_getsqlca' => [
            '5.2.1'     => true,
        ],
        'ifx_htmltbl_result' => [
            '5.2.1'     => true,
        ],
        'ifx_nullformat' => [
            '5.2.1'     => true,
        ],
        'ifx_num_fields' => [
            '5.2.1'     => true,
        ],
        'ifx_num_rows' => [
            '5.2.1'     => true,
        ],
        'ifx_pconnect' => [
            '5.2.1'     => true,
        ],
        'ifx_prepare' => [
            '5.2.1'     => true,
        ],
        'ifx_query' => [
            '5.2.1'     => true,
        ],
        'ifx_textasvarchar' => [
            '5.2.1'     => true,
        ],
        'ifx_update_blob' => [
            '5.2.1'     => true,
        ],
        'ifx_update_char' => [
            '5.2.1'     => true,
        ],
        'ifxus_close_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_create_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_free_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_open_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_read_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_seek_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_tell_slob' => [
            '5.2.1'     => true,
        ],
        'ifxus_write_slob' => [
            '5.2.1'     => true,
        ],

        'ncurses_addch' => [
            '5.3'       => true,
        ],
        'ncurses_addchnstr' => [
            '5.3'       => true,
        ],
        'ncurses_addchstr' => [
            '5.3'       => true,
        ],
        'ncurses_addnstr' => [
            '5.3'       => true,
        ],
        'ncurses_addstr' => [
            '5.3'       => true,
        ],
        'ncurses_assume_default_colors' => [
            '5.3'       => true,
        ],
        'ncurses_attroff' => [
            '5.3'       => true,
        ],
        'ncurses_attron' => [
            '5.3'       => true,
        ],
        'ncurses_attrset' => [
            '5.3'       => true,
        ],
        'ncurses_baudrate' => [
            '5.3'       => true,
        ],
        'ncurses_beep' => [
            '5.3'       => true,
        ],
        'ncurses_bkgd' => [
            '5.3'       => true,
        ],
        'ncurses_bkgdset' => [
            '5.3'       => true,
        ],
        'ncurses_border' => [
            '5.3'       => true,
        ],
        'ncurses_bottom_panel' => [
            '5.3'       => true,
        ],
        'ncurses_can_change_color' => [
            '5.3'       => true,
        ],
        'ncurses_cbreak' => [
            '5.3'       => true,
        ],
        'ncurses_clear' => [
            '5.3'       => true,
        ],
        'ncurses_clrtobot' => [
            '5.3'       => true,
        ],
        'ncurses_clrtoeol' => [
            '5.3'       => true,
        ],
        'ncurses_color_content' => [
            '5.3'       => true,
        ],
        'ncurses_color_set' => [
            '5.3'       => true,
        ],
        'ncurses_curs_set' => [
            '5.3'       => true,
        ],
        'ncurses_def_prog_mode' => [
            '5.3'       => true,
        ],
        'ncurses_def_shell_mode' => [
            '5.3'       => true,
        ],
        'ncurses_define_key' => [
            '5.3'       => true,
        ],
        'ncurses_del_panel' => [
            '5.3'       => true,
        ],
        'ncurses_delay_output' => [
            '5.3'       => true,
        ],
        'ncurses_delch' => [
            '5.3'       => true,
        ],
        'ncurses_deleteln' => [
            '5.3'       => true,
        ],
        'ncurses_delwin' => [
            '5.3'       => true,
        ],
        'ncurses_doupdate' => [
            '5.3'       => true,
        ],
        'ncurses_echo' => [
            '5.3'       => true,
        ],
        'ncurses_echochar' => [
            '5.3'       => true,
        ],
        'ncurses_end' => [
            '5.3'       => true,
        ],
        'ncurses_erase' => [
            '5.3'       => true,
        ],
        'ncurses_erasechar' => [
            '5.3'       => true,
        ],
        'ncurses_filter' => [
            '5.3'       => true,
        ],
        'ncurses_flash' => [
            '5.3'       => true,
        ],
        'ncurses_flushinp' => [
            '5.3'       => true,
        ],
        'ncurses_getch' => [
            '5.3'       => true,
        ],
        'ncurses_getmaxyx' => [
            '5.3'       => true,
        ],
        'ncurses_getmouse' => [
            '5.3'       => true,
        ],
        'ncurses_getyx' => [
            '5.3'       => true,
        ],
        'ncurses_halfdelay' => [
            '5.3'       => true,
        ],
        'ncurses_has_colors' => [
            '5.3'       => true,
        ],
        'ncurses_has_ic' => [
            '5.3'       => true,
        ],
        'ncurses_has_il' => [
            '5.3'       => true,
        ],
        'ncurses_has_key' => [
            '5.3'       => true,
        ],
        'ncurses_hide_panel' => [
            '5.3'       => true,
        ],
        'ncurses_hline' => [
            '5.3'       => true,
        ],
        'ncurses_inch' => [
            '5.3'       => true,
        ],
        'ncurses_init_color' => [
            '5.3'       => true,
        ],
        'ncurses_init_pair' => [
            '5.3'       => true,
        ],
        'ncurses_init' => [
            '5.3'       => true,
        ],
        'ncurses_insch' => [
            '5.3'       => true,
        ],
        'ncurses_insdelln' => [
            '5.3'       => true,
        ],
        'ncurses_insertln' => [
            '5.3'       => true,
        ],
        'ncurses_insstr' => [
            '5.3'       => true,
        ],
        'ncurses_instr' => [
            '5.3'       => true,
        ],
        'ncurses_isendwin' => [
            '5.3'       => true,
        ],
        'ncurses_keyok' => [
            '5.3'       => true,
        ],
        'ncurses_keypad' => [
            '5.3'       => true,
        ],
        'ncurses_killchar' => [
            '5.3'       => true,
        ],
        'ncurses_longname' => [
            '5.3'       => true,
        ],
        'ncurses_meta' => [
            '5.3'       => true,
        ],
        'ncurses_mouse_trafo' => [
            '5.3'       => true,
        ],
        'ncurses_mouseinterval' => [
            '5.3'       => true,
        ],
        'ncurses_mousemask' => [
            '5.3'       => true,
        ],
        'ncurses_move_panel' => [
            '5.3'       => true,
        ],
        'ncurses_move' => [
            '5.3'       => true,
        ],
        'ncurses_mvaddch' => [
            '5.3'       => true,
        ],
        'ncurses_mvaddchnstr' => [
            '5.3'       => true,
        ],
        'ncurses_mvaddchstr' => [
            '5.3'       => true,
        ],
        'ncurses_mvaddnstr' => [
            '5.3'       => true,
        ],
        'ncurses_mvaddstr' => [
            '5.3'       => true,
        ],
        'ncurses_mvcur' => [
            '5.3'       => true,
        ],
        'ncurses_mvdelch' => [
            '5.3'       => true,
        ],
        'ncurses_mvgetch' => [
            '5.3'       => true,
        ],
        'ncurses_mvhline' => [
            '5.3'       => true,
        ],
        'ncurses_mvinch' => [
            '5.3'       => true,
        ],
        'ncurses_mvvline' => [
            '5.3'       => true,
        ],
        'ncurses_mvwaddstr' => [
            '5.3'       => true,
        ],
        'ncurses_napms' => [
            '5.3'       => true,
        ],
        'ncurses_new_panel' => [
            '5.3'       => true,
        ],
        'ncurses_newpad' => [
            '5.3'       => true,
        ],
        'ncurses_newwin' => [
            '5.3'       => true,
        ],
        'ncurses_nl' => [
            '5.3'       => true,
        ],
        'ncurses_nocbreak' => [
            '5.3'       => true,
        ],
        'ncurses_noecho' => [
            '5.3'       => true,
        ],
        'ncurses_nonl' => [
            '5.3'       => true,
        ],
        'ncurses_noqiflush' => [
            '5.3'       => true,
        ],
        'ncurses_noraw' => [
            '5.3'       => true,
        ],
        'ncurses_pair_content' => [
            '5.3'       => true,
        ],
        'ncurses_panel_above' => [
            '5.3'       => true,
        ],
        'ncurses_panel_below' => [
            '5.3'       => true,
        ],
        'ncurses_panel_window' => [
            '5.3'       => true,
        ],
        'ncurses_pnoutrefresh' => [
            '5.3'       => true,
        ],
        'ncurses_prefresh' => [
            '5.3'       => true,
        ],
        'ncurses_putp' => [
            '5.3'       => true,
        ],
        'ncurses_qiflush' => [
            '5.3'       => true,
        ],
        'ncurses_raw' => [
            '5.3'       => true,
        ],
        'ncurses_refresh' => [
            '5.3'       => true,
        ],
        'ncurses_replace_panel' => [
            '5.3'       => true,
        ],
        'ncurses_reset_prog_mode' => [
            '5.3'       => true,
        ],
        'ncurses_reset_shell_mode' => [
            '5.3'       => true,
        ],
        'ncurses_resetty' => [
            '5.3'       => true,
        ],
        'ncurses_savetty' => [
            '5.3'       => true,
        ],
        'ncurses_scr_dump' => [
            '5.3'       => true,
        ],
        'ncurses_scr_init' => [
            '5.3'       => true,
        ],
        'ncurses_scr_restore' => [
            '5.3'       => true,
        ],
        'ncurses_scr_set' => [
            '5.3'       => true,
        ],
        'ncurses_scrl' => [
            '5.3'       => true,
        ],
        'ncurses_show_panel' => [
            '5.3'       => true,
        ],
        'ncurses_slk_attr' => [
            '5.3'       => true,
        ],
        'ncurses_slk_attroff' => [
            '5.3'       => true,
        ],
        'ncurses_slk_attron' => [
            '5.3'       => true,
        ],
        'ncurses_slk_attrset' => [
            '5.3'       => true,
        ],
        'ncurses_slk_clear' => [
            '5.3'       => true,
        ],
        'ncurses_slk_color' => [
            '5.3'       => true,
        ],
        'ncurses_slk_init' => [
            '5.3'       => true,
        ],
        'ncurses_slk_noutrefresh' => [
            '5.3'       => true,
        ],
        'ncurses_slk_refresh' => [
            '5.3'       => true,
        ],
        'ncurses_slk_restore' => [
            '5.3'       => true,
        ],
        'ncurses_slk_set' => [
            '5.3'       => true,
        ],
        'ncurses_slk_touch' => [
            '5.3'       => true,
        ],
        'ncurses_standend' => [
            '5.3'       => true,
        ],
        'ncurses_standout' => [
            '5.3'       => true,
        ],
        'ncurses_start_color' => [
            '5.3'       => true,
        ],
        'ncurses_termattrs' => [
            '5.3'       => true,
        ],
        'ncurses_termname' => [
            '5.3'       => true,
        ],
        'ncurses_timeout' => [
            '5.3'       => true,
        ],
        'ncurses_top_panel' => [
            '5.3'       => true,
        ],
        'ncurses_typeahead' => [
            '5.3'       => true,
        ],
        'ncurses_ungetch' => [
            '5.3'       => true,
        ],
        'ncurses_ungetmouse' => [
            '5.3'       => true,
        ],
        'ncurses_update_panels' => [
            '5.3'       => true,
        ],
        'ncurses_use_default_colors' => [
            '5.3'       => true,
        ],
        'ncurses_use_env' => [
            '5.3'       => true,
        ],
        'ncurses_use_extended_names' => [
            '5.3'       => true,
        ],
        'ncurses_vidattr' => [
            '5.3'       => true,
        ],
        'ncurses_vline' => [
            '5.3'       => true,
        ],
        'ncurses_waddch' => [
            '5.3'       => true,
        ],
        'ncurses_waddstr' => [
            '5.3'       => true,
        ],
        'ncurses_wattroff' => [
            '5.3'       => true,
        ],
        'ncurses_wattron' => [
            '5.3'       => true,
        ],
        'ncurses_wattrset' => [
            '5.3'       => true,
        ],
        'ncurses_wborder' => [
            '5.3'       => true,
        ],
        'ncurses_wclear' => [
            '5.3'       => true,
        ],
        'ncurses_wcolor_set' => [
            '5.3'       => true,
        ],
        'ncurses_werase' => [
            '5.3'       => true,
        ],
        'ncurses_wgetch' => [
            '5.3'       => true,
        ],
        'ncurses_whline' => [
            '5.3'       => true,
        ],
        'ncurses_wmouse_trafo' => [
            '5.3'       => true,
        ],
        'ncurses_wmove' => [
            '5.3'       => true,
        ],
        'ncurses_wnoutrefresh' => [
            '5.3'       => true,
        ],
        'ncurses_wrefresh' => [
            '5.3'       => true,
        ],
        'ncurses_wstandend' => [
            '5.3'       => true,
        ],
        'ncurses_wstandout' => [
            '5.3'       => true,
        ],
        'ncurses_wvline' => [
            '5.3'       => true,
        ],
        'fdf_add_doc_javascript' => [
            '5.3'       => true,
        ],
        'fdf_add_template' => [
            '5.3'       => true,
        ],
        'fdf_close' => [
            '5.3'       => true,
        ],
        'fdf_create' => [
            '5.3'       => true,
        ],
        'fdf_enum_values' => [
            '5.3'       => true,
        ],
        'fdf_errno' => [
            '5.3'       => true,
        ],
        'fdf_error' => [
            '5.3'       => true,
        ],
        'fdf_get_ap' => [
            '5.3'       => true,
        ],
        'fdf_get_attachment' => [
            '5.3'       => true,
        ],
        'fdf_get_encoding' => [
            '5.3'       => true,
        ],
        'fdf_get_file' => [
            '5.3'       => true,
        ],
        'fdf_get_flags' => [
            '5.3'       => true,
        ],
        'fdf_get_opt' => [
            '5.3'       => true,
        ],
        'fdf_get_status' => [
            '5.3'       => true,
        ],
        'fdf_get_value' => [
            '5.3'       => true,
        ],
        'fdf_get_version' => [
            '5.3'       => true,
        ],
        'fdf_header' => [
            '5.3'       => true,
        ],
        'fdf_next_field_name' => [
            '5.3'       => true,
        ],
        'fdf_open_string' => [
            '5.3'       => true,
        ],
        'fdf_open' => [
            '5.3'       => true,
        ],
        'fdf_remove_item' => [
            '5.3'       => true,
        ],
        'fdf_save_string' => [
            '5.3'       => true,
        ],
        'fdf_save' => [
            '5.3'       => true,
        ],
        'fdf_set_ap' => [
            '5.3'       => true,
        ],
        'fdf_set_encoding' => [
            '5.3'       => true,
        ],
        'fdf_set_file' => [
            '5.3'       => true,
        ],
        'fdf_set_flags' => [
            '5.3'       => true,
        ],
        'fdf_set_javascript_action' => [
            '5.3'       => true,
        ],
        'fdf_set_on_import_javascript' => [
            '5.3'       => true,
        ],
        'fdf_set_opt' => [
            '5.3'       => true,
        ],
        'fdf_set_status' => [
            '5.3'       => true,
        ],
        'fdf_set_submit_form_action' => [
            '5.3'       => true,
        ],
        'fdf_set_target_frame' => [
            '5.3'       => true,
        ],
        'fdf_set_value' => [
            '5.3'       => true,
        ],
        'fdf_set_version' => [
            '5.3'       => true,
        ],
        'ming_keypress' => [
            '5.3'       => true,
        ],
        'ming_setcubicthreshold' => [
            '5.3'       => true,
        ],
        'ming_setscale' => [
            '5.3'       => true,
        ],
        'ming_setswfcompression' => [
            '5.3'       => true,
        ],
        'ming_useconstants' => [
            '5.3'       => true,
        ],
        'ming_useswfversion' => [
            '5.3'       => true,
        ],
        'dbase_add_record' => [
            '5.3'       => true,
        ],
        'dbase_close' => [
            '5.3'       => true,
        ],
        'dbase_create' => [
            '5.3'       => true,
        ],
        'dbase_delete_record' => [
            '5.3'       => true,
        ],
        'dbase_get_header_info' => [
            '5.3'       => true,
        ],
        'dbase_get_record_with_names' => [
            '5.3'       => true,
        ],
        'dbase_get_record' => [
            '5.3'       => true,
        ],
        'dbase_numfields' => [
            '5.3'       => true,
        ],
        'dbase_numrecords' => [
            '5.3'       => true,
        ],
        'dbase_open' => [
            '5.3'       => true,
        ],
        'dbase_pack' => [
            '5.3'       => true,
        ],
        'dbase_replace_record' => [
            '5.3'       => true,
        ],
        'fbsql_affected_rows' => [
            '5.3'       => true,
        ],
        'fbsql_autocommit' => [
            '5.3'       => true,
        ],
        'fbsql_blob_size' => [
            '5.3'       => true,
        ],
        'fbsql_change_user' => [
            '5.3'       => true,
        ],
        'fbsql_clob_size' => [
            '5.3'       => true,
        ],
        'fbsql_close' => [
            '5.3'       => true,
        ],
        'fbsql_commit' => [
            '5.3'       => true,
        ],
        'fbsql_connect' => [
            '5.3'       => true,
        ],
        'fbsql_create_blob' => [
            '5.3'       => true,
        ],
        'fbsql_create_clob' => [
            '5.3'       => true,
        ],
        'fbsql_create_db' => [
            '5.3'       => true,
        ],
        'fbsql_data_seek' => [
            '5.3'       => true,
        ],
        'fbsql_database_password' => [
            '5.3'       => true,
        ],
        'fbsql_database' => [
            '5.3'       => true,
        ],
        'fbsql_db_query' => [
            '5.3'       => true,
        ],
        'fbsql_db_status' => [
            '5.3'       => true,
        ],
        'fbsql_drop_db' => [
            '5.3'       => true,
        ],
        'fbsql_errno' => [
            '5.3'       => true,
        ],
        'fbsql_error' => [
            '5.3'       => true,
        ],
        'fbsql_fetch_array' => [
            '5.3'       => true,
        ],
        'fbsql_fetch_assoc' => [
            '5.3'       => true,
        ],
        'fbsql_fetch_field' => [
            '5.3'       => true,
        ],
        'fbsql_fetch_lengths' => [
            '5.3'       => true,
        ],
        'fbsql_fetch_object' => [
            '5.3'       => true,
        ],
        'fbsql_fetch_row' => [
            '5.3'       => true,
        ],
        'fbsql_field_flags' => [
            '5.3'       => true,
        ],
        'fbsql_field_len' => [
            '5.3'       => true,
        ],
        'fbsql_field_name' => [
            '5.3'       => true,
        ],
        'fbsql_field_seek' => [
            '5.3'       => true,
        ],
        'fbsql_field_table' => [
            '5.3'       => true,
        ],
        'fbsql_field_type' => [
            '5.3'       => true,
        ],
        'fbsql_free_result' => [
            '5.3'       => true,
        ],
        'fbsql_get_autostart_info' => [
            '5.3'       => true,
        ],
        'fbsql_hostname' => [
            '5.3'       => true,
        ],
        'fbsql_insert_id' => [
            '5.3'       => true,
        ],
        'fbsql_list_dbs' => [
            '5.3'       => true,
        ],
        'fbsql_list_fields' => [
            '5.3'       => true,
        ],
        'fbsql_list_tables' => [
            '5.3'       => true,
        ],
        'fbsql_next_result' => [
            '5.3'       => true,
        ],
        'fbsql_num_fields' => [
            '5.3'       => true,
        ],
        'fbsql_num_rows' => [
            '5.3'       => true,
        ],
        'fbsql_password' => [
            '5.3'       => true,
        ],
        'fbsql_pconnect' => [
            '5.3'       => true,
        ],
        'fbsql_query' => [
            '5.3'       => true,
        ],
        'fbsql_read_blob' => [
            '5.3'       => true,
        ],
        'fbsql_read_clob' => [
            '5.3'       => true,
        ],
        'fbsql_result' => [
            '5.3'       => true,
        ],
        'fbsql_rollback' => [
            '5.3'       => true,
        ],
        'fbsql_rows_fetched' => [
            '5.3'       => true,
        ],
        'fbsql_select_db' => [
            '5.3'       => true,
        ],
        'fbsql_set_characterset' => [
            '5.3'       => true,
        ],
        'fbsql_set_lob_mode' => [
            '5.3'       => true,
        ],
        'fbsql_set_password' => [
            '5.3'       => true,
        ],
        'fbsql_set_transaction' => [
            '5.3'       => true,
        ],
        'fbsql_start_db' => [
            '5.3'       => true,
        ],
        'fbsql_stop_db' => [
            '5.3'       => true,
        ],
        'fbsql_table_name' => [
            '5.3'       => true,
        ],
        'fbsql_tablename' => [
            '5.3'       => true,
        ],
        'fbsql_username' => [
            '5.3'       => true,
        ],
        'fbsql_warnings' => [
            '5.3'       => true,
        ],
        'msql_affected_rows' => [
            '5.3'       => true,
        ],
        'msql_close' => [
            '5.3'       => true,
        ],
        'msql_connect' => [
            '5.3'       => true,
        ],
        'msql_create_db' => [
            '5.3'       => true,
        ],
        'msql_createdb' => [
            '5.3'       => true,
        ],
        'msql_data_seek' => [
            '5.3'       => true,
        ],
        'msql_db_query' => [
            '5.3'       => true,
        ],
        'msql_dbname' => [
            '5.3'       => true,
        ],
        'msql_drop_db' => [
            '5.3'       => true,
        ],
        'msql_error' => [
            '5.3'       => true,
        ],
        'msql_fetch_array' => [
            '5.3'       => true,
        ],
        'msql_fetch_field' => [
            '5.3'       => true,
        ],
        'msql_fetch_object' => [
            '5.3'       => true,
        ],
        'msql_fetch_row' => [
            '5.3'       => true,
        ],
        'msql_field_flags' => [
            '5.3'       => true,
        ],
        'msql_field_len' => [
            '5.3'       => true,
        ],
        'msql_field_name' => [
            '5.3'       => true,
        ],
        'msql_field_seek' => [
            '5.3'       => true,
        ],
        'msql_field_table' => [
            '5.3'       => true,
        ],
        'msql_field_type' => [
            '5.3'       => true,
        ],
        'msql_fieldflags' => [
            '5.3'       => true,
        ],
        'msql_fieldlen' => [
            '5.3'       => true,
        ],
        'msql_fieldname' => [
            '5.3'       => true,
        ],
        'msql_fieldtable' => [
            '5.3'       => true,
        ],
        'msql_fieldtype' => [
            '5.3'       => true,
        ],
        'msql_free_result' => [
            '5.3'       => true,
        ],
        'msql_list_dbs' => [
            '5.3'       => true,
        ],
        'msql_list_fields' => [
            '5.3'       => true,
        ],
        'msql_list_tables' => [
            '5.3'       => true,
        ],
        'msql_num_fields' => [
            '5.3'       => true,
        ],
        'msql_num_rows' => [
            '5.3'       => true,
        ],
        'msql_numfields' => [
            '5.3'       => true,
        ],
        'msql_numrows' => [
            '5.3'       => true,
        ],
        'msql_pconnect' => [
            '5.3'       => true,
        ],
        'msql_query' => [
            '5.3'       => true,
        ],
        'msql_regcase' => [
            '5.3'       => true,
        ],
        'msql_result' => [
            '5.3'       => true,
        ],
        'msql_select_db' => [
            '5.3'       => true,
        ],
        'msql_tablename' => [
            '5.3'       => true,
        ],
        'msql' => [
            '5.3'       => true,
        ],
        'mysqli_disable_reads_from_master' => [
            '5.3' => true,
        ],
        'mysqli_disable_rpl_parse' => [
            '5.3' => true,
        ],
        'mysqli_enable_reads_from_master' => [
            '5.3' => true,
        ],
        'mysqli_enable_rpl_parse' => [
            '5.3' => true,
        ],
        'mysqli_master_query' => [
            '5.3' => true,
        ],
        'mysqli_rpl_parse_enabled' => [
            '5.3' => true,
        ],
        'mysqli_rpl_probe' => [
            '5.3' => true,
        ],
        'mysqli_slave_query' => [
            '5.3' => true,
        ],

        'call_user_method' => [
            '4.1'         => false,
            '7.0'         => true,
            'alternative' => 'call_user_func()',
        ],
        'call_user_method_array' => [
            '4.1'         => false,
            '7.0'         => true,
            'alternative' => 'call_user_func_array()',
        ],
        'define_syslog_variables' => [
            '5.3' => false,
            '5.4' => true,
        ],
        'dl' => [
            '5.3' => false,
        ],
        'ereg' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'preg_match()',
        ],
        'ereg_replace' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'preg_replace()',
        ],
        'eregi' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'preg_match() (with the i modifier)',
        ],
        'eregi_replace' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'preg_replace() (with the i modifier)',
        ],
        'imagepsbbox' => [
            '7.0' => true,
        ],
        'imagepsencodefont' => [
            '7.0' => true,
        ],
        'imagepsextendfont' => [
            '7.0' => true,
        ],
        'imagepsfreefont' => [
            '7.0' => true,
        ],
        'imagepsloadfont' => [
            '7.0' => true,
        ],
        'imagepsslantfont' => [
            '7.0' => true,
        ],
        'imagepstext' => [
            '7.0' => true,
        ],
        'import_request_variables' => [
            '5.3' => false,
            '5.4' => true,
        ],
        'ldap_sort' => [
            '7.0' => false,
            '8.0' => true,
        ],
        'mcrypt_generic_end' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'mcrypt_generic_deinit()',
        ],
        'mysql_db_query' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'mysqli::select_db() and mysqli::query()',
        ],
        'mysql_escape_string' => [
            '4.3'         => false,
            '7.0'         => true,
            'alternative' => 'mysqli::real_escape_string()',
        ],
        'mysql_list_dbs' => [
            '5.4'       => false,
            '7.0'       => true,
        ],
        'mysql_list_fields' => [
            '5.4'       => false,
            '7.0'       => true,
        ],
        'mysqli_bind_param' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli_stmt::bind_param()',
        ],
        'mysqli_bind_result' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli_stmt::bind_result()',
        ],
        'mysqli_client_encoding' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli::character_set_name()',
        ],
        'mysqli_fetch' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli_stmt::fetch()',
        ],
        'mysqli_param_count' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli_stmt_param_count()',
        ],
        'mysqli_get_metadata' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli_stmt::result_metadata()',
        ],
        'mysqli_send_long_data' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => 'mysqli_stmt::send_long_data()',
        ],
        'magic_quotes_runtime' => [
            '5.3' => false,
            '7.0' => true,
        ],
        'session_register' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => '$_SESSION',
        ],
        'session_unregister' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => '$_SESSION',
        ],
        'session_is_registered' => [
            '5.3'         => false,
            '5.4'         => true,
            'alternative' => '$_SESSION',
        ],
        'set_magic_quotes_runtime' => [
            '5.3' => false,
            '7.0' => true,
        ],
        'set_socket_blocking' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'stream_set_blocking()',
        ],
        'split' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'preg_split(), explode() or str_split()',
        ],
        'spliti' => [
            '5.3'         => false,
            '7.0'         => true,
            'alternative' => 'preg_split() (with the i modifier)',
        ],
        'sql_regcase' => [
            '5.3'       => false,
            '7.0'       => true,
        ],
        'php_logo_guid' => [
            '5.5' => true,
        ],
        'php_egg_logo_guid' => [
            '5.5' => true,
        ],
        'php_real_logo_guid' => [
            '5.5' => true,
        ],
        'zend_logo_guid' => [
            '5.5'         => true,
            'alternative' => 'text string "PHPE9568F35-D428-11d2-A769-00AA001ACF42"',
        ],
        'datefmt_set_timezone_id' => [
            '5.5'         => false,
            '7.0'         => true,
            'alternative' => 'IntlDateFormatter::setTimeZone()',
        ],
        'mcrypt_ecb' => [
            '5.5'         => false,
            '7.0'         => true,
            'alternative' => 'mcrypt_decrypt()/mcrypt_encrypt()',
        ],
        'mcrypt_cbc' => [
            '5.5'         => false,
            '7.0'         => true,
            'alternative' => 'mcrypt_decrypt()/mcrypt_encrypt()',
        ],
        'mcrypt_cfb' => [
            '5.5'         => false,
            '7.0'         => true,
            'alternative' => 'mcrypt_decrypt()/mcrypt_encrypt()',
        ],
        'mcrypt_ofb' => [
            '5.5'         => false,
            '7.0'         => true,
            'alternative' => 'mcrypt_decrypt()/mcrypt_encrypt()',
        ],
        'ocibindbyname' => [
            '5.4'         => false,
            'alternative' => 'oci_bind_by_name()',
        ],
        'ocicancel' => [
            '5.4'         => false,
            'alternative' => 'oci_cancel()',
        ],
        'ocicloselob' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::close() / OCILob::close() (PHP 8+)',
        ],
        'ocicollappend' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::append() / OCICollection::append() (PHP 8+)',
        ],
        'ocicollassign' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::assign() / OCICollection::assign() (PHP 8+)',
        ],
        'ocicollassignelem' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::assignElem() / OCICollection::assignElem() (PHP 8+)',
        ],
        'ocicollgetelem' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::getElem() / OCICollection::getElem() (PHP 8+)',
        ],
        'ocicollmax' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::max() / OCICollection::max() (PHP 8+)',
        ],
        'ocicollsize' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::size() / OCICollection::size() (PHP 8+)',
        ],
        'ocicolltrim' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::trim() / OCICollection::trim() (PHP 8+)',
        ],
        'ocicolumnisnull' => [
            '5.4'         => false,
            'alternative' => 'oci_field_is_null()',
        ],
        'ocicolumnname' => [
            '5.4'         => false,
            'alternative' => 'oci_field_name()',
        ],
        'ocicolumnprecision' => [
            '5.4'         => false,
            'alternative' => 'oci_field_precision()',
        ],
        'ocicolumnscale' => [
            '5.4'         => false,
            'alternative' => 'oci_field_scale()',
        ],
        'ocicolumnsize' => [
            '5.4'         => false,
            'alternative' => 'oci_field_size()',
        ],
        'ocicolumntype' => [
            '5.4'         => false,
            'alternative' => 'oci_field_type()',
        ],
        'ocicolumntyperaw' => [
            '5.4'         => false,
            'alternative' => 'oci_field_type_raw()',
        ],
        'ocicommit' => [
            '5.4'         => false,
            'alternative' => 'oci_commit()',
        ],
        'ocidefinebyname' => [
            '5.4'         => false,
            'alternative' => 'oci_define_by_name()',
        ],
        'ocierror' => [
            '5.4'         => false,
            'alternative' => 'oci_error()',
        ],
        'ociexecute' => [
            '5.4'         => false,
            'alternative' => 'oci_execute()',
        ],
        'ocifetch' => [
            '5.4'         => false,
            'alternative' => 'oci_fetch()',
        ],
        'ocifetchinto' => [
            '5.4' => false,
        ],
        'ocifetchstatement' => [
            '5.4'         => false,
            'alternative' => 'oci_fetch_all()',
        ],
        'ocifreecollection' => [
            '5.4'         => false,
            'alternative' => 'OCI-Collection::free() / OCICollection::free() (PHP 8+)',
        ],
        'ocifreecursor' => [
            '5.4'         => false,
            'alternative' => 'oci_free_statement()',
        ],
        'ocifreedesc' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::free() / OCILob::free() (PHP 8+)',
        ],
        'ocifreestatement' => [
            '5.4'         => false,
            'alternative' => 'oci_free_statement()',
        ],
        'ociinternaldebug' => [
            '5.4'         => false,
            '8.0'         => true,
            'alternative' => 'oci_internal_debug() (PHP < 8.0)',
        ],
        'ociloadlob' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::load() / OCILob::load() (PHP 8+)',
        ],
        'ocilogoff' => [
            '5.4'         => false,
            'alternative' => 'oci_close()',
        ],
        'ocilogon' => [
            '5.4'         => false,
            'alternative' => 'oci_connect()',
        ],
        'ocinewcollection' => [
            '5.4'         => false,
            'alternative' => 'oci_new_collection()',
        ],
        'ocinewcursor' => [
            '5.4'         => false,
            'alternative' => 'oci_new_cursor()',
        ],
        'ocinewdescriptor' => [
            '5.4'         => false,
            'alternative' => 'oci_new_descriptor()',
        ],
        'ocinlogon' => [
            '5.4'         => false,
            'alternative' => 'oci_new_connect()',
        ],
        'ocinumcols' => [
            '5.4'         => false,
            'alternative' => 'oci_num_fields()',
        ],
        'ociparse' => [
            '5.4'         => false,
            'alternative' => 'oci_parse()',
        ],
        'ociplogon' => [
            '5.4'         => false,
            'alternative' => 'oci_pconnect()',
        ],
        'ociresult' => [
            '5.4'         => false,
            'alternative' => 'oci_result()',
        ],
        'ocirollback' => [
            '5.4'         => false,
            'alternative' => 'oci_rollback()',
        ],
        'ocirowcount' => [
            '5.4'         => false,
            'alternative' => 'oci_num_rows()',
        ],
        'ocisavelob' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::save() / OCILob::save() (PHP 8+)',
        ],
        'ocisavelobfile' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::import() / OCILob::import() (PHP 8+)',
        ],
        'ociserverversion' => [
            '5.4'         => false,
            'alternative' => 'oci_server_version()',
        ],
        'ocisetprefetch' => [
            '5.4'         => false,
            'alternative' => 'oci_set_prefetch()',
        ],
        'ocistatementtype' => [
            '5.4'         => false,
            'alternative' => 'oci_statement_type()',
        ],
        'ociwritelobtofile' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::export() / OCILob::export() (PHP 8+)',
        ],
        'ociwritetemporarylob' => [
            '5.4'         => false,
            'alternative' => 'OCI-Lob::writeTemporary() / OCILob::writeTemporary() (PHP 8+)',
        ],
        'mysqli_get_cache_stats' => [
            '5.4' => true,
        ],
        'sqlite_array_query' => [
            '5.4'       => true,
        ],
        'sqlite_busy_timeout' => [
            '5.4'       => true,
        ],
        'sqlite_changes' => [
            '5.4'       => true,
        ],
        'sqlite_close' => [
            '5.4'       => true,
        ],
        'sqlite_column' => [
            '5.4'       => true,
        ],
        'sqlite_create_aggregate' => [
            '5.4'       => true,
        ],
        'sqlite_create_function' => [
            '5.4'       => true,
        ],
        'sqlite_current' => [
            '5.4'       => true,
        ],
        'sqlite_error_string' => [
            '5.4'       => true,
        ],
        'sqlite_escape_string' => [
            '5.4'       => true,
        ],
        'sqlite_exec' => [
            '5.4'       => true,
        ],
        'sqlite_factory' => [
            '5.4'       => true,
        ],
        'sqlite_fetch_all' => [
            '5.4'       => true,
        ],
        'sqlite_fetch_array' => [
            '5.4'       => true,
        ],
        'sqlite_fetch_column_types' => [
            '5.4'       => true,
        ],
        'sqlite_fetch_object' => [
            '5.4'       => true,
        ],
        'sqlite_fetch_single' => [
            '5.4'       => true,
        ],
        'sqlite_fetch_string' => [
            '5.4'       => true,
        ],
        'sqlite_field_name' => [
            '5.4'       => true,
        ],
        'sqlite_has_more' => [
            '5.4'       => true,
        ],
        'sqlite_has_prev' => [
            '5.4'       => true,
        ],
        'sqlite_key' => [
            '5.4'       => true,
        ],
        'sqlite_last_error' => [
            '5.4'       => true,
        ],
        'sqlite_last_insert_rowid' => [
            '5.4'       => true,
        ],
        'sqlite_libencoding' => [
            '5.4'       => true,
        ],
        'sqlite_libversion' => [
            '5.4'       => true,
        ],
        'sqlite_next' => [
            '5.4'       => true,
        ],
        'sqlite_num_fields' => [
            '5.4'       => true,
        ],
        'sqlite_num_rows' => [
            '5.4'       => true,
        ],
        'sqlite_open' => [
            '5.4'       => true,
        ],
        'sqlite_popen' => [
            '5.4'       => true,
        ],
        'sqlite_prev' => [
            '5.4'       => true,
        ],
        'sqlite_query' => [
            '5.4'       => true,
        ],
        'sqlite_rewind' => [
            '5.4'       => true,
        ],
        'sqlite_seek' => [
            '5.4'       => true,
        ],
        'sqlite_single_query' => [
            '5.4'       => true,
        ],
        'sqlite_udf_decode_binary' => [
            '5.4'       => true,
        ],
        'sqlite_udf_encode_binary' => [
            '5.4'       => true,
        ],
        'sqlite_unbuffered_query' => [
            '5.4'       => true,
        ],
        'sqlite_valid' => [
            '5.4'       => true,
        ],

        'mssql_bind' => [
            '7.0'       => true,
        ],
        'mssql_close' => [
            '7.0'       => true,
        ],
        'mssql_connect' => [
            '7.0'       => true,
        ],
        'mssql_data_seek' => [
            '7.0'       => true,
        ],
        'mssql_execute' => [
            '7.0'       => true,
        ],
        'mssql_fetch_array' => [
            '7.0'       => true,
        ],
        'mssql_fetch_assoc' => [
            '7.0'       => true,
        ],
        'mssql_fetch_batch' => [
            '7.0'       => true,
        ],
        'mssql_fetch_field' => [
            '7.0'       => true,
        ],
        'mssql_fetch_object' => [
            '7.0'       => true,
        ],
        'mssql_fetch_row' => [
            '7.0'       => true,
        ],
        'mssql_field_length' => [
            '7.0'       => true,
        ],
        'mssql_field_name' => [
            '7.0'       => true,
        ],
        'mssql_field_seek' => [
            '7.0'       => true,
        ],
        'mssql_field_type' => [
            '7.0'       => true,
        ],
        'mssql_free_result' => [
            '7.0'       => true,
        ],
        'mssql_free_statement' => [
            '7.0'       => true,
        ],
        'mssql_get_last_message' => [
            '7.0'       => true,
        ],
        'mssql_guid_string' => [
            '7.0'       => true,
        ],
        'mssql_init' => [
            '7.0'       => true,
        ],
        'mssql_min_error_severity' => [
            '7.0'       => true,
        ],
        'mssql_min_message_severity' => [
            '7.0'       => true,
        ],
        'mssql_next_result' => [
            '7.0'       => true,
        ],
        'mssql_num_fields' => [
            '7.0'       => true,
        ],
        'mssql_num_rows' => [
            '7.0'       => true,
        ],
        'mssql_pconnect' => [
            '7.0'       => true,
        ],
        'mssql_query' => [
            '7.0'       => true,
        ],
        'mssql_result' => [
            '7.0'       => true,
        ],
        'mssql_rows_affected' => [
            '7.0'       => true,
        ],
        'mssql_select_db' => [
            '7.0'       => true,
        ],
        'mysql_affected_rows' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_client_encoding' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_close' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_connect' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_create_db' => [
            '4.3'       => false,
            '7.0'       => true,
        ],
        'mysql_data_seek' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_db_name' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_drop_db' => [
            '4.3'       => false,
            '7.0'       => true,
        ],
        'mysql_errno' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_error' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fetch_array' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fetch_assoc' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fetch_field' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fetch_lengths' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fetch_object' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fetch_row' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_field_flags' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_field_len' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_field_name' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_field_seek' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_field_table' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_field_type' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_free_result' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_get_client_info' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_get_host_info' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_get_proto_info' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_get_server_info' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_info' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_insert_id' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_list_processes' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_list_tables' => [
            '4.3.7'     => false,
            '7.0'       => true,
        ],
        'mysql_num_fields' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_num_rows' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_pconnect' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_ping' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_query' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_real_escape_string' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_result' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_select_db' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_set_charset' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_stat' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_tablename' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_thread_id' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_unbuffered_query' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fieldname' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fieldtable' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fieldlen' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fieldtype' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_fieldflags' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_selectdb' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_freeresult' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_numfields' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_numrows' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_listdbs' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_listfields' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_dbname' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'mysql_table_name' => [
            '5.5'       => false,
            '7.0'       => true,
        ],
        'sybase_affected_rows' => [
            '7.0'       => true,
        ],
        'sybase_close' => [
            '7.0'       => true,
        ],
        'sybase_connect' => [
            '7.0'       => true,
        ],
        'sybase_data_seek' => [
            '7.0'       => true,
        ],
        'sybase_deadlock_retry_count' => [
            '7.0'       => true,
        ],
        'sybase_fetch_array' => [
            '7.0'       => true,
        ],
        'sybase_fetch_assoc' => [
            '7.0'       => true,
        ],
        'sybase_fetch_field' => [
            '7.0'       => true,
        ],
        'sybase_fetch_object' => [
            '7.0'       => true,
        ],
        'sybase_fetch_row' => [
            '7.0'       => true,
        ],
        'sybase_field_seek' => [
            '7.0'       => true,
        ],
        'sybase_free_result' => [
            '7.0'       => true,
        ],
        'sybase_get_last_message' => [
            '7.0'       => true,
        ],
        'sybase_min_client_severity' => [
            '7.0'       => true,
        ],
        'sybase_min_error_severity' => [
            '7.0'       => true,
        ],
        'sybase_min_message_severity' => [
            '7.0'       => true,
        ],
        'sybase_min_server_severity' => [
            '7.0'       => true,
        ],
        'sybase_num_fields' => [
            '7.0'       => true,
        ],
        'sybase_num_rows' => [
            '7.0'       => true,
        ],
        'sybase_pconnect' => [
            '7.0'       => true,
        ],
        'sybase_query' => [
            '7.0'       => true,
        ],
        'sybase_result' => [
            '7.0'       => true,
        ],
        'sybase_select_db' => [
            '7.0'       => true,
        ],
        'sybase_set_message_handler' => [
            '7.0'       => true,
        ],
        'sybase_unbuffered_query' => [
            '7.0'       => true,
        ],

        'mcrypt_create_iv' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'random_bytes() or OpenSSL',
        ],
        'mcrypt_decrypt' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_get_algorithms_name' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_get_block_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_get_iv_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_get_key_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_get_modes_name' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_get_supported_key_sizes' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_is_block_algorithm_mode' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_is_block_algorithm' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_is_block_mode' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_enc_self_test' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_encrypt' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_generic_deinit' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_generic_init' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_generic' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_get_block_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_get_cipher_name' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_get_iv_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_get_key_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_list_algorithms' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_list_modes' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_close' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_get_algo_block_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_get_algo_key_size' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_get_supported_key_sizes' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_is_block_algorithm_mode' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_is_block_algorithm' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_is_block_mode' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_open' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mcrypt_module_self_test' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'mdecrypt_generic' => [
            '7.1'         => false,
            '7.2'         => true,
            'alternative' => 'OpenSSL',
        ],
        'jpeg2wbmp' => [
            '7.2'         => false,
            '8.0'         => true,
            'alternative' => 'imagecreatefromjpeg() and imagewbmp()',
        ],
        'png2wbmp' => [
            '7.2'         => false,
            '8.0'         => true,
            'alternative' => 'imagecreatefrompng() or imagewbmp()',
        ],
        '__autoload' => [
            '7.2'         => false,
            'alternative' => 'SPL autoload',
        ],
        'create_function' => [
            '7.2'         => false,
            '8.0'         => true,
            'alternative' => 'an anonymous function',
        ],
        'each' => [
            '7.2'         => false,
            '8.0'         => true,
            'alternative' => 'a foreach loop or ArrayIterator',
        ],
        'gmp_random' => [
            '7.2'         => false,
            '8.0'         => true,
            'alternative' => 'gmp_random_bits() or gmp_random_range()',
        ],
        'read_exif_data' => [
            '7.2'         => false,
            '8.0'         => true,
            'alternative' => 'exif_read_data()',
        ],

        'image2wbmp' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'imagewbmp()',
        ],
        'mbregex_encoding' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_regex_encoding()',
        ],
        'mbereg' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg()',
        ],
        'mberegi' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_eregi()',
        ],
        'mbereg_replace' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_replace()',
        ],
        'mberegi_replace' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_eregi_replace()',
        ],
        'mbsplit' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_split()',
        ],
        'mbereg_match' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_match()',
        ],
        'mbereg_search' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search()',
        ],
        'mbereg_search_pos' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search_pos()',
        ],
        'mbereg_search_regs' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search_regs()',
        ],
        'mbereg_search_init' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search_init()',
        ],
        'mbereg_search_getregs' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search_getregs()',
        ],
        'mbereg_search_getpos' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search_getpos()',
        ],
        'mbereg_search_setpos' => [
            '7.3'         => false,
            '8.0'         => true,
            'alternative' => 'mb_ereg_search_setpos()',
        ],
        'fgetss' => [
            '7.3' => false,
            '8.0' => true,
        ],
        'gzgetss' => [
            '7.3' => false,
            '8.0' => true,
        ],

        'convert_cyr_string' => [
            '7.4'         => false,
            '8.0'         => true,
            'alternative' => 'mb_convert_encoding(), iconv() or UConverter',
        ],
        'ezmlm_hash' => [
            '7.4' => false,
            '8.0' => true,
        ],
        'get_magic_quotes_gpc' => [
            '7.4' => false,
            '8.0' => true,
        ],
        'get_magic_quotes_runtime' => [
            '7.4' => false,
            '8.0' => true,
        ],
        'hebrevc' => [
            '7.4' => false,
            '8.0' => true,
        ],
        'is_real' => [
            '7.4'         => false,
            'alternative' => 'is_float()',
        ],
        'money_format' => [
            '7.4'         => false,
            '8.0'         => true,
            'alternative' => 'NumberFormatter::formatCurrency()',
        ],
        'restore_include_path' => [
            '7.4'         => false,
            '8.0'         => true,
            'alternative' => "ini_restore('include_path')",
        ],
        'ibase_add_user' => [
            '7.4'       => true,
        ],
        'ibase_affected_rows' => [
            '7.4'       => true,
        ],
        'ibase_backup' => [
            '7.4'       => true,
        ],
        'ibase_blob_add' => [
            '7.4'       => true,
        ],
        'ibase_blob_cancel' => [
            '7.4'       => true,
        ],
        'ibase_blob_close' => [
            '7.4'       => true,
        ],
        'ibase_blob_create' => [
            '7.4'       => true,
        ],
        'ibase_blob_echo' => [
            '7.4'       => true,
        ],
        'ibase_blob_get' => [
            '7.4'       => true,
        ],
        'ibase_blob_import' => [
            '7.4'       => true,
        ],
        'ibase_blob_info' => [
            '7.4'       => true,
        ],
        'ibase_blob_open' => [
            '7.4'       => true,
        ],
        'ibase_close' => [
            '7.4'       => true,
        ],
        'ibase_commit_ret' => [
            '7.4'       => true,
        ],
        'ibase_commit' => [
            '7.4'       => true,
        ],
        'ibase_connect' => [
            '7.4'       => true,
        ],
        'ibase_db_info' => [
            '7.4'       => true,
        ],
        'ibase_delete_user' => [
            '7.4'       => true,
        ],
        'ibase_drop_db' => [
            '7.4'       => true,
        ],
        'ibase_errcode' => [
            '7.4'       => true,
        ],
        'ibase_errmsg' => [
            '7.4'       => true,
        ],
        'ibase_execute' => [
            '7.4'       => true,
        ],
        'ibase_fetch_assoc' => [
            '7.4'       => true,
        ],
        'ibase_fetch_object' => [
            '7.4'       => true,
        ],
        'ibase_fetch_row' => [
            '7.4'       => true,
        ],
        'ibase_field_info' => [
            '7.4'       => true,
        ],
        'ibase_free_event_handler' => [
            '7.4'       => true,
        ],
        'ibase_free_query' => [
            '7.4'       => true,
        ],
        'ibase_free_result' => [
            '7.4'       => true,
        ],
        'ibase_gen_id' => [
            '7.4'       => true,
        ],
        'ibase_maintain_db' => [
            '7.4'       => true,
        ],
        'ibase_modify_user' => [
            '7.4'       => true,
        ],
        'ibase_name_result' => [
            '7.4'       => true,
        ],
        'ibase_num_fields' => [
            '7.4'       => true,
        ],
        'ibase_num_params' => [
            '7.4'       => true,
        ],
        'ibase_param_info' => [
            '7.4'       => true,
        ],
        'ibase_pconnect' => [
            '7.4'       => true,
        ],
        'ibase_prepare' => [
            '7.4'       => true,
        ],
        'ibase_query' => [
            '7.4'       => true,
        ],
        'ibase_restore' => [
            '7.4'       => true,
        ],
        'ibase_rollback_ret' => [
            '7.4'       => true,
        ],
        'ibase_rollback' => [
            '7.4'       => true,
        ],
        'ibase_server_info' => [
            '7.4'       => true,
        ],
        'ibase_service_attach' => [
            '7.4'       => true,
        ],
        'ibase_service_detach' => [
            '7.4'       => true,
        ],
        'ibase_set_event_handler' => [
            '7.4'       => true,
        ],
        'ibase_trans' => [
            '7.4'       => true,
        ],
        'ibase_wait_event' => [
            '7.4'       => true,
        ],
        'fbird_add_user' => [
            '7.4'       => true,
        ],
        'fbird_affected_rows' => [
            '7.4'       => true,
        ],
        'fbird_backup' => [
            '7.4'       => true,
        ],
        'fbird_blob_add' => [
            '7.4'       => true,
        ],
        'fbird_blob_cancel' => [
            '7.4'       => true,
        ],
        'fbird_blob_close' => [
            '7.4'       => true,
        ],
        'fbird_blob_create' => [
            '7.4'       => true,
        ],
        'fbird_blob_echo' => [
            '7.4'       => true,
        ],
        'fbird_blob_get' => [
            '7.4'       => true,
        ],
        'fbird_blob_import' => [
            '7.4'       => true,
        ],
        'fbird_blob_info' => [
            '7.4'       => true,
        ],
        'fbird_blob_open' => [
            '7.4'       => true,
        ],
        'fbird_close' => [
            '7.4'       => true,
        ],
        'fbird_commit_ret' => [
            '7.4'       => true,
        ],
        'fbird_commit' => [
            '7.4'       => true,
        ],
        'fbird_connect' => [
            '7.4'       => true,
        ],
        'fbird_db_info' => [
            '7.4'       => true,
        ],
        'fbird_delete_user' => [
            '7.4'       => true,
        ],
        'fbird_drop_db' => [
            '7.4'       => true,
        ],
        'fbird_errcode' => [
            '7.4'       => true,
        ],
        'fbird_errmsg' => [
            '7.4'       => true,
        ],
        'fbird_execute' => [
            '7.4'       => true,
        ],
        'fbird_fetch_assoc' => [
            '7.4'       => true,
        ],
        'fbird_fetch_object' => [
            '7.4'       => true,
        ],
        'fbird_fetch_row' => [
            '7.4'       => true,
        ],
        'fbird_field_info' => [
            '7.4'       => true,
        ],
        'fbird_free_event_handler' => [
            '7.4'       => true,
        ],
        'fbird_free_query' => [
            '7.4'       => true,
        ],
        'fbird_free_result' => [
            '7.4'       => true,
        ],
        'fbird_gen_id' => [
            '7.4'       => true,
        ],
        'fbird_maintain_db' => [
            '7.4'       => true,
        ],
        'fbird_modify_user' => [
            '7.4'       => true,
        ],
        'fbird_name_result' => [
            '7.4'       => true,
        ],
        'fbird_num_fields' => [
            '7.4'       => true,
        ],
        'fbird_num_params' => [
            '7.4'       => true,
        ],
        'fbird_param_info' => [
            '7.4'       => true,
        ],
        'fbird_pconnect' => [
            '7.4'       => true,
        ],
        'fbird_prepare' => [
            '7.4'       => true,
        ],
        'fbird_query' => [
            '7.4'       => true,
        ],
        'fbird_restore' => [
            '7.4'       => true,
        ],
        'fbird_rollback_ret' => [
            '7.4'       => true,
        ],
        'fbird_rollback' => [
            '7.4'       => true,
        ],
        'fbird_server_info' => [
            '7.4'       => true,
        ],
        'fbird_service_attach' => [
            '7.4'       => true,
        ],
        'fbird_service_detach' => [
            '7.4'       => true,
        ],
        'fbird_set_event_handler' => [
            '7.4'       => true,
        ],
        'fbird_trans' => [
            '7.4'       => true,
        ],
        'fbird_wait_event' => [
            '7.4'       => true,
        ],

        'ldap_control_paged_result_response' => [
            '7.4'         => false,
            '8.0'         => true,
            'alternative' => 'ldap_search()',
        ],
        'ldap_control_paged_result' => [
            '7.4'         => false,
            '8.0'         => true,
            'alternative' => 'ldap_search()',
        ],
        'recode_file' => [
            '7.4'         => true,
            'alternative' => 'the iconv or mbstring extension',
        ],
        'recode_string' => [
            '7.4'         => true,
            'alternative' => 'the iconv or mbstring extension',
        ],
        'recode' => [
            '7.4'         => true,
            'alternative' => 'the iconv or mbstring extension',
        ],
        'wddx_add_vars' => [
            '7.4'       => true,
        ],
        'wddx_deserialize' => [
            '7.4'       => true,
        ],
        'wddx_packet_end' => [
            '7.4'       => true,
        ],
        'wddx_packet_start' => [
            '7.4'       => true,
        ],
        'wddx_serialize_value' => [
            '7.4'       => true,
        ],
        'wddx_serialize_vars' => [
            '7.4'       => true,
        ],
        'mysqli_embedded_server_end' => [
            '7.4' => true,
        ],
        'mysqli_embedded_server_start' => [
            '7.4' => true,
        ],

        'enchant_broker_get_dict_path' => [
            '8.0' => false,
        ],
        'enchant_broker_set_dict_path' => [
            '8.0' => false,
        ],
        'enchant_broker_free' => [
            '8.0'         => false,
            'alternative' => 'unset the object',
        ],
        'enchant_broker_free_dict' => [
            '8.0'         => false,
            'alternative' => 'unset the object',
        ],
        'enchant_dict_add_to_personal' => [
            '8.0'         => false,
            'alternative' => 'enchant_dict_add()',
        ],
        'enchant_dict_is_in_session' => [
            '8.0'         => false,
            'alternative' => 'enchant_dict_is_added()',
        ],
        'imap_header' => [
            '8.0'         => true,
            'alternative' => 'imap_headerinfo()',
        ],
        'libxml_disable_entity_loader' => [
            '8.0' => false,
        ],
        'oci_internal_debug' => [
            '8.0' => true,
        ],
        'openssl_x509_free' => [
            '8.0' => false,
        ],
        'openssl_pkey_free' => [
            '8.0' => false,
        ],
        'openssl_free_key' => [
            '8.0' => false,
        ],
        'pg_clientencoding' => [
            '8.0'         => false,
            'alternative' => 'pg_client_encoding()',
        ],
        'pg_cmdtuples' => [
            '8.0'         => false,
            'alternative' => 'pg_affected_rows()',
        ],
        'pg_errormessage' => [
            '8.0'         => false,
            'alternative' => 'pg_last_error()',
        ],
        'pg_fieldname' => [
            '8.0'         => false,
            'alternative' => 'pg_field_name()',
        ],
        'pg_fieldnum' => [
            '8.0'         => false,
            'alternative' => 'pg_field_num()',
        ],
        'pg_fieldisnull' => [
            '8.0'         => false,
            'alternative' => 'pg_field_is_null()',
        ],
        'pg_fieldprtlen' => [
            '8.0'         => false,
            'alternative' => 'pg_field_prtlen()',
        ],
        'pg_fieldsize' => [
            '8.0'         => false,
            'alternative' => 'pg_field_size()',
        ],
        'pg_fieldtype' => [
            '8.0'         => false,
            'alternative' => 'pg_field_type()',
        ],
        'pg_freeresult' => [
            '8.0'         => false,
            'alternative' => 'pg_free_result()',
        ],
        'pg_getlastoid' => [
            '8.0'         => false,
            'alternative' => 'pg_last_oid()',
        ],
        'pg_loclose' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_close()',
        ],
        'pg_locreate' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_create()',
        ],
        'pg_loexport' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_export()',
        ],
        'pg_loimport' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_import()',
        ],
        'pg_loopen' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_open()',
        ],
        'pg_loread' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_read()',
        ],
        'pg_loreadall' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_read_all()',
        ],
        'pg_lounlink' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_unlink()',
        ],
        'pg_lowrite' => [
            '8.0'         => false,
            'alternative' => 'pg_lo_write()',
        ],
        'pg_numfields' => [
            '8.0'         => false,
            'alternative' => 'pg_num_fields()',
        ],
        'pg_numrows' => [
            '8.0'         => false,
            'alternative' => 'pg_num_rows()',
        ],
        'pg_result' => [
            '8.0'         => false,
            'alternative' => 'pg_fetch_result()',
        ],
        'pg_setclientencoding' => [
            '8.0'         => false,
            'alternative' => 'pg_set_client_encoding()',
        ],
        'shmop_close' => [
            '8.0' => false,
        ],
        'xmlrpc_decode_request' => [
            '8.0'       => true,
        ],
        'xmlrpc_decode' => [
            '8.0'       => true,
        ],
        'xmlrpc_encode_request' => [
            '8.0'       => true,
        ],
        'xmlrpc_encode' => [
            '8.0'       => true,
        ],
        'xmlrpc_get_type' => [
            '8.0'       => true,
        ],
        'xmlrpc_is_fault' => [
            '8.0'       => true,
        ],
        'xmlrpc_parse_method_descriptions' => [
            '8.0'       => true,
        ],
        'xmlrpc_server_add_introspection_data' => [
            '8.0'       => true,
        ],
        'xmlrpc_server_call_method' => [
            '8.0'       => true,
        ],
        'xmlrpc_server_create' => [
            '8.0'       => true,
        ],
        'xmlrpc_server_destroy' => [
            '8.0'       => true,
        ],
        'xmlrpc_server_register_introspection_callback' => [
            '8.0'       => true,
        ],
        'xmlrpc_server_register_method' => [
            '8.0'       => true,
        ],
        'xmlrpc_set_type' => [
            '8.0'       => true,
        ],
        'zip_close' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive::close()',
        ],
        'zip_entry_close' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_entry_compressedsize' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_entry_compressionmethod' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_entry_filesize' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_entry_name' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_entry_open' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_entry_read' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],
        'zip_open' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive::open()',
        ],
        'zip_read' => [
            '8.0'         => false,
            'alternative' => 'ZipArchive',
        ],

        'date_sunrise' => [
            '8.1'         => false,
            'alternative' => 'date_sun_info()',
        ],
        'date_sunset' => [
            '8.1'         => false,
            'alternative' => 'date_sun_info()',
        ],
        'strptime' => [
            '8.1'         => false,
            'alternative' => 'date_parse_from_format() or IntlDateFormatter::parse()',
        ],
        'strftime' => [
            '8.1'         => false,
            'alternative' => 'date() or IntlDateFormatter::format()',
        ],
        'gmstrftime' => [
            '8.1'         => false,
            'alternative' => 'date() or IntlDateFormatter::format()',
        ],
        'mhash_count' => [
            '8.1'         => false,
            'alternative' => 'the hash_*() functions',
        ],
        'mhash_get_block_size' => [
            '8.1'         => false,
            'alternative' => 'the hash_*() functions',
        ],
        'mhash_get_hash_name' => [
            '8.1'         => false,
            'alternative' => 'the hash_*() functions',
        ],
        'mhash_keygen_s2k' => [
            '8.1'         => false,
            'alternative' => 'the hash_*() functions',
        ],
        'mhash' => [
            '8.1'         => false,
            'alternative' => 'the hash_*() functions',
        ],
        'odbc_result_all' => [
            '8.1' => false,
        ],
        'utf8_encode' => [
            '8.2' => false,
            'alternative' => 'iconv()',
        ],
        'utf8_decode' => [
            '8.2' => false,
            'alternative' => 'iconv()',
        ],
    ];

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr !== false && !Assert::isBuiltinFunctionCall($phpcsFile, $stackPtr)) {
            return;
        }
        return parent::process($phpcsFile, $stackPtr);
    }
}
