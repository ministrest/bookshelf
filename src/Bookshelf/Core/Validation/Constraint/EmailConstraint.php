<?php

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

/**
 * @author Kolobkov Aleksandr
 */
class EmailConstraint implements ConstraintInterface
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
     * @var null|string
     */
    private $message = "Неверный формат для Email";

    /**
     * @param ActiveRecord $model
     * @param string $propertyName
     * @param string|null $message
     */
    public function __construct(ActiveRecord $model, $propertyName, $message = null)
    {
        $this->model = $model;
        $this->propertyName = $propertyName;
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
        if (!preg_match("/^[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}$/i", $value)) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
