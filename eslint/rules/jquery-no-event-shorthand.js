// Import utils using ES module syntax
import utils from './utils.js';

export default {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of shorthand event methods',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/load/',
        },
        schema: [],
    },

    /**
     * Executes the function to check if shorthand event methods are used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        return {
            /**
             * Checks if shorthand event methods are used.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                const namesToMsg = {
                    unload: 'jQuery.unload() was removed, use .on("unload", fn) instead.',
                    ready: 'jQuery.ready(handler) is deprecated and should be replaced with jQuery(handler)',
                };

                if (node.callee.type !== 'MemberExpression') { return; }

                const message = namesToMsg[node.callee.property.name];

                if (!message) { return; }

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        message: message,
                    });
                }
            },
        };
    },
};
