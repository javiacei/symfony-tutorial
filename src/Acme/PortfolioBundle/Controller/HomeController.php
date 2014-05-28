<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * HomeController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class HomeController
{
    public function indexAction()
    {
        return new Response('Render this');
    }
}
 