module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of the deprecated `andSelf` method',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/andself/'
        },
        schema: [],
        messages: {
            andSelf: 'jQuery.andSelf() removed, use jQuery.addBack()'
        }
    },

    /**
     * Executes the function to check if andSelf is used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if andSelf is used in the node and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                if (node.callee.type !== 'MemberExpression') {return;}

                if (node.callee.property.name !== 'andSelf') {return;}

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        messageId: 'andSelf'
                    });
                }
            }
        };
    }
};
