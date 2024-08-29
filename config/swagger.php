<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Library API",
 *     version="1.0.0",
 *     description="API documentation for the Library application"
 * )
 */

return [
    'defaults' => [
        'docs' => [
            'title' => 'Library API',
            'description' => 'API documentation for the Library application',
            'version' => '1.0.0',
            'swagger_version' => '3.0',
            'urls' => [
                'api' => 'docs',
            ],
        ],
    ],
];
