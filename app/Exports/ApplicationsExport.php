<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Application::all()->where("User_id",Auth::user()->id);
    }

    public function headings(): array
    {
        return [
            '#',
            'Time',
            'First_Name',
            'Last_Name',
            'Email',
            'Nationality',
            'Birthday',
            'Position',
            'First_Time',
            'CV',
            'Biography',
            'Motivation_Letter',
            'User_id',
            'Users_Access',
            'seen',
            'flag',
            'incomplete',
            'accepted',
            'rejected',
            'stars',
            'created at',
            'updated at'
        ];
    }
}
