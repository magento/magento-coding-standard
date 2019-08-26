<?php

/**
 * Handler for PHP errors/warnings/notices that converts them to exceptions.
 */
interface ErrorHandler
{

}

interface NotAnErrorHandler
{

}

/**
 * Faulty Handler
 */
interface FaultyHandler
{

}

/**
 * Interface SomeHandler
 */
interface SomeHandler
{

}

/**
 * YetAnotherHandler
 */
interface YetAnotherHandler
{

}

/**
 * GreenHandler
 * @api Do not confuse tag for faulty short description
 */
interface GreenHandler
{

}

/**
 *
 */
interface EmptyHandler
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
interface ExampleHandler
{

}

/**
 * @api
 * @since 100.0.2
 */
interface ApiHandler
{

}

/**
 * @api
 */
interface AsyncApiHandler
{

}

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
interface GroupRepositoryHandler
{

}

/**
 * @deprecated
 */
interface DeprecatedHandler
{

}

/**
 * @deprecated Should not be used
 */
interface AncientHandler
{

}

/**
 * @deprecated
 * @see
 */
interface AgedHandler
{

}

/**
 * @deprecated Should not be used
 * @see
 */
interface ArhaicHandler
{

}

/**
 * @deprecated Should not be used
 * @see Magento\Framework\NewHandler
 */
interface OldHandler
{

}

/**
 * @see Magento\Framework\NewHandler
 */
interface SomethingHandler
{

}

/**
 * @see
 */
interface DoNotCareHandler
{

}
