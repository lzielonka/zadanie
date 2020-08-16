<?php

namespace AppBundle\Services\BlogPost\Integrations;

use AppBundle\Entity\BlogPost;
use AppBundle\Interfaces\Publisher;

class Twitter implements Publisher
{
    public function publish(BlogPost $post)
    {
        return true;
    }

    public function getName()
    {
        return 'twitter';
    }
}
