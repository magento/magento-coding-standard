// Import utils using ES module syntax
import utils from './utils.js';

export default {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of various deprecated methods methods',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/load/',
        },
        schema: [],
    },

    /**
     * Executes the function to check if deprecated methods methods are used
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        return {
            /**
             * Checks if deprecated methods are used and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                const namesToMsg = {
                    isFunction: 'jQuery.isFunction() is deprecated. ' +
                            'In most cases, it can be replaced by [typeof x === "function"]',
                    type: 'jQuery.type() is deprecated. ' +
                            'Replace with an appropriate type check like [typeof x === "function"]',
                    isArray: 'jQuery.isArray() is deprecated. ' +
                            'Use the native Array.isArray method instead',
                    parseJSON: 'jQuery.parseJSON() is deprecated. ' +
                            'To parse JSON strings, use the native JSON.parse method instead',
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
