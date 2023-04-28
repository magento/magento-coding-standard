<?php
/*
 * Test: Usage of the QPrint, BASE64, UUENCODE, and HTML-ENTITIES "text encodings" is deprecated for all MBString functions
 */

### BASE64 ###
mb_check_encoding($str, "BASE64");
mb_chr(65, "BASE64");
mb_convert_case($str, MB_CASE_UPPER, "BASE64");
mb_convert_encoding($str, "BASE64");
mb_convert_kana($str, "KVa", "BASE64");
mb_convert_variables("BASE64", "ASCII,UTF-8,SJIS-win", $str1, $str2);
mb_decode_numericentity($str, $convmap, "BASE64");
mb_encode_numericentity($str, $convmap, "BASE64");
mb_ord($str, "BASE64");
mb_scrub($str, "BASE64");
mb_str_split($str, 1, "BASE64");
mb_strcut($str, 0, 1, "BASE64");
mb_strimwidth($str, 0, 5, "...", "BASE64");
mb_stripos($str, "s", 0, "BASE64");
mb_stristr($str, "s", true, "BASE64");
mb_strlen($str, "BASE64");
mb_strpos($str, "s", 0, "BASE64");
mb_strrchr($str, "s", true, "BASE64");
mb_strrichr($str, "s", true, "BASE64");
mb_strripos($str, "s", 0, "BASE64");
mb_strrpos($str, "s", 0, "BASE64");
mb_strstr($str, "s", true, "BASE64");
mb_strtolower($str, "BASE64");
mb_strtoupper($str, "BASE64");
mb_strwidth($str, "BASE64");
mb_substr_count($str, "s", "BASE64");
mb_substr($str, 0, 1, "BASE64");
### BASE64 ###
#### QPrint ###
mb_check_encoding($str, "QPrint");
mb_chr(65, "QPrint");
mb_convert_case($str, MB_CASE_UPPER, "QPrint");
mb_convert_encoding($str, "QPrint");
mb_convert_kana($str, "KVa", "QPrint");
mb_convert_variables("QPrint", "ASCII,UTF-8,SJIS-win", $str1, $str2);
mb_decode_numericentity($str, $convmap, "QPrint");
mb_encode_numericentity($str, $convmap, "QPrint");
mb_ord($str, "QPrint");
mb_scrub($str, "QPrint");
mb_str_split($str, 1, "QPrint");
mb_strcut($str, 0, 1, "QPrint");
mb_strimwidth($str, 0, 5, "...", "QPrint");
mb_stripos($str, "s", 0, "QPrint");
mb_stristr($str, "s", true, "QPrint");
mb_strlen($str, "QPrint");
mb_strpos($str, "s", 0, "QPrint");
mb_strrchr($str, "s", true, "QPrint");
mb_strrichr($str, "s", true, "QPrint");
mb_strripos($str, "s", 0, "QPrint");
mb_strrpos($str, "s", 0, "QPrint");
mb_strstr($str, "s", true, "QPrint");
mb_strtolower($str, "QPrint");
mb_strtoupper($str, "QPrint");
mb_strwidth($str, "QPrint");
mb_substr_count($str, "s", "QPrint");
mb_substr($str, 0, 1, "QPrint");
### QPrint ###
##### Quoted-Printable ###
mb_check_encoding($str, "Quoted-Printable");
mb_chr(65, "Quoted-Printable");
mb_convert_case($str, MB_CASE_UPPER, "Quoted-Printable");
mb_convert_encoding($str, "Quoted-Printable");
mb_convert_kana($str, "KVa", "Quoted-Printable");
mb_convert_variables("Quoted-Printable", "ASCII,UTF-8,SJIS-win", $str1, $str2);
mb_decode_numericentity($str, $convmap, "Quoted-Printable");
mb_encode_numericentity($str, $convmap, "Quoted-Printable");
mb_ord($str, "Quoted-Printable");
mb_scrub($str, "Quoted-Printable");
mb_str_split($str, 1, "Quoted-Printable");
mb_strcut($str, 0, 1, "Quoted-Printable");
mb_strimwidth($str, 0, 5, "...", "Quoted-Printable");
mb_stripos($str, "s", 0, "Quoted-Printable");
mb_stristr($str, "s", true, "Quoted-Printable");
mb_strlen($str, "Quoted-Printable");
mb_strpos($str, "s", 0, "Quoted-Printable");
mb_strrchr($str, "s", true, "Quoted-Printable");
mb_strrichr($str, "s", true, "Quoted-Printable");
mb_strripos($str, "s", 0, "Quoted-Printable");
mb_strrpos($str, "s", 0, "Quoted-Printable");
mb_strstr($str, "s", true, "Quoted-Printable");
mb_strtolower($str, "Quoted-Printable");
mb_strtoupper($str, "Quoted-Printable");
mb_strwidth($str, "Quoted-Printable");
mb_substr_count($str, "s", "Quoted-Printable");
mb_substr($str, 0, 1, "Quoted-Printable");
### Quoted-Printable ###
### UUENCODE ###
mb_check_encoding($str, "UUENCODE");
mb_chr(65, "UUENCODE");
mb_convert_case($str, MB_CASE_UPPER, "UUENCODE");
mb_convert_encoding($str, "UUENCODE");
mb_convert_kana($str, "KVa", "UUENCODE");
mb_convert_variables("UUENCODE", "ASCII,UTF-8,SJIS-win", $str1, $str2);
mb_decode_numericentity($str, $convmap, "UUENCODE");
mb_encode_numericentity($str, $convmap, "UUENCODE");
mb_ord($str, "UUENCODE");
mb_scrub($str, "UUENCODE");
mb_str_split($str, 1, "UUENCODE");
mb_strcut($str, 0, 1, "UUENCODE");
mb_strimwidth($str, 0, 5, "...", "UUENCODE");
mb_stripos($str, "s", 0, "UUENCODE");
mb_stristr($str, "s", true, "UUENCODE");
mb_strlen($str, "UUENCODE");
mb_strpos($str, "s", 0, "UUENCODE");
mb_strrchr($str, "s", true, "UUENCODE");
mb_strrichr($str, "s", true, "UUENCODE");
mb_strripos($str, "s", 0, "UUENCODE");
mb_strrpos($str, "s", 0, "UUENCODE");
mb_strstr($str, "s", true, "UUENCODE");
mb_strtolower($str, "UUENCODE");
mb_strtoupper($str, "UUENCODE");
mb_strwidth($str, "UUENCODE");
mb_substr_count($str, "s", "UUENCODE");
mb_substr($str, 0, 1, "UUENCODE");
### UUENCODE ###
#### HTML-ENTITIES ###
mb_check_encoding($str, "HTML-ENTITIES");
mb_chr(65, "HTML-ENTITIES");
mb_convert_case($str, MB_CASE_UPPER, "HTML-ENTITIES");
mb_convert_encoding($str, "HTML-ENTITIES");
mb_convert_kana($str, "KVa", "HTML-ENTITIES");
mb_convert_variables("HTML-ENTITIES", "ASCII,UTF-8,SJIS-win", $str1, $str2);
mb_decode_numericentity($str, $convmap, "HTML-ENTITIES");
mb_encode_numericentity($str, $convmap, "HTML-ENTITIES");
mb_ord($str, "HTML-ENTITIES");
mb_scrub($str, "HTML-ENTITIES");
mb_str_split($str, 1, "HTML-ENTITIES");
mb_strcut($str, 0, 1, "HTML-ENTITIES");
mb_strimwidth($str, 0, 5, "...", "HTML-ENTITIES");
mb_stripos($str, "s", 0, "HTML-ENTITIES");
mb_stristr($str, "s", true, "HTML-ENTITIES");
mb_strlen($str, "HTML-ENTITIES");
mb_strpos($str, "s", 0, "HTML-ENTITIES");
mb_strrchr($str, "s", true, "HTML-ENTITIES");
mb_strrichr($str, "s", true, "HTML-ENTITIES");
mb_strripos($str, "s", 0, "HTML-ENTITIES");
mb_strrpos($str, "s", 0, "HTML-ENTITIES");
mb_strstr($str, "s", true, "HTML-ENTITIES");
mb_strtolower($str, "HTML-ENTITIES");
mb_strtoupper($str, "HTML-ENTITIES");
mb_strwidth($str, "HTML-ENTITIES");
mb_substr_count($str, "s", "HTML-ENTITIES");
mb_substr($str, 0, 1, "HTML-ENTITIES");
### HTML-ENTITIES ###
##### HTML ###
mb_check_encoding($str, "HTML");
mb_chr(65, "HTML");
mb_convert_case($str, MB_CASE_UPPER, "HTML");
mb_convert_encoding($str, "HTML");
mb_convert_kana($str, "KVa", "HTML");
mb_convert_variables("HTML", "ASCII,UTF-8,SJIS-win", $str1, $str2);
mb_decode_numericentity($str, $convmap, "HTML");
mb_encode_numericentity($str, $convmap, "HTML");
mb_ord($str, "HTML");
mb_scrub($str, "HTML");
mb_str_split($str, 1, "HTML");
mb_strcut($str, 0, 1, "HTML");
mb_strimwidth($str, 0, 5, "...", "HTML");
mb_stripos($str, "s", 0, "HTML");
mb_stristr($str, "s", true, "HTML");
mb_strlen($str, "HTML");
mb_strpos($str, "s", 0, "HTML");
mb_strrchr($str, "s", true, "HTML");
mb_strrichr($str, "s", true, "HTML");
mb_strripos($str, "s", 0, "HTML");
mb_strrpos($str, "s", 0, "HTML");
mb_strstr($str, "s", true, "HTML");
mb_strtolower($str, "HTML");
mb_strtoupper($str, "HTML");
mb_strwidth($str, "HTML");
mb_substr_count($str, "s", "HTML");
mb_substr($str, 0, 1, "HTML");
### HTML ###

// Ok
mb_convert_encoding($str, "SJIS");
mb_convert_encoding($str, "UTF-7", "EUC-JP");
mb_convert_encoding($str, "UCS-2LE", "JIS, eucjp-win, sjis-win");
mb_convert_encoding($str, "EUC-JP", "auto");
mb_convert_encoding($str, "UTF-8", "BASE64");
mb_convert_encoding($str, strtolower('BASE64'));
mb_detect_encoding($str, ['BASE64']);
