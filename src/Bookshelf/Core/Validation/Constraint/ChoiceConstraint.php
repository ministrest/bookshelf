<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class ChoiceConstraint implements ConstraintInterface
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
    private $message = 'Недопустимое значение';

    /**
     * @var array
     */
    private $availableValues;

    /**
     * @param ActiveRecord $model
     * @param string $propertyName
     * @param string $availableValues
     * @param string $message
     */
    public function __construct(ActiveRecord $model, $propertyName, $availableValues, $message = null)
    {
        $this->availableValues = $availableValues;
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
        $rating = $this->model->$getter();

        if ($rating && !in_array($rating, $this->availableValues)) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
