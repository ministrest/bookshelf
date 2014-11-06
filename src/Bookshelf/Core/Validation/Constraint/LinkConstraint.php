<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core\Validation\Constraint;

use Bookshelf\Model\ActiveRecord;

class LinkConstraint implements ConstraintInterface
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
    private $message = 'Несуществующая ссылка';

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
        $url = $this->model->$getter();

        if ($url && !preg_match('#[-a-zA-Z0-9а-яёА-ЯЁ@:%_\+.~\#?&//=]{2,256}\.[a-zа-яё]{2,4}\b(\/[-a-zA-Z0-9а-яёА-ЯЁ@:%_\+.~\#?&//=]*)?#usi', $url)) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
