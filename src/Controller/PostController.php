<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;


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
        $normalizers = array(
            new DateTimeNormalizer([
                DateTimeNormalizer::FORMAT_KEY => "d/m/Y",
            ]),
            new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor()
            ),
            new GetSetMethodNormalizer(),
            new ArrayDenormalizer(),
        );      
        
        $encoders = array(new JsonEncoder());

        $serializer = new Serializer($normalizers, $encoders);
        $posts = $serializer->deserialize($json, Post::class . '[]', 'json', [
            DateTimeNormalizer::FORMAT_KEY => "d/m/Y",
        ]);

dd($posts); exit;

    } 
}