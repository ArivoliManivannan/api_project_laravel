<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportEmployee implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'name' =>  $row[0],
            'email' => $row[1],
            'salary' => $row[2],
            'doj' => $row[3],
            'img' => $row[4],
            'gender' => $row[5],
            'phone' => $row[6]
        ]);
    }
}
