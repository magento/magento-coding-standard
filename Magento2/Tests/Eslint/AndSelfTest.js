define([
    'jquery',
], function ($) {
    $(function () {
        'use strict';

        $('div').find('p').andSelf().addClass('border');
    });
});
