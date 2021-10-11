$(document).ready(function () {
    'use strict';

    $('table').delegate('td', 'click', function () {
        $(this).toggleClass('chosen');
    });
});
