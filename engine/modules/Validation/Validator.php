<?php

namespace Excore\Core\Modules\Validation;

use Excore\Core\Helpers\DataFilter;
use Excore\Core\Modules\Validation\Exceptions\ValidationException;

class Validator
{
    private array $data;
    private array $rules = [];
    private array $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function init($data)
    {
        return new self($data);
    }

    public function rules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    public function validate()
    {
        foreach ($this->rules as $fieldName => $fieldRules) {
            // if (!array_key_exists($fieldName, $this->data)) {
            //     continue;
            // }

            $fieldValue = htmlspecialchars(trim(strip_tags($this->data[$fieldName] ?? '')), ENT_QUOTES, 'UTF-8');
            $fieldRules = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($fieldRules as $rule) {
                [$ruleName, $parameters] = $this->parseRule($rule);
                $validationMethod = 'validate' . ucfirst($ruleName);

                if (method_exists($this, $validationMethod)) {
                    call_user_func([$this, $validationMethod], $fieldName, $fieldValue, ...$parameters);
                } else {
                    throw new ValidationException("Неизвестное правило валидации: $ruleName");
                }
            }
        }
        return $this;
    }


    public function errors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    private function parseRule($rule)
    {
        $parameters = [];
        if (strpos($rule, ':') !== false) {
            [$ruleName, $paramString] = explode(':', $rule, 2);
            $parameters = explode(',', $paramString);
        } else {
            $ruleName = $rule;
        }
        return [$ruleName, $parameters];
    }

    private function addError($fieldName, $message)
    {
        $this->errors[$fieldName][] = $message;
    }

    private function validateRequired($fieldName, $fieldValue)
    {
        if (empty($fieldValue) || is_null($fieldValue)) {
            $this->addError($fieldName, "Поле $fieldName обязательно для заполнения");
        }
    }

    private function validateEmail($fieldName, $fieldValue)
    {
        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
            $this->addError($fieldName, 'Некорректный формат email');
        }
    }

    private function validateLogin($fieldName, $fieldValue)
    {
        $regex = '/^[a-zA-Z0-9_]{3,20}$/';

        if (!preg_match($regex, $fieldValue)) {
            $this->addError($fieldName, 'Неверный формат логина. Используйте буквы, цифры и подчеркивания, длина - от 3 до 20 символов.');
        }
    }


    private function validateConfirmed($fieldName, $fieldValue, $confirmationFieldName)
    {
        $confirmationValue = $this->data[$confirmationFieldName] ?? null;

        if ($fieldValue !== $confirmationValue) {
            $this->addError($fieldName, "Пароль и его подтверждение не совпадают");
        }
    }


    private function validateMinLength($fieldName, $fieldValue, $minLength)
    {
        if (mb_strlen($fieldValue) < $minLength) {
            $this->addError($fieldName, "Минимальная длина поля $fieldName: $minLength символов");
        }
    }

    private function validateMaxLength($fieldName, $fieldValue, $maxLength)
    {
        if (mb_strlen($fieldValue) > $maxLength) {
            $this->addError($fieldName, "Максимальная длина поля $fieldName: $maxLength символов");
        }
    }

    private function validateNumeric($fieldName, $fieldValue)
    {
        if (!is_numeric($fieldValue)) {
            $this->addError($fieldName, "Поле $fieldName должно быть числом");
        }
    }

    private function validateUrl($fieldName, $fieldValue)
    {
        if (!filter_var($fieldValue, FILTER_VALIDATE_URL)) {
            $this->addError($fieldName, "Некорректный URL в поле $fieldName");
        }
    }

    private function validatePhone($fieldName, $fieldValue)
    {
        if (!preg_match('/^\+\d{10,}$/', $fieldValue)) {
            $this->addError($fieldName, "Некорректный формат номера телефона в поле $fieldName");
        }
    }

    private function validateTelegram($fieldName, $fieldValue)
    {
        if (!preg_match('/^@[\w]+$/', $fieldValue)) {
            $this->addError($fieldName, "Некорректный формат Telegram в поле $fieldName");
        }
    }

    private function validateVk($fieldName, $fieldValue)
    {
        if (!filter_var($fieldValue, FILTER_VALIDATE_URL) || !strpos($fieldValue, 'vk.com/')) {
            $this->addError($fieldName, "Некорректный формат VK профиля в поле $fieldName");
        }
    }

    private function validateYouTube($fieldName, $fieldValue)
    {
        if (!filter_var($fieldValue, FILTER_VALIDATE_URL) || !strpos($fieldValue, 'youtube.com/channel/')) {
            $this->addError($fieldName, "Некорректный формат YouTube канала в поле $fieldName");
        }
    }

    private function validateInstagram($fieldName, $fieldValue)
    {
        if (!filter_var($fieldValue, FILTER_VALIDATE_URL) || !strpos($fieldValue, 'instagram.com/')) {
            $this->addError($fieldName, "Некорректный формат Instagram аккаунта в поле $fieldName");
        }
    }

    private function validateTikTok($fieldName, $fieldValue)
    {
        if (!filter_var($fieldValue, FILTER_VALIDATE_URL) || !strpos($fieldValue, 'tiktok.com/@')) {
            $this->addError($fieldName, "Некорректный формат TikTok аккаунта в поле $fieldName");
        }
    }
}
