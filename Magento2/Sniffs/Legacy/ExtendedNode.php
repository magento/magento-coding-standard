<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMElement;
use SimpleXMLElement;

class ExtendedNode
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var DOMElement
     */
    public $element;

    /**
     * @param string $value
     * @param SimpleXMLElement $element
     */
    public function __construct(string $value, SimpleXMLElement $element)
    {
        $this->value = $value;
        $this->element = dom_import_simplexml($element);
    }
}
