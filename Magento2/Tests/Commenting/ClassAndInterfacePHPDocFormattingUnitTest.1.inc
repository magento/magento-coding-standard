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
{}
