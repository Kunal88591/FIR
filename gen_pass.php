<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Password: " . $password . "\n";
echo "New Hash: " . $hash . "\n";

$old_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
echo "Old Hash Verify: " . (password_verify($password, $old_hash) ? 'Valid' : 'Invalid') . "\n";
?>
