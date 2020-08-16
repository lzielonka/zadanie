<?php

namespace AppBundle\Services\BlogPost\Integrations;

use AppBundle\Entity\BlogPost;
use AppBundle\Interfaces\Publisher;

class Facebook implements Publisher
{
    public function publish(BlogPost $post)
    {
        return true;
    }

    public function getName()
    {
        return 'facebook';
    }
}
