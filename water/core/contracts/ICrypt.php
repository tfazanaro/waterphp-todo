<?php namespace core\contracts;

interface ICrypt
{
    public static function encode($decrypted);

    public static function decode($encrypted);
}