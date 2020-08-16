<?php

namespace AppBundle\Services\BlogPost;

use AppBundle\Entity\BlogPost;
use AppBundle\Exception\TargetNotExistsException;
use AppBundle\Interfaces\Publisher;

class BlogPostPublisher
{
    private $publishers = [];

    public function addPublisher(Publisher $publisher)
    {
        $this->publishers[$publisher->getName()] = $publisher;
    }

    public function publish(BlogPost $post, $target)
    {
        if (!isset($this->publishers[$target])) {
            throw new TargetNotExistsException($target . ' is not a valid target');
        }

        return ($this->publishers[$target])->publish($post);
    }
}
