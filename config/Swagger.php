<?php

// 定義一個常量，將從 .env 文件讀取 L5_SWAGGER_CONST_HOST 的值
define('L5_SWAGGER_CONST_HOST', env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000/api'));


/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="eric_card_api",
 *     version="1.0.0",
 *     description="參照dcard 做出來的 API",
 *     @OA\Contact(
 *       email="support@example.com",
 *       name="支援團隊"
 *     )
 *   ),
 *   @OA\Server(
 *     description="API 服務器",
 *     url=L5_SWAGGER_CONST_HOST
 *   ),
 * )
 */
class SwaggerDocs
{
}
