<?php

namespace App\Api\V1\Repositories;

use Hash;
use Validator;
use App\Models\Member;
use Prettus\Repository\Eloquent\BaseRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class EmployeeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Member::class;
    }

    /**
     * 手机号注册
     * @param $request
     *
     * @return array
     */
    public function registerForMobile($request)
    {
        $validator = $this->validate($request);
        if ($validator->fails()) {
            return ['error' => 1, 'msg' => 'Invalid Data'];
        }
        if ($this->isExist($request)) {
            return ['error' => 1, 'msg' => 'It\'s Exist'];
        }

        $data = [
            'member_name'      => $request['name'],
            'member_password'  => bcrypt($request['password']),
            'member_email'     => $request['email'],
            'member_nric'      => $request['nric_no'],
            'mobile_no'        => $request['mobile_no'],
            'member_school_id' => $request['school'],
            'member_add_time'  => time(),
        ];

        if ($res = $this->create($data)) {
            $token = auth('member')->attempt(['member_id' => $res->member_id]);

            return ['error' => 0, 'data' => $token, 'msg' => 'Registration Success!'];
        }

        return ['error' => 1, 'msg' => 'Invalid Data'];

    }

    /**
     * 脸书注册
     * @param $request
     *
     * @return array
     */
    public function registerForFacebook($request)
    {
        $validator = $this->validate($request);
        if ($validator->fails()) {
            return ['error' => 1, 'msg' => 'Invalid Data'];
        }
        if ($this->isExist($request)) {
            return ['error' => 1, 'msg' => 'It\'s Exist'];
        }

        $fbUser = $this->getFacebookUser($request['social_access_token']);

        if (!empty($request['social_fb_id']) && $fbUser['status_code'] == 200) {
            $userData = [
                'member_name'      => $request['name'],
                'member_email'     => $request['email'],
                'member_nric'      => $request['nric_no'],
                'mobile_no'        => $request['mobile_no'],
                'member_school_id' => $request['school'],
                'social_access_token' => bcrypt($request['social_access_token']),
                'social_fb_id'     => $request['social_fb_id'],
                'member_platform'  => $request['platform'],
                'member_add_time'  => time(),
            ];
            if ($res = $this->create($userData)) {
                $token = auth('member')->attempt(['member_id' => $res->member_id]);

                return ['error' => 0, 'data' => $token, 'msg' => 'Registration Success!'];
            }

            return ['error' => 1, 'msg' => 'Invalid Data'];
        }

        return ['error' => 1, 'msg' => 'Invalid Social Account'];
    }

    /**
     * 谷歌注册
     * @param $request
     *
     * @return array
     */
    public function registerForGoogle($request)
    {
        $validator = $this->validate($request);
        if ($validator->fails()) {
            return ['error' => 1, 'msg' => 'Invalid Data'];
        }
        if ($this->isExist($request)) {
            return ['error' => 1, 'msg' => 'It\'s Exist'];
        }

        $fbUser = $this->getGoogleUser($request['social_access_token']);

        if (!empty($request['social_google_id']) && $fbUser['status_code'] == 200) {
            $userData = [
                'member_name'         => $request['name'],
                'member_email'        => $request['email'],
                'member_nric'         => $request['nric_no'],
                'mobile_no'           => $request['mobile_no'],
                'member_school_id'    => $request['school'],
                'social_access_token' => bcrypt($request['social_access_token']),
                'social_google_id'    => $request['social_google_id'],
                'member_platform'     => $request['platform'],
                'member_add_time'     => time(),
            ];
            if ($res = $this->create($userData)) {
                $token = auth('member')->attempt(['member_id' => $res->member_id]);

                return ['error' => 0, 'data' => $token, 'msg' => 'Registration Success!'];
            }

            return ['error' => 1, 'msg' => 'Invalid Data'];
        }

        return ['error' => 1, 'msg' => 'Invalid Social Account'];
    }

    /**
     * 普通登录
     * @param $request
     *
     * @return array
     */
    public function login($request)
    {
        $member = $this->findWhere(['member_nric'=>$request['nric_no']])->first();
        if (empty($member)){
            return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];
        }

        if ($request['password'] && !Hash::check($request['password'], $member->member_password)) {
            return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];
        }

        if($token = auth()->guard('member')->attempt(['member_id'=>$member->member_id])){
            return ['error' => 0, 'data'=>$token,'msg' => 'Login successful'];
        }

        return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];

    }

    /**
     * 脸书登录
     * @param $request
     *
     * @return array
     */
    public function loginForFacebook($request)
    {
        $member = $this->findWhere(['social_fb_id' => $request['social_fb_id']])->first();
        $fbUser = $this->getFacebookUser($request['social_access_token']);
        if ( ! empty($member['social_fb_id']) || ! empty($member)) {
            if ($fbUser['status_code'] == 200) {
                $token = auth()->guard('member')->attempt(['member_id' => $member->member_id]);

                return ['error' => 0, 'data' => $token, 'msg' => 'Login successful'];
            } else {
                return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];
            }
        } else {
            return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];
        }
    }

    /**
     * 谷歌登录
     * @param $request
     *
     * @return array
     */
    public function loginForGoogle($request)
    {
        $member = $this->findWhere(['social_google_id' => $request['social_google_id']])->first();
        $googleUser = $this->getGoogleUser($request['social_access_token']);
        if ( ! empty($member['social_google_id']) || ! empty($member)) {
            if ($googleUser['status_code'] == 200) {
                $token = auth()->guard('member')->attempt(['member_id' => $member->member_id]);

                return ['error' => 0, 'data' => $token, 'msg' => 'Login successful'];
            } else {
                return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];
            }
        } else {
            return ['error' => 1, 'msg' => 'Please check your credentials or sign up.'];
        }
    }

    /**
     * 是否存在
     * @param $data
     *
     * @return mixed
     */
    public function isExist($data)
    {
        return $this->model->where('member_name', $data['name'])->orWhere('member_nric', $data['nric_no'])
            ->orWhere('member_mobile', $data['mobile_no'])->first();
    }

    /**
     * 验证请求数据
     * @param $request
     *
     * @return mixed
     */
    private function validate($request)
    {
        if (isset($request['password'])) {
            return Validator::make(
                $request,
                [
                    'name'      => 'required',
                    'password'  => 'required',
                    'email'     => 'required',
                    'nric_no'   => 'required',
                    'mobile_no' => 'required',
                ]
            );
        }

        return Validator::make(
            $request,
            ['name' => 'required', 'email' => 'required', 'nric_no' => 'required', 'mobile_no' => 'required']
        );
    }


    /**
     * 获取脸书用户
     * @param $token
     *
     * @return array
     */
    private function getFacebookUser($token)
    {
        $client = new Client(['defaults' => ['verify' => false]]);
        try {
            $response = $client->request(
                'GET',
                config('custom.facebook_endpoint').'/v2.10/me?field=id,name,email&&access_token='.$token
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body'        => $response->getBody(),
            ];


        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $body = $e->getResponse()->getBody();
                $status = $e->getResponse()->getStatusCode();

                return [
                    'status_code' => $status,
                    'body'        => $body,
                ];

            }
        }
    }

    /**
     * 获取谷歌用户
     * @param $token
     *
     * @return array
     */
    private function getGoogleUser($token)
    {
        $client = new Client(['defaults' => ['verify' => false]]);
        try {
            $response = $client->request(
                'GET',
                config('custom.google_endpoint').'/oauth2/v3/tokeninfo?id_token='.$token
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body'        => $response->getBody(),
            ];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                $body = $e->getResponse()->getBody();
                $status = $e->getResponse()->getStatusCode();

                return [
                    'status_code' => $status,
                    'body'        => $body,
                ];

            }
        }
    }



}