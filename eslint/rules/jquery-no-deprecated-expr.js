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
            'MemberExpression[property.value=":"] MemberExpression[property.name="expr"]': function (node) {
                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        message: 'jQuery.expr[":"] is deprecated; Use jQuery.expr.pseudos instead'
                    });
                }
            },
            'MemberExpression[property.name="filters"] MemberExpression[property.name="expr"]': function (node) {
                if (utils.isjQuery(node)) {
                    context.report({
                        node: node,
                        message: 'jQuery.expr.filters is deprecated; Use jQuery.expr.pseudos instead'
                    });
                }
            }
        };
    }
};
