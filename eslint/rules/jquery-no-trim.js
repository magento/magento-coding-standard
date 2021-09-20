module.exports = {
  meta: {
    type: 'suggestion',
    docs: {
      description: 'Disallow the use of the deprecated `trim` function',
      category: 'jQuery deprecated functions',
      recommended: true,
      url: 'https://api.jquery.com/jQuery.trim/'
    },
    schema: [],
    messages: {
      trim: 'jQuery.trim is deprecated; use String.prototype.trim'
    }
  },

  create: function(context) {
    'use strict';

    return {
      CallExpression: function(node) {
        if (node.callee.type !== 'MemberExpression') return;
        if (node.callee.object.name !== '$') return;
        if (node.callee.property.name !== 'trim') return;

        context.report({
          node: node,
          messageId: 'trim'
        });
      }
    };
  }
};
