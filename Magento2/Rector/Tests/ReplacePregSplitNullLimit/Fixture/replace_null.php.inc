<?php

preg_split('pattern', 'subject', null, 0);
preg_split('pattern', 'subject', 2);
preg_split('pattern', 'subject', $var);
preg_split('pattern', 'subject');

?>
-----
<?php

preg_split('pattern', 'subject', -1, 0);
preg_split('pattern', 'subject', 2);
preg_split('pattern', 'subject', $var);
preg_split('pattern', 'subject');

?>
