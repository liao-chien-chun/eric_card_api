<?php

namespace App\Swagger;

/**
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 *   in="header",
 *   name="Authorization",
 *   description="請輸入JWT token"
 * )
 */
class SecuritySchemes
{
}
