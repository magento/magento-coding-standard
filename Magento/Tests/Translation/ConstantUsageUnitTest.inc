<?php

// Incorrect arguments

__(ClassName::CONSTANT);

__(self::CONSTANT);

__(\ClassNamespace\ClassName::CONSTANT);

__(
    ClassName::CONSTANT
);

Phrase(ClassName::CONSTANT);

Phrase(self::CONSTANT);

Phrase(\ClassNamespace\ClassName::CONSTANT);

\Magento\Framework\Phrase(ClassName::CONSTANT);

\Magento\Framework\Phrase(
    ClassName::CONSTANT
);

// Correct arguments

__($variable);

__($variable[ClassName::CONSTANT]);

__($variable[\ClassNamespace\ClassName::CONSTANT]);

__($variable['value']);

__(
    $variable
);

Phrase($variable);

Phrase($variable[ClassName::CONSTANT]);

Phrase($variable[\ClassNamespace\ClassName::CONSTANT]);

\Magento\Framework\Phrase($variable['value']);

\Magento\Framework\Phrase(
    $variable[ClassName::CONSTANT]

);
