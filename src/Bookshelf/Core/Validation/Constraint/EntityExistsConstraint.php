<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class EntityExistsConstraint implements ConstraintInterface
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
    private $errorKey;
    /**
     * @var null|string
     */
    private $message = 'Несуществующая категория';

    /**
     * @param ActiveRecord $model
     * @param string $propertyName
     * @param string $errorKey
     * @param string|null $message
     */
    public function __construct(ActiveRecord $model, $propertyName, $errorKey, $message = null)
    {
        $this->errorKey = $errorKey;
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
        $resultModel = $this->model->find($value);
        if (empty($resultModel)) {
            $errors[$this->errorKey][] = $this->message;
        }
    }
}
