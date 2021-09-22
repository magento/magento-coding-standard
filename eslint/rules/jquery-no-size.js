module.exports = {
  meta: {
    type: 'suggestion',
    docs: {
      description: 'Disallow the use of the deprecated `size` method',
      category: 'jQuery deprecated functions',
      recommended: true,
      url: 'https://api.jquery.com/size/'
    },
    schema: [],
    messages: {
      size: 'jQuery.size() removed, use jQuery.length'
    }
  },

  create: function(context) {
    'use strict';
    var utils = require('./utils.js');

    return {
      CallExpression: function(node) {
        if (node.callee.type !== 'MemberExpression') return;
        if (node.callee.property.name !== 'size') return;

        if (utils.isjQuery(node)) {
          context.report({
            node: node,
            messageId: 'size'
          });
        }
      }
    };
  }
};
