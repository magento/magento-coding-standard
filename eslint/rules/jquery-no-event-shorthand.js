module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of shorthand event methods',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/load/'
        },
        schema: []
    },

    /**
     * Executes the function to check if shorthand event methods are used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if shorthand event methods are used.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                var namesToMsg = {
                        'unload': 'jQuery.unload() was removed, use .on("unload", fn) instead.',
                        'ready': 'jQuery.ready(handler) is deprecated and should be replaced with jQuery(handler)'
                    },
                    name,
                    message;

                if (node.callee.type !== 'MemberExpression') {return;}

                name = node.callee.property.name;
                if (!namesToMsg.hasOwnProperty(name)) {return;}
                message = namesToMsg[name];

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        message: message
                    });
                }
            }
        };
    }
};
