<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/auth.php';

logout_usuario();

header('Location: ../../html/htmlcode.html#inicio');
exit;
