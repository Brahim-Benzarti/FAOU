<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Application::all()->where("User_id",Auth::user()->id);
    }

    public function map($row): array{
        return [
            $row->Time,
            $row->First_Name,
            $row->Last_Name,
            $row->Email,
            $row->Nationality,
            $row->Birthday,
            $row->Position,
            $row->First_Time,
            $row->CV,
            $row->Biography,
            $row->Motivation_Letter,
            $row->seen,
            $row->flag,
            $row->accepted,
            $row->rejected,
            $row->stars,
            $row->incomplete,
            $row->new,
            $row->interviewed,
            $row->mailed
        ];
    }
    public function headings(): array
    {
        return [
            'Submission Time',
            'First Name',
            'Last Name',
            'Email',
            'Nationality',
            'Birthday',
            'Position you want to apply for',
            'Is this your first time applying',
            'Share your linkedin profile or online CV',
            'Brief biography max 1000 character',
            'Motivation Letter max 3000 character',
            'Seen',
            'Flag',
            'Accepted',
            'Rejected',
            'Stars',
            'Incomplete',
            'New',
            'Interviewed',
            'Mailed'
        ];
    }
}
