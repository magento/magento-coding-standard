module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of shorthand methods',
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
                var names = ['load', 'unload', 'error'],
                    name;

                if (node.callee.type !== 'MemberExpression') {return;}

                if (!names.includes(node.callee.property.name)) {return;}

                if (utils.isjQuery(node)) {
                    name = node.callee.property.name;
                    context.report({
                        node: node,
                        message: 'jQuery.' + name + '() was removed, use .on("' + name + '", fn) instead.'
                    });
                }
            }
        };
    }
};
