module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of the deprecated $.delegate and $.undelegate',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/delegate/'
        },
        schema: [],
        messages: {
            delegate: 'jQuery $.delegate and $.undelegate are deprecated, use $.on and $.off instead'
        }
    },

    /**
     * Executes the function to check if delegate and undelegate are used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if delegate and undelegate are used in the node and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                if (node.callee.type !== 'MemberExpression') {return;}

                if (!['delegate', 'undelegate'].includes(node.callee.property.name)) {return;}

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        messageId: 'delegate'
                    });
                }
            }
        };
    }
};
