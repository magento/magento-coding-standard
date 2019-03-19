<?php

// allowed
$shortString = 'This is a short line';

// triggers an error
$tooLongString = 'This is a pretty long line. The code sniffer will report an error if a single line exceeds the maximum character count. You have need to insert a line break to avoid this error.';

// allowed
$longStringBrokenUp = 'This is a pretty long line. The code sniffer would report an error if this was written as a ' .
                      'single line. You have to insert a line break to avoid this error.';

// allowed by Magento Standard (Generic ruleset would trigger warning / error)
$test = '012344567890123445678901234456789012344567890123445678901234456789';
$test1 = '01234456789012344567890123445678901234456789012344567890123445678901234456789';
$test2 = '012344567890123445678901234456789012344567890123445678901234456789012344567890123445678901234456789';
