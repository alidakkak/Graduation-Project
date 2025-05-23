<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function workSchedules()
    {
        return $this->hasOne(WorkSchedule::class);
    }

    public function examSchedules()
    {
        return $this->hasOne(ExamSchedule::class);
    }
}
