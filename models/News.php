<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;

class News extends Model
{
    public function validation()
    {
    	$this->validate(new Uniqueness(
            array(
                "field"   => "PostId",
                "message" => "The PostId name must be unique"
            )
        ));
        // Check if any messages have been produced
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
?>