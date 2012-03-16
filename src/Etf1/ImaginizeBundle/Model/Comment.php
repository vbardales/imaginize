<?php

namespace Etf1\ImaginizeBundle\Model;

use Etf1\ImaginizeBundle\Model\om\BaseComment;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;


/**
 * Skeleton subclass for representing a row from the 'comment' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.src.Etf1.ImaginizeBundle.Model
 */
class Comment extends BaseComment {
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('value', new NotBlank());
    }
} // Comment
