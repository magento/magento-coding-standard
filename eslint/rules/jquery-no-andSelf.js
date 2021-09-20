module.exports = {
  meta: {
    type: 'suggestion',
    docs: {
      description: 'Disallow the use of the deprecated `andSelf` method',
      category: 'jQuery deprecated functions',
      recommended: true,
      url: 'https://api.jquery.com/andself/'
    },
    schema: [],
    messages: {
      andSelf: 'jQuery.andSelf() removed, use jQuery.addBack()'
    }
  },

  create: function(context) {
    'use strict';
    var utils = require('./utils.js');

    return {
      CallExpression: function(node) {
        if (node.callee.type !== 'MemberExpression') return;
        if (node.callee.property.name !== 'andSelf') return;

        if (utils.isjQuery(node)) {
          context.report({
            node: node,
            messageId: 'andSelf'
          });
        }
      }
    };
  }
};
