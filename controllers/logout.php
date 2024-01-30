<?php
session_start();
session_destroy();
header("location:http://localhost/finalv2/index.php?msg=logout");
