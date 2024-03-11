<?php

// execute the header script:
require_once "header.php";
echo <<<_END
<h1 class="mt-5">2CWK50: A Survey Website</h1>
<p class="lead">
<b>Hello there, welcome to my survey website!</b><br>
Please ensure that you have run through <a href="create_data.php">create_data.php</a> once before you go beyond this point.<br>
This website is capable to let users create accounts and manage their surveys. While admin can even manage others' accounts and surveys.<br>
To sign in as an admin, please use the following details:<br></p>
<ul>
<li>username: admin</li>
<li>password: secret</li>
</ul>
<p class="lead">
The main features of this site is to create, update, delete and retrieve accounts and their details. <br>
In addition, admin can also submit(by clicking the Try Me!! button) or delete a sample survey provided by me, the results can be view in tables or charts too.<br>
</p>
_END;

// footer of this page:
require_once "footer.php";

?>