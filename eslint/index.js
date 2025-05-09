/**
 * ESLint Plugin for jQuery Deprecation Rules
 * This module aggregates individual jQuery-related rules into a single .
 */
import jqueryNoAndSelf from './rules/jquery-no-andSelf.js';
import jqueryNoBindUnbind from './rules/jquery-no-bind-unbind.js';
import jqueryNoDelegateUndelegate from './rules/jquery-no-delegate-undelegate.js';
import jqueryNoDeprecatedExpr from './rules/jquery-no-deprecated-expr.js';
import jqueryNoEventShorthand from './rules/jquery-no-event-shorthand.js';
import jqueryNoInputEventShorthand from './rules/jquery-no-input-event-shorthand.js';
import jqueryNoMiscDeprecatedFunctions from './rules/jquery-no-misc-deprecated-functions.js';
import jqueryNoSize from './rules/jquery-no-size.js';
import jqueryNoTrim from './rules/jquery-no-trim.js';

export default {
    rules: {
        'jquery-no-andSelf': jqueryNoAndSelf,
        'jquery-no-bind-unbind': jqueryNoBindUnbind,
        'jquery-no-delegate-undelegate': jqueryNoDelegateUndelegate,
        'jquery-no-deprecated-expr': jqueryNoDeprecatedExpr,
        'jquery-no-event-shorthand': jqueryNoEventShorthand,
        'jquery-no-input-event-shorthand': jqueryNoInputEventShorthand,
        'jquery-no-misc-deprecated-functions': jqueryNoMiscDeprecatedFunctions,
        'jquery-no-size': jqueryNoSize,
        'jquery-no-trim': jqueryNoTrim
    }
};
