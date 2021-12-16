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
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ReplacePregSplitNullLimit extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [FuncCall::class];
    }

    /**
     * @param FuncCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'preg_split')) {
            return null;
        }

        if ($node->args[2] !== LNumber::class) {
            $node->args[2] = $this->nodeFactory->createArg(-1);
            return $node;
        }

        return null;
    }

    /**
     * @return RuleDefinition
     * @throws PoorDocumentationException
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
