<?php
if (!function_exists('apiReturn')) {

    /**
     * api 接口返回格式规范
     * @param string $status
     * @param array $data
     * @param int $code
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    function apiReturn($data = [],$code = 0 ,$msg = '',$status = '')
    {
        $code   = empty($code)      ? 200       : $code;
        $status = empty($status)    ? 'success' : $status;
        $message= empty($msg)       ? 'success' : $msg;

        switch ($code) {
            case 301 :
            case 400 :
            case 403 :
            case 404 :
            case 405 :
            case 500 :
                $status = 'error';
                break;
        }
        //默认200
        if ($code == 200){
            return response()->json(compact('status','data','code','message'));
        }
        return response()->json(compact('status','code','msg'));
    }
}

if (!function_exists('generateFilePath')) {

    /**
     * 生成统一文件存储路径
     * @return string
     */
    function generateFilePath()
    {
        return 'public/'.date('Ym').'/'.date('d').'/';
    }
}

if (!function_exists('generateFileUrl')) {

    /**
     * 生成文件url
     * @param string $filePath storage相对路径
     * @return string   完整url（需要配置APP_URL，切记，所有想被公开访问的文件都应该放在 storage/app/public 目录下。此外，你应该在public/storage [创建符号链接 ] (#the-public-disk) 来指向 storage/app/public 文件夹。）
     */
    function generateFileUrl($filePath)
    {
        return env('APP_URL').Storage::url($filePath);
    }
}


