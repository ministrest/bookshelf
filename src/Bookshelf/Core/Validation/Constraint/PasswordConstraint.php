<?php

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

/**
 * @author Kolobkov Alexsandr
 */
class PasswordConstraint implements ConstraintInterface
{
    /**
     * @var ActiveRecord
     */
    private $model;

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var string
     */
    private $confirmPassword;

    /**
     * @var null|string
     */
    private $message = 'Пароли не совпадают';

    /**
     * @param ActiveRecord $model
     * @param string $propertyName
     * @param string|null $message
     * @param string $confirmPassword
     */
    public function __construct(ActiveRecord $model, $confirmPassword, $propertyName, $message = null)
    {
        $this->model = $model;
        $this->propertyName = $propertyName;
        $this->confirmPassword = $confirmPassword;
        if ($message) {
            $this->message = $message;
        }
    }

    /**
     * @param array $errors
     */
    public function validate(array &$errors)
    {
        $getter = 'get' . ucfirst($this->propertyName);
        $value = $this->model->$getter();
        if ($value !== $this->confirmPassword) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
