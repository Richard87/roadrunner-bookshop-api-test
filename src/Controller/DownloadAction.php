<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class DownloadAction
{
    public function __invoke(Request $request): Response
    {
        $request->getSession()->set("Hello", "world!");
        dump($request->getSession()->get("Hello"));

        $type = $request->query->get("type", "binary");
        $file  = __DIR__ . "/../../public/20150428-cloud-computing.0.1489222360.0.webp";
        $headers = ["Content-type" => "image/webp"];
        BinaryFileResponse::trustXSendfileTypeHeader();
        return match($type) {
            "streaming" => new StreamedResponse(fn() => readfile($file),headers: $headers),
            default => new BinaryFileResponse($file,headers: $headers),
        };
    }
}
