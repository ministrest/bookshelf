<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class RatingConstraint implements ConstraintInterface{

    private $model;
    private $propertyName;
    private $message = 'Недопустимое значение рейтинга';

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
     * @return boolean
     */
    public function validate(array &$errors)
    {
        $accessor = 'get' . ucfirst($this->propertyName);
        $rating = $this->model->$accessor();
        $allowableValues = [0, 1, 2, 3, 4, 5];

        if ($rating && !in_array($rating, $allowableValues)) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
