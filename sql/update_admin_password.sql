-- Update admin password to 'admin123'
UPDATE admins 
SET password_hash = '$2y$10$tX1XiBMnKiiYJJzf.c52nuU8UUKtmi2Dc4MOGFxMi/OxSfjLtqh1EW' 
WHERE username = 'admin';
