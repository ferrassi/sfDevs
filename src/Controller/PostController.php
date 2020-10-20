<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use App\Entity\Post;

class PostController
{
    /**
     * @Route("/", name="")
     */
    public function __invoke(SerializerInterface $serializer)
    {
        $data = <<<EOF
        {
            "header": {
            "error": 0,
            "message": "ok",
            "next": 2
            },
            "results": [
            {
            "id": 17007,
            "title": "test article title 1",
            "publishedAt": "28/09/2020"
            },
            {
            "id": 17008,
            "title": "sample article 2",
            "publishedAt": "28/09/2020"
            }
            ]
        }
        EOF;
        $json = json_encode(json_decode($data)->results);
        $normalizers = array(new ObjectNormalizer(),new  GetSetMethodNormalizer());
        $encoders = array(new JsonEncoder());
        $serializer = new Serializer($normalizers, $encoders);
        $posts = $serializer->deserialize($json, Post::class . '[]', 'json');

dd($posts); exit;
        return new Response(
            $posts
        );
    }
}