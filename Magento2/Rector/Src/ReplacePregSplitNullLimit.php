<?php
/**
 * Copyright 2021 Adobe
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Rector\Src;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class ReplacePregSplitNullLimit extends AbstractRector
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
        if (!$this->isName($node->name, 'preg_split') || !isset($node->args[2])) {
            return null;
        }
        $value = $node->args[2]->value;

        if ($value instanceof ConstFetch && $value->name->toString() === 'null') {
            $node->args[2] = $this->nodeFactory->createArg(-1);
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
            'Change preg_split limit from null to -1',
            [
                new CodeSample(
                    'preg_split("pattern", "subject", null, 0);',
                    'preg_split("pattern", "subject", -1, 0);'
                ),
            ]
        );
    }
}
