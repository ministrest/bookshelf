<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

interface ConstraintInterface
{
    /**
     * @param array $errors
     * @return boolean
     */
    public function validate(array &$errors);
}
