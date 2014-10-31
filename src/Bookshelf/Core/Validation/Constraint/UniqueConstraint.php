<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class UniqueConstraint implements ConstraintInterface
{
    private $model;
    private $propertyName;
    private $message = 'Это название занято';

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
     * @return void
     */
    public function validate(array &$errors)
    {
        $getter = 'get' . ucfirst($this->propertyName);
        $value = $this->model->$getter();
        $query = $this->model->findBy($this->propertyName, $value);
        $property = $query->$getter();
        if ($property) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
