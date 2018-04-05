<?php

namespace App\Api\V1\Repositories;

use Hash;
use App\Models\MemberInfo;
use Prettus\Repository\Eloquent\BaseRepository;
class EmployeeInfoRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return MemberInfo::class;
    }

    public function getInfo($user)
    {
        $info = $this->findWhere(['member_id' => $user['member_id']])->first();

        $availabilityRep = app(AvailabilityRepository::class);
        $availability['availability'] = $availabilityRep->findWhere(['member_id' => $user['member_id']])->toArray();
        foreach ($availability['availability'] as $key=>$item) {
            $availability['availability'][$key]['day'] = $availabilityRep->week[$item['day']];
        }
        return $info ? array_merge($user, $info->toArray(),$availability) : $user;
    }

    public function edit($member,$request)
    {
        if ($request['password'] && $request['password_confirmation']){
            if (empty($request['old_password'])){
                return ['error'=>1,'Please enter the old password!'];
            }
            if ($request['password'] != $request['password_confirmation']){
                return ['error'=>1,'Confirm password is incorrect!'];
            }
            if (!Hash::check($request['old_password'], $member['member_password'])) {
                return ['error' => 1, 'msg' => 'The old password is incorrect!'];
            }

            $memberData = [
                'member_password' => bcrypt($request['password']),
                'member_mobile' => $request['mobile_no'],
            ];
            if (isset($request['member_avatar'])){
                $memberData['member_avatar'] = $request['member_avatar'];
            }

            $employeeRep = app(EmployeeRepository::class);
            $employeeRep->update($memberData,$member['member_id']);
        }

        $availabilityRep = app(AvailabilityRepository::class);

        $availabilityRep->model->where('member_id',$member['member_id'])->delete();

        foreach ($request['availabilitys'] as $key=>$value) {
            $request['availabilitys'][$key]['member_id'] = $member['member_id'];
        }

        $request['availabilitys'][1] = $request['availabilitys'][0];
        $availabilityRep->model->insert($request['availabilitys']);

        return ['error' => 0, 'data' => $this->getInfo($member) ,'msg'=>'Successfully modified!'];
    }

    public function editAdditional($member,$request)
    {
        $this->editMemberData($member['member_id'],$request);
        $this->editMemberInfoData($member['member_id'],$request);
        return ['error'=>0,'data'=>$this->getInfo($member),'msg'=>'Successfully modified!'];
    }

    private function editMemberData($memberId,$request)
    {
        $member = [
            'member_sex' => $request->input('gender'),
            'member_birthday' => $request->input('birthdate'),
            'member_school_id' => $request->input('school'),
            'member_email' => $request->input('email'),
        ];

        $memberRep = app(EmployeeRepository::class);
        return $memberRep->update($member,$memberId);
    }

    private function editMemberInfoData($memberId,$request)
    {
        $info = [
            'info_religion' => $request->input('religion'),
            'info_address' => $request->input('address'),
            'info_school_expiry_date' => $request->input('school_pass_expiry_date'),
            'info_bank_statement' => $request->input('bank_account'),
            'info_language' => strtolower(str_replace('，',',',$request->input('language'))),
            'info_emergency_name' => $request->input('emergency_name'),
            'info_emergency_phone' => $request->input('emergency_contact_no'),
            'info_emergency_relationship' => $request->input('emergency_relationship'),
            'info_emergency_address' => $request->input('emergency_address'),
            'info_contact_method' => $request->input('contact_method'),
            'info_criminal_record' => $request->input('criminal_record'),
            'medication' => $request->input('info_medication'),
        ];

        $fileRepository = app(FileRepository::class);
        if ($request->file('ic_front')){
            $info['info_nric_zheng'] = $fileRepository->imageReSize( request()->file('ic_front'),generateFilePath());
        }
        if ($request->file('ic_back')){
            $info['info_nric_fan'] = $fileRepository->imageReSize( request()->file('ic_back'),generateFilePath());
        }
        if ($request->file('signature')){
            $info['info_signature'] = $fileRepository->imageReSize( request()->file('signature'),generateFilePath());
        }

        $addInfo = $this->findWhere(['member_id'=>$memberId])->first();
        if ($addInfo){
            return $this->update($info,$addInfo->info_id);
        }

        return $this->create($info);
    }


}