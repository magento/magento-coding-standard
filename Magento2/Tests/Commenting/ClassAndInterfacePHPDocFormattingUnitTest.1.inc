<?php

/**
 * Handler for PHP errors/warnings/notices that converts them to exceptions.
 */
class ErrorHandler
{

}

class NotAnErrorHandler
{

}

/**
 * Faulty Handler
 */
class FaultyHandler
{

}

/**
 * Class SomeHandler
 */
class SomeHandler
{

}

/**
 * YetAnotherHandler
 */
class YetAnotherHandler
{

}

/**
 * GreenHandler
 * @api Do not confuse tag for faulty short description
 */
class GreenHandler
{

}

/**
 *
 */
class EmptyHandler
{

}

/**
 * Handler for PHP errors/warnings/notices that converts them to exceptions.
 *
 * @api is ok here
 * @deprecated can be used in this context
 * @see is ok here
 * @author is actually ok
 * @category is irrelevant
 * @package is not ment to be used
 * @subpackage does not belong here
 */
class ExampleHandler
{

}

/**
 * @api
 * @since 100.0.2
 */
class ApiHandler
{

}

/**
 * @api
 */
class AsyncApiHandler
{

}

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GroupRepositoryHandler
{

}

/**
 * @deprecated
 */
class DeprecatedHandler
{

}

/**
 * @deprecated Should not be used
 */
class AncientHandler
{

}

/**
 * @deprecated
 * @see
 */
class AgedHandler
{

}

/**
 * @deprecated Should not be used
 * @see
 */
class ArhaicHandler
{

}

/**
 * @deprecated Should not be used
 * @see Magento\Framework\NewHandler
 */
class OldHandler
{

}

/**
 * @see Magento\Framework\NewHandler
 */
class SomethingHandler
{

}

/**
 * @see
 */
class DoNotCareHandler
{

}

/**
 * @deprecated
 * @see Magento\Framework\NewHandler
 */
class OldHandler
{

}

/**
 * @deprecated This class will be removed in version 1.0.0 without replacement
 */
class DeprecatedButHandler
{

}

/**
 * @deprecated It's also deprecated - This class will be removed in version 1.0.0 without replacement
 */
class AlsoDeprecatedButHandler
{

}

