<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class RatingConstraint implements ConstraintInterface
{

    private $model;
    private $propertyName;
    private $message = 'Недопустимое значение рейтинга';
    private $availableValues = [0, 1, 2, 3, 4, 5];

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
        $rating = $this->model->$getter();

        if ($rating && !in_array($rating, $this->availableValues)) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
