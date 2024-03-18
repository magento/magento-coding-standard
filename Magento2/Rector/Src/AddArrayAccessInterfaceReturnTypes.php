<?php
/**
 * Copyright 2021 Adobe
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Rector\Src;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class AddArrayAccessInterfaceReturnTypes extends AbstractRector
{
    /**
     * @inheritDoc
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @inheritDoc
     */
    public function refactor(Node $node): ?Node
    {
        foreach ($node->implements as $implement) {
            if ($this->isName($implement, 'ArrayAccess')) {
                break;
            }
            return null;
        }

        foreach ($node->getMethods() as $method) {
            if ($this->isName($method, 'offsetExists') && empty($method->getReturnType())) {
                $method->returnType = new \PhpParser\Node\Name('bool');
            }
            if ($this->isName($method, 'offsetSet') && empty($method->getReturnType())) {
                $method->returnType = new \PhpParser\Node\Name('void');
            }
            if ($this->isName($method, 'offsetUnset') && empty($method->getReturnType())) {
                $method->returnType = new \PhpParser\Node\Name('void');
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add return types specified by ArrayAccess interface',
            [
                new CodeSample(
                    'public function offsetSet($offset, $value)',
                    'public function offsetSet($offset, $value): void'
                ),
            ]
        );
    }
}
