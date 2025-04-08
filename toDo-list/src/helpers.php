<?php

/**
 * Validates that required fields are not empty or null.
 *
 * This function checks if the fields in the provided `$postArray` are empty.
 * If the field is required but empty, an error message is added to the `$errors` array.
 *
 * @param array $postArray The array of form data (e.g., $_POST).
 * @param array &$errors The array to store any validation errors.
 */
function fieldRequired(array $postArray, array &$errors)
{
    foreach ($postArray as $key => $value) {
        if (is_array($value)) {
            if (count($value) === 0) {
                $errors[$key][] = ucfirst($key) . ' are required!';
            }
        } else {
            if (trim($value) === '') {
                $errors[$key][] = ucfirst($key) . ' is required!';
            }
        }
    }
}

/**
 * Validates the length of a specific field.
 *
 * This function checks if the length of the specified field (from `$postArray`) is between 3 and 250 characters.
 * If the length is outside this range, an error message is added to the `$errors` array.
 *
 * @param array $postArray The array of form data (e.g., $_POST).
 * @param string $field The specific field to validate (e.g., "title", "description").
 * @param array &$errors The array to store any validation errors.
 */
function fieldLength(array $postArray, string $field, array &$errors)
{
    if (strlen($postArray[$field]) < 3 || strlen($postArray[$field]) > 250) {
        $errors[$field][] = ucfirst($field) . ' should contain from 3 to 250 symbols!';
    }
}

/**
 * Prints validation errors for a specific field.
 *
 * This function takes an array of errors and a specific field name,
 * then displays the associated errors for that field.
 *
 * @param array $errors The array containing error messages.
 * @param string $field The field for which to display errors (e.g., "title", "priority").
 */
function printErrors(array $errors, string $field)
{

    foreach ($errors[$field] ?? [] as $error) {
        echo "<p class='text-red-500 text-sm'>* $error</p>";
    }

}
