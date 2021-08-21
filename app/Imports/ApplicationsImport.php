<?php

namespace App\Imports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;


class ApplicationsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $headingShouldBe=["Submission Time","First Name","Last Name","Email","Nationality","Birthday","Position you want to apply for","Is this your first time applying?","Share your LinkedIn Profile OR Online CV","Brief Biography (Max 1000 Character)","Motivation Letter (Max 3000 Charcter)"];
        return new Application([
            "Time"=> $row['submission_time'],
            "First_Name"=> $row['first_name'],
            "Last_Name"=> $row['last_name'],
            "Email"=> strlen($row['email'])<1000 ? $row['email'] : Null,
            "Nationality"=>$row['nationality'],
            "Birthday"=>$row['birthday'],
            "Position"=>$row['position_you_want_to_apply_for'],
            "First_Time"=>$row['is_this_your_first_time_applying'],
            "CV"=> strlen($row['share_your_linkedin_profile_or_online_cv'])<1000 ? $row['share_your_linkedin_profile_or_online_cv'] : Null,
            "Biography"=>$row['brief_biography_max_1000_character'],
            "Motivation_Letter"=>$row['motivation_letter_max_3000_charcter'],
            "User_id"=>Auth::user()->id
        ]);
    }
}
