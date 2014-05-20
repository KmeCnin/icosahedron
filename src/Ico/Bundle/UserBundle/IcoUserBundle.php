<?php

namespace Ico\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IcoUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
