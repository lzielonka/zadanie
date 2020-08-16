<?php

namespace AppBundle\Interfaces;

use AppBundle\Entity\BlogPost;

interface Publisher
{
    public function publish(BlogPost $post);
    public function getName();
}
