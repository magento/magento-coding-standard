module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of the deprecated `trim` function',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/jQuery.trim/'
        },
        schema: [],
        messages: {
            trim: 'jQuery.trim is deprecated; use String.prototype.trim'
        }
    },

    /**
     * Executes the function to check if trim method is used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if trim method is used and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                if (node.callee.type !== 'MemberExpression') {return;}

                if (node.callee.property.name !== 'trim') {return;}

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        messageId: 'trim'
                    });
                }
            }
        };
    }
};
