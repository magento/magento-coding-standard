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
     * Executes the function to check if shorthand methods are used.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if shorthand methods are used and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                var namesToMsg = {
                        'isFunction': 'jQuery.isFunction() is deprecated. '
                            + 'In most cases, it can be replaced by [typeof x === "function"]',
                        'type': 'jQuery.type() is deprecated. ' +
                            'Replace with an appropriate type check like [typeof x === "function"]',
                        'isArray': 'jQuery.isArray() is deprecated. ' +
                            'Use the native Array.isArray method instead',
                        'parseJSON' : 'jQuery.parseJSON() is deprecated. ' +
                            'To parse JSON strings, use the native JSON.parse method instead'
                    },
                    name;

                if (node.callee.type !== 'MemberExpression') {return;}

                name = node.callee.property.name;
                if (!(name in namesToMsg)) {return;}

                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        message: namesToMsg[name]
                    });
                }
            }
        };
    }
};
