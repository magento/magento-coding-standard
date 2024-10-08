<?php
/**
 * Copyright 2021 Adobe
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Rector\Src;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\LNumber;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class ReplaceMbStrposNullLimit extends AbstractRector
{
    /**
     * @inheritDoc
     */
    public function getNodeTypes(): array
    {
        return [FuncCall::class];
    }

    /**
     * @inheritDoc
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'mb_strpos')) {
            return null;
        }

        if ($node->args[2] !== LNumber::class) {
            $node->args[2] = $this->nodeFactory->createArg(0);
            return $node;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Change mb_strpos offset from null to 0',
            [
                new CodeSample(
                    'mb_strpos("pattern", "subject", null, "encoding");',
                    'mb_strpos("pattern", "subject", 0, "encoding");'
                ),
            ]
        );
    }
}
