<?php

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

/**
 * @author Aleksandr Kolobkov
 */
class PhoneConstraint implements ConstraintInterface
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
    private $message = 'Номер телефона может содержать только цифры!';

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
            $this->message = $message . $propertyName;
        }
    }

    /**
     * @param array $errors
     */
    public function validate(array &$errors)
    {
        $getter = 'get' . ucfirst($this->propertyName);
        $value = $this->model->$getter();
        if (!(preg_match_all('/^[0-9]+$/', $value))) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
