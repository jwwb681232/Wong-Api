<?php
namespace App\Api\V1\Repositories;

use App\Models\EmployerApply;
use Prettus\Repository\Eloquent\BaseRepository;

class EmployerApplyRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return EmployerApply::class;
    }

    public function apply($data)
    {
        if ($this->isExist($data)) {
            return ['error' => 1, 'msg' => 'It\'s Exist'];
        }

        $apply = [
            'apply_name'          => $data['name'],
            'apply_business_name' => $data['business_name'],
            'apply_email'         => $data['email'],
            'apply_contact_no'    => $data['mobile_no'],
            'apply_time'          => time(),
        ];

        if ($res = $this->create($apply)) {
            return ['error' => 0, 'data' => $res, 'msg' => 'Successful application submission'];
        }

        return ['error' => 1, 'msg' => 'Error!'];
    }

    /**
     * 是否存在申请
     * @param $data
     *
     * @return mixed
     */
    public function isExist($data)
    {
        return $this->model->where('apply_name', $data['name'])->orWhere('apply_business_name', $data['business_name'])->first();
    }
}