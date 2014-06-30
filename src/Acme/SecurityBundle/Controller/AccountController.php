<?php

namespace Acme\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AccountController extends Controller
{
    /**
     * @Template()
     */
    public function loginAction()
    {
        return array();
    }
}
