<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class NotBlankConstraint implements ConstraintInterface
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
    private $message = 'Это поле не может быть пустым';

    /**
     * @param ActiveRecord $model
     * @param string $propertyName
     * @param string $message
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
        if (!$value) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
