<?php
echo "CF Header: " . ($_SERVER['HTTP_CF_CONNECTING_IP'] ?? 'Not Set') . "<br>";
echo "Remote Addr: " . $_SERVER['REMOTE_ADDR'] . "<br>";
echo "User Agent: " . $_SERVER['HTTP_USER_AGENT'];
?>