<?php
// Substitua 'minha_senha_teste' pela senha que deseja testar
$senha = '1';
$hash = password_hash($senha, PASSWORD_BCRYPT);

echo "Senha: $senha\n";
echo "Hash: $hash\n";
