<?php

use DateTime;
use DateTimeZone;

new DateTime(null, new DateTimeZone('GMT'));

?>
-----
<?php

use DateTime;
use DateTimeZone;

new DateTime('now', new DateTimeZone('GMT'));

?>
