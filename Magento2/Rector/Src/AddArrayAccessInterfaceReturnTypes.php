<?php
declare(strict_types=1);

namespace Magento2\Rector\Src;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class AddArrayAccessInterfaceReturnTypes extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->implements, 'ArrayAccess')) {
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
