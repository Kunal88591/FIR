<?php
/**
 * Input Validation Helper
 * Comprehensive validation functions for form inputs
 */

class Validator
{
    /**
     * Validate required field
     * @param string $value
     * @param string $fieldName
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public static function required(string $value, string $fieldName): array
    {
        $value = trim($value);
        if ($value === '') {
            return ['valid' => false, 'error' => "$fieldName is required."];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate email
     * @param string $email
     * @return array
     */
    public static function email(string $email): array
    {
        if ($email === '') {
            return ['valid' => true, 'error' => null]; // Empty is OK if not required
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'error' => 'Invalid email address.'];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate phone number
     * @param string $phone
     * @return array
     */
    public static function phone(string $phone): array
    {
        if ($phone === '') {
            return ['valid' => true, 'error' => null];
        }
        
        if (!preg_match('/^[0-9\+\-\(\)\s]{10,20}$/', $phone)) {
            return ['valid' => false, 'error' => 'Invalid phone number format.'];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate minimum length
     * @param string $value
     * @param int $minLength
     * @param string $fieldName
     * @return array
     */
    public static function minLength(string $value, int $minLength, string $fieldName): array
    {
        if (strlen($value) < $minLength) {
            return ['valid' => false, 'error' => "$fieldName must be at least $minLength characters."];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate maximum length
     * @param string $value
     * @param int $maxLength
     * @param string $fieldName
     * @return array
     */
    public static function maxLength(string $value, int $maxLength, string $fieldName): array
    {
        if (strlen($value) > $maxLength) {
            return ['valid' => false, 'error' => "$fieldName must be at most $maxLength characters."];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate date format
     * @param string $date
     * @param string $format
     * @return array
     */
    public static function date(string $date, string $format = 'Y-m-d'): array
    {
        if ($date === '') {
            return ['valid' => true, 'error' => null];
        }
        
        $d = DateTime::createFromFormat($format, $date);
        if (!$d || $d->format($format) !== $date) {
            return ['valid' => false, 'error' => 'Invalid date format.'];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate integer
     * @param mixed $value
     * @param string $fieldName
     * @return array
     */
    public static function integer($value, string $fieldName): array
    {
        if (!is_numeric($value) || intval($value) != $value) {
            return ['valid' => false, 'error' => "$fieldName must be a valid integer."];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate range
     * @param int $value
     * @param int $min
     * @param int $max
     * @param string $fieldName
     * @return array
     */
    public static function range(int $value, int $min, int $max, string $fieldName): array
    {
        if ($value < $min || $value > $max) {
            return ['valid' => false, 'error' => "$fieldName must be between $min and $max."];
        }
        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate multiple fields at once
     * @param array $rules Array of validation rules
     * @return array ['valid' => bool, 'errors' => array]
     * 
     * Example:
     * $result = Validator::validateAll([
     *     ['rule' => 'required', 'value' => $name, 'field' => 'Name'],
     *     ['rule' => 'email', 'value' => $email],
     *     ['rule' => 'minLength', 'value' => $password, 'params' => [8], 'field' => 'Password']
     * ]);
     */
    public static function validateAll(array $rules): array
    {
        $errors = [];
        
        foreach ($rules as $rule) {
            $ruleName = $rule['rule'];
            $value = $rule['value'] ?? '';
            $field = $rule['field'] ?? 'Field';
            $params = $rule['params'] ?? [];
            
            $result = null;
            switch ($ruleName) {
                case 'required':
                    $result = self::required($value, $field);
                    break;
                case 'email':
                    $result = self::email($value);
                    break;
                case 'phone':
                    $result = self::phone($value);
                    break;
                case 'minLength':
                    $result = self::minLength($value, $params[0] ?? 1, $field);
                    break;
                case 'maxLength':
                    $result = self::maxLength($value, $params[0] ?? 255, $field);
                    break;
                case 'date':
                    $result = self::date($value, $params[0] ?? 'Y-m-d');
                    break;
                case 'integer':
                    $result = self::integer($value, $field);
                    break;
                case 'range':
                    $result = self::range((int)$value, $params[0] ?? 0, $params[1] ?? 100, $field);
                    break;
            }
            
            if ($result && !$result['valid']) {
                $errors[] = $result['error'];
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
