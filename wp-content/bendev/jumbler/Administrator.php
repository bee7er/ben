<?php

abstract class Administrator
{
    /**
     * Get the current image of the site from db
     */
    abstract public static function getCurrentObject($id);

    /**
     * Checks whether the current user is a system admin
     *
     * @return bool
     */
    public static function isSuperUser()
    {
        $user = wp_get_current_user();
        // If the current user email address is a System admin
        if (!(strpos(SYSTEM_EMAIL_ADDRESSES, $user->user_email) !== false)) {
            return true;
        }

        return false;
    }

    /**
     * Validate form details
     *
     * @param $data
     * @param $requiredFields
     * @return array
     */
    public function getValidationErrors($data, $requiredFields = [])
    {
        $errors = [];
        foreach ($data as $field => $value) {
            if (in_array($field, $requiredFields)) {
                if (!$value) {
                    $errors[$field] = 'Please enter your ' . PageUtils::formatFieldName($field);
                }
            }
        }
        return $errors;
    }
}
