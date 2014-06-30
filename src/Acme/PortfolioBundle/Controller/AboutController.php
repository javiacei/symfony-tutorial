<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * AboutController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class AboutController extends Controller
{
    /**
     *
     * @Template()
     * @param Request $request
     *
     * @return null|JsonResponse|Response
     */
    public function indexAction(Request $request)
    {
        $response = null;
        $githubUrl = "https://api.github.com/users/symfony/repos";
        $projects = $this->curl($githubUrl, $request);

        if ('html' === $request->getRequestFormat()) {
            $response = array(
                'section' => $this->get('translator')->trans('About'),
                'projects' => $projects
            );
        }

        if ('json' === $request->getRequestFormat()) {
            $response = new JsonResponse($projects);
        }

        return $response;
    }

    protected function curl($url, Request $request)
        {
            $ch = curl_init($url);
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT => $request->headers->get('User-Agent')
            );
            curl_setopt_array($ch, $options);
            $data = curl_exec($ch);

            $headers = curl_getinfo($ch);

            curl_close($ch);
            return json_decode($data);
        }

}
 
