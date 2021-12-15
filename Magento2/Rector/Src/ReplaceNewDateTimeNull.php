<?php
declare(strict_types=1);

namespace Magento2\Rector\Src;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ReplaceNewDateTimeNull extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [New_::class];
    }

    /**
     * @param New_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->class, 'DateTime')) {
            return null;
        }

        if ($node->args[0] !== String_::class) {
            $node->args[0] = $this->nodeFactory->createArg('now');
            return $node;
        }

        return null;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Change DateTime datetime input from null to "now"', [
                new CodeSample(
                    'new DateTime(null, new DateTimeZone("GMT"));',
                    'new DateTime("now", new DateTimeZone("GMT"));'
                ),
            ]
        );
    }
}
