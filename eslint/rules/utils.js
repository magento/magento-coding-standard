/**
 * Traverses the node to identify its type
 *
 * @param {Object} node - The node to check
 * @returns {Object|Null}
 */
function traverse(node) {
    'use strict';

    while (node) {
        switch (node.type) {
            case 'CallExpression':
                node = node.callee;
                break;

            case 'MemberExpression':
                node = node.object;
                break;

            case 'Identifier':
                return node;
            default:
                return null;
        }
    }
}

/**
 * Traverses from a node up to its root parent to determine if it originated from a jQuery `$()` function.
 * Examples:
 *   $('div').find('p').first()
 *   isjQuery(firstNode) // => true
 *
 * @param {Object} node - The CallExpression node to start the traversal.
 * @returns {Boolean} - true if the function call node is attached to a jQuery element set. false, otherwise.
 */

function isjQuery(node) {
    'use strict';

    var id = traverse(node);

    return id && id.name.startsWith('$');
}

module.exports = {
    traverse: traverse,
    isjQuery: isjQuery
};
