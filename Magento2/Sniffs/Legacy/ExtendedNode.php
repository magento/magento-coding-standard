<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use SimpleXMLElement;

class ExtendedNode
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var int
     */
    public $lineNumber;

    /**
     * @param string $value
     * @param SimpleXMLElement $element
     */
    public function __construct(string $value, SimpleXMLElement $element)
    {
        $this->value = $value;
        $this->lineNumber = dom_import_simplexml($element)->getLineNo();
    }
}
