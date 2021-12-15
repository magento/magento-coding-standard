/**
 * Get representation of define object
 * @param node
 * @returns object
 */
function define(node) {
    'use strict';
    var defineStmt, args;

    defineStmt = node.body.find(function (stmt) {
        return (
            stmt.type === 'ExpressionStatement' &&
            stmt.expression.type === 'CallExpression' &&
            stmt.expression.callee.type === 'Identifier' &&
            stmt.expression.callee.name === 'define' &&
            stmt.expression.arguments.length > 0 &&
            stmt.expression.arguments[0].type === 'ArrayExpression'
        );
    });
    if (!defineStmt) {
        return;
    }

    args = defineStmt.expression.arguments;

    return {
        func: defineStmt.expression,
        modulePaths: args[0].elements,
        moduleNames: args.length > 1 && args[1].params || []
    };
}

/**
 * Get jQueryName from define
 * @param defineObject
 * @returns {null|*}
 */
function getJqueryName(defineObject) {
    'use strict';

    var jQueryPathIndex;

    if (!defineObject.modulePaths || !defineObject.moduleNames) {
        return null;
    }
    jQueryPathIndex = defineObject.modulePaths.findIndex(function (paths) {
        return paths.value.toLowerCase() === 'jquery';
    });
    if (jQueryPathIndex === -1 || jQueryPathIndex >= defineObject.moduleNames.length) {
        return null;
    }
    return defineObject.moduleNames[jQueryPathIndex];

}

/**
 * Get Root Program node
 */
function getProgramNode(node) {
    'use strict';
    if (!node.parent) {
        return node;
    }
    return getProgramNode(node.parent);
}

/**
 * Traverses the node to identify its id
 *
 * @param {Object} node - The node to check
 * @returns {Object|Null}
 */
function getExpressionId(node) {
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
    var parentNode, defineNode, jQueryId, id;

    parentNode = getProgramNode(node);
    defineNode = define(parentNode);
    if (!defineNode) {
        return false;
    }
    jQueryId = getJqueryName(defineNode);
    id = getExpressionId(node);

    return id && jQueryId && id.name === jQueryId.name;
}

module.exports = {
    traverse: getExpressionId,
    isjQuery: isjQuery
};
