// Import utils using ES module syntax
import utils from './utils.js';

export default {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of the deprecated $.bind and $.unbind',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/bind/',
        },
        schema: [],
        messages: {
            bind: 'jQuery $.bind and $.unbind are deprecated, use $.on and $.off instead',
        },
    },

    /**
     * Executes the function to check if bind and unbind are used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        return {
            /**
             * Checks if bind and unbind are used in the node and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                if (node.callee.type !== 'MemberExpression') { return; }

                if (!['bind', 'unbind'].includes(node.callee.property.name)) { return; }

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        messageId: 'bind',
                    });
                }
            },
        };
    },
};
