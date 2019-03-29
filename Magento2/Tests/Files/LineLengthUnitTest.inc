<?php

use Magento\Framework\Phrase;

// allowed
$shortString = 'This is a short line';

// triggers an error
$tooLongString = 'This is a pretty long line. The code sniffer will report an error if a single line exceeds the maximum character count. You have need to insert a line break to avoid this error.';

// allowed
$longStringBrokenUp = 'This is a pretty long line. The code sniffer would report an error if this was written as a ' .
                      'single line. You have to insert a line break to avoid this error.';

// allowed: long lines for translations
$phraseObjects = [
    Phrase('This is a short line'),
    Phrase('Lines which include translations are excluded from this check. You can exceed the maximum character count without receiving a warning or an error.'),
    'This is no translation string, so let us make sure this throws an error even when we use the word Phrase inside the string',
    __(
        'Also if we use this syntax and we put the actual translation string into a new line, there should be no error if this is used in a translation.'
    ),
    Phrase(
        'The same goes for the Phrase class when we put the actual translation string into a new line, also here we should not receive an error.'
    )
];

// allowed by Magento Standard (Generic ruleset would trigger warning / error)
$test = '012344567890123445678901234456789012344567890123445678901234456789';
$test1 = '01234456789012344567890123445678901234456789012344567890123445678901234456789';
$test2 = '012344567890123445678901234456789012344567890123445678901234456789012344567890123445678901234456789';
