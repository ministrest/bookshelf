<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation;

use Bookshelf\Core\Validation\Constraint\ConstraintInterface;

class Validator
{
    /**
     * @var ConstraintInterface[]
     */
    private $constraints = [];

    /**
     * @param ConstraintInterface $constraint
     */
    public function addConstraint(ConstraintInterface $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * @return array
     */
    public function validate()
    {
        $errors = [];
        foreach ($this->constraints as $constraint) {
            $constraint->validate($errors);
        }

        return $errors;
    }
}
