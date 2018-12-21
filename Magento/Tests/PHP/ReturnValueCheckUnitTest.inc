<?php
$a = 'strpos("qwe","w");';

if (strpos($mystring, $findme)) {
    //
}

if (!strpos($mystring, $findme)) {
    //
}

if (((!strpos($mystring, $findme)))) {
    //
}

if (strpos($mystring, $findme) == false) {
    //
}

if (!strpos($mystring, $findme) != false) {
    //
}

if (((strpos($mystring, $findme))) != false) {
    //
}

if (((strpos($mystring, $findme))) !== false) {
    //
}

if (((strpos($mystring, $findme))) == false) {
    //
}

if (((strpos($mystring, $findme))) === false) {
    //
}

if (strpos($mystring, $findme) && $findme !== 'a') {
    //
}

if (strpos($mystring, $findme) || $findme === 'a') {
    //
}

if (strpos($mystring, $findme) === false) {
    //
}

if (strpos($mystring, $findme) !== false) {
    //
}

if (false === strpos($mystring, $findme)) {
    //
}

if (false !== strpos($mystring, $findme)) {
    //
}

if (false !== (((strpos($mystring, $findme))))) {
    //
}

if ($findme === 'a' && (false === strpos($mystring, $findme) || $findme !== 'b') && $mystring !== false) {
    //
}

if ($findme === 'a' && (strpos($mystring, $findme) || $findme !== 'b') && $mystring !== false) {
    //
}

if ($findme === 'a' && (((strpos($string, false !== ((strpos($mystring, $findme)))))) || $findme !== 'b')) {
    //
}

if ($findme === 'a' && (((strpos($string, false == ((strpos($mystring, $findme)))))) || $findme !== 'b')) {
    //
}

if ($findme === 'a' &&
    (((strpos($string,
            false == ((
            strpos($mystring, $findme))))))
        || $findme !== 'b')) {
    //
}

if (($column->getId() === 'store_id' || $column->getId() === 'status') && $column->getFilter()->getValue()
    && (strpos($column->getFilter()->getValue(), ',') !== false)) {
	//
}

if (($column->getId() === 'store_id' || $column->getId() === 'status') && $column->getFilter()->getValue()
    && (strpos($column->getFilter()->getValue(), ',') != false)) {
    //
}

if (array_search($needle, $haystack)) {
    //
}

if (((!array_search($needle, $haystack)))) {
    //
}

if (!array_search($needle, $haystack) != false) {
    //
}

if (((array_search($needle, $haystack))) !== false) {
    //
}
