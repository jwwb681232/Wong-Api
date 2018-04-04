<?php

namespace App\Api\V1\Controllers\Member;

use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    /**
     * 返回JSON格式的Swagger定义
     *
     * 这里需要一个主`Swagger`定义：
     * @SWG\Swagger(
     *   @SWG\Info(
     *     title="YYJobs 用户端接口文档V1",
     *     version="v1"
     *   )
     * )
     */
    public function getJson()
    {
        // 你可以将API的`Swagger Annotation`写在实现API的代码旁，从而方便维护，
        // `swagger-php`会扫描你定义的目录，自动合并所有定义。这里我们直接用`Controller/`
        // 文件夹。
        //$swagger = \Swagger\scan(app_path('Api/V1/Controllers/Business'));
        $swagger = \Swagger\scan(app_path('Api/V1/Controllers/'),['exclude'=>app_path('Api/V1/Controllers/Other')]);
        return response()->json($swagger, 200);
    }
}