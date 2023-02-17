<?php

namespace App\Controller;

use App\Services\AbstractEntityService;
use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/url')]
class UrlController extends AbstractController
{
    /**
     * @param IUrlEncoder $encoder
     * @param IUrlDecoder $decoder
     * @param AbstractEntityService $urlService
     */

    public function __construct(
        protected IUrlEncoder $encoder,
        protected IUrlDecoder $decoder,
        protected AbstractEntityService $urlService
    )
    {
    }

    #[Route('/encode',
        name: 'encode_url',
        methods: ['POST']
    )]
    public function encodeAction (Request $request): Response
    {
        $rqst = $request->get('url');
        $code = $this->encoder->encode($rqst);//$this->encoder->encode($request->get('url'));
        $dttm = date('Y-m-d H:i:s');
        $vars = [
            'code' => $code,
            'url'  => $rqst
            ];

        $template = 'url_encode.html.twig';

        return $this->render($template, $vars);
        //return new Response($code);

    }

    #[Route('/encode2',
        name: 'encode2_url',
        methods: ['POST']
    )]
    public function encodeAction2 (Request $request): Response
    {
        $url = $request->get('url');
        $code = $this->encoder->encode($request->get('url'));
        //return $this->redirectToRoute('url_stats',  );
        $a = $this->redirectToRoute('url_stats',['code'=>$code]);
        return $this->redirectToRoute('url_stats',['code'=>$code]);
    }

    #[Route('/decode',
        methods: ['POST']
    )]
    public function decodeAction (Request $request): Response
    {
        $rqst = $request->get('code');
        $code = $this->decoder->decode($rqst);

        return new Response($code);
    }

    #[Route('/{code}',
        requirements:['code' => '\w{6,8}'],
        methods: ['GET']
    )]
    public function redirectAction (string $code): Response
    {
        try{
            $url = $this->urlService->getUrlByCodeAndIncrement($code);
            $response = new RedirectResponse($url->getUrl());

        }   catch (\Throwable $e) {
            $response = new RedirectResponse($e->getMessage(), 400);
        }
        return  $response;
    }


    #[Route('/code/{code}/stat', name: 'url_stats',  methods: ['get'])] //requirements: ['code' => '\w{6,8}'],
    public function redirectStatisticAction(string $code): Response
    {
        $vars = [
            'code' => $code,
            //'links' => [
            //    'new_url' => $this->container->get('router')->getRouteCollection()->get('add_new_url')->getPath()
            //]
        ];
        try {
             $url = $this->urlService->getUrlByCode($code);
             //$url->setCreatedAt(date('Y-m-d H:i:s'));
             $vars = $vars + [
                    'url_info' => $url,
                    ];
             $template = 'url_test.html.twig';
             //$template = 'url_statistic.html.twig';

        } catch (\Throwable $e) {
            $response = new Response($e->getMessage(), 400);
            $vars = $vars + [
                    'error' => $e
                ];
            $template = 'error.html.twig';
        }
        //return $this->render($template, $vars);
        return $this->render($template, $vars);
    }


    #[Route('/code/new', name: 'add_new_url', methods: ['GET'])]
    public function addCodePageAction(): Response
    {

        return $this->render('url_create.html.twig',[
            'form_action' => $this->generateUrl('encode_url')
        ]);
    }


}