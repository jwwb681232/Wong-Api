<?php

namespace App\Api\V1\Repositories;

use Validator;
use App\Models\Member;
use Prettus\Repository\Eloquent\BaseRepository;

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

    public function registerForMobile($request)
    {
        $validator = Validator::make(
            $request,
            [
                'name'      => 'required',
                'password'  => 'required',
                'email'     => 'required',
                'nric_no'   => 'required',
                'mobile_no' => 'required',
            ]
        );
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
        ];

        if ($res = $this->create($data)) {
            $token = auth('member')->attempt(['member_id' => $res->member_id]);

            return ['error' => 0, 'data' => $token, 'msg' => 'Registration Success!'];
        }

        return ['error' => 1, 'msg' => 'Invalid Data'];

    }

    public function isExist($data)
    {
        return $this->model->where('member_name', $data['name'])->orWhere('member_nric', $data['nric_no'])
            ->orWhere('member_mobile', $data['mobile_no'])->first();
    }
}