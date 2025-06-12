<?php

namespace Tecgdcs;

use Illuminate\Database\Capsule\Manager;
use Tecgdcs\Exceptions\ValidationRuleNotFoundException;

class Validator
{
    public static function required(string $field_name): bool
    {
        if (
            !array_key_exists($field_name, $_REQUEST)
            || trim($_REQUEST[$field_name]) === ''
        ) {
            $_SESSION['errors'][$field_name] =
                sprintf(MESSAGES['required'], $field_name);

            return false;
        }

        return true;
    }

    public static function email(string $field_name): bool
    {
        if (
            array_key_exists($field_name, $_REQUEST) &&
            trim($_REQUEST[$field_name]) !== '' &&
            !filter_var(trim($_REQUEST[$field_name]), FILTER_VALIDATE_EMAIL)
        ) {
            $_SESSION['errors'][$field_name] = sprintf(MESSAGES['email'], $field_name);

            return false;
        }

        return true;
    }

    public static function phone(string $field_name): bool
    {
        if (
            array_key_exists($field_name, $_REQUEST) &&
            trim($_REQUEST[$field_name]) !== '' &&
            (
                strlen($_REQUEST[$field_name]) < 9 ||
                !is_numeric(
                    str_replace(['+', '(', ')', ' '], '', $_REQUEST[$field_name])
                )
            )
        ) {
            $_SESSION['errors'][$field_name] = sprintf(MESSAGES['phone'], $field_name);

            return false;
        }

        return true;
    }

    public static function same(string $verification_field_name, string $original_field_name): bool
    {
        if (
            array_key_exists($verification_field_name, $_REQUEST) &&
            array_key_exists($original_field_name, $_REQUEST)
        ) {
            if (
                trim($_REQUEST[$verification_field_name]) !==
                trim($_REQUEST[$original_field_name])
            ) {
                $_SESSION['errors'][$verification_field_name] =
                    sprintf(MESSAGES['same'], $verification_field_name, $original_field_name);

                return false;
            }

            return true;
        }

        return false;
    }

    public static function exists(string $field_name, string $table, string $column): bool
    {
        $item = Manager::table($table)
            ->where($column, $_REQUEST[$field_name])
            ->first();
        if (!$item) {
            $_SESSION['errors'][$field_name] =
                sprintf(MESSAGES['exists'], $field_name, $table);
            return false;
        }

        return true;
    }

    public static function check(array $constraints): void
    {
        try {
            self::parse_constraints($constraints);
        } catch (ValidationRuleNotFoundException $e) {
            exit($e->getMessage());
        }

        if (isset($_SESSION['errors'])) {
            $_SESSION['old'] = $_REQUEST;
            back();
        }
    }

    /**
     * @throws ValidationRuleNotFoundException
     */
    private static function parse_constraints(array $constraints): void
    {
        $method = $param1 = $param2 = '';
        foreach ($constraints as $field_name => $constraint) {
            $array_rules = explode('|', $constraint);
            foreach ($array_rules as $method) {
                if (str_contains($method, ':')) {
                    [$method, $param1] = explode(':', $method);
                }
                if (str_contains($param1, ',')) {
                    [$param1, $param2] = explode(',', $param1);
                }

                if (!method_exists(__CLASS__, $method)) {
                    throw new ValidationRuleNotFoundException($method);
                }
                self::$method($field_name, $param1, $param2);
            }
        }
    }
}
