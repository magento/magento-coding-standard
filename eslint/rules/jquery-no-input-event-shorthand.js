module.exports = {
    meta: {
        type: 'suggestion',
        docs: {
            description: 'Disallow the use of shortcuts to input events via keyboard/mouse trigger events',
            category: 'jQuery deprecated functions',
            recommended: true,
            url: 'https://api.jquery.com/bind/'
        },
        schema: []
    },

    /**
     * Executes the function to check if shortcuts are used to trigger events.
     *
     * @param {Object} context
     * @returns {Object}
     */
    create: function (context) {
        'use strict';

        var utils = require('./utils.js');

        return {
            /**
             * Checks if shortcuts are used to trigger events and reports it.
             *
             * @param {Object} node - The node to check.
             */
            CallExpression: function (node) {
                var names, name;

                names = ['blur', 'focus', 'focusin', 'focusout', 'resize', 'scroll', 'dblclick', 'mousedown',
                    'mouseup', 'mousemove','mouseover', 'mouseout', 'mouseenter', 'mouseleave', 'change', 'select',
                    'submit', 'keydown', 'keypress', 'keyup', 'contextmenu', 'click'];

                if (node.callee.type !== 'MemberExpression') {return;}

                if (!names.includes(node.callee.property.name)) {return;}

                if (utils.isjQuery(node)) {
                    name = node.callee.property.name;
                    context.report({
                        node: node,
                        message: 'Instead of .' + name + '(fn) use .on("' + name + '", fn). Instead of .' + name +
                            '() use .trigger("' + name + '")'
                    });
                }
            }
        };
    }
};
