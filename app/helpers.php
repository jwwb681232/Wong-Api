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


