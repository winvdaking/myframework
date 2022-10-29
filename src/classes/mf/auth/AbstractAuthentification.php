<?php

namespace winv\mf\auth;

use winv\mf\exceptions\AuthentificationException;

abstract class AbstractAuthentification
{
    const ACCESS_LEVEL_NONE = -9999;
    const MIN_PASSWORD_LENGTH = 7;

    protected static function loadProfile(int $id, int $level): void
    {
        $_SESSION['user_profile']['id'] = $id;
        $_SESSION['user_profile']['access_level'] = $level;
    }

    public static function logout(): void
    {
        unset($_SESSION['user_profile']);
    }

    public static function connectedUser(): ?int
    {
        if (isset($_SESSION['user_profile']['id']))
            return $_SESSION['user_profile']['id'];
        return null;
    }

    public static function checkAccessRight(int $requested): bool
    {
        $bool = true;
        if (isset($_SESSION['user_profile'])){
            if ($requested > $_SESSION['user_profile']['access_level'])
                $bool = false;
        }else{
            if ($requested > self::ACCESS_LEVEL_NONE)
                $bool = false;
        }
        return $bool;
    }

    protected static function makePassword(string $password): string
    {
        if (strlen($password) > 7)
            return password_hash($password, PASSWORD_BCRYPT, ['cost' => 14]);
        throw new AuthentificationException("Le mot de passe ne respect pas la politique.");
    }

    protected static function checkPassword(string $given_pass, string $db_hash, int $id, int $level): void
    {
        if (password_verify($given_pass, $db_hash))
            self::connectedUser();
        throw new AuthentificationException('Mot de passe ne correspond pas');
    }
}
