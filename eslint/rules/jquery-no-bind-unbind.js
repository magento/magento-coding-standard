module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of the deprecated $.bind and $.unbind',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/bind/'
        },
        schema: [],
        messages: {
            bind: 'jQuery $.bind and $.unbind are deprecated, use $.on and $.off instead'
        }
    },

    /**
     * Executes the function to check if bind and unbind are used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if bind and unbind are used in the node and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                if (node.callee.type !== 'MemberExpression') {return;}

                if (!['bind', 'unbind'].includes(node.callee.property.name)) {return;}

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        messageId: 'bind'
                    });
                }
            }
        };
    }
};
