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
     * @var null|string
     */
    private $message = 'Несуществующая ссылка';

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
        $url = $this->model->$getter();
        if (!strstr($url,"://")){
            $url="http://" . $url;
        }

        if ($url && !@get_headers($url)) {
            $errors[$this->propertyName][] = $this->message;
        }
    }
}
