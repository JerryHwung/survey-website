<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It finishes outputting the HTML for this page:
// don't forget to add your name and student number to the footer

echo <<<_END
	</main>
    <footer class="footer">
	<div class="container">
	<span class="text-muted">
    &copy;6G5Z2107 - Hong Jin Hwung - 17004464 - 2018/19
	</span>
	</div>
	</footer>
    </body>
    </html>
_END;
?>