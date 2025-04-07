<?php

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

function fieldLength(array $postArray, string $field, array &$errors)
{
    if (strlen($postArray[$field]) < 3 || strlen($postArray[$field]) > 250) {
        $errors[$field][] = ucfirst($field) . ' should contain from 3 to 250 symbols!';
    }
}

function printErrors(array $errors, string $field)
{

    foreach ($errors[$field] ?? [] as $error) {
        echo "<p class='text-red-500 text-sm'>* $error</p>";
    }

}
