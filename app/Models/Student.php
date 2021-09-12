<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'common_name',
        'name_format',
        'display_name',
        'gender',
        'dob',
        'ethnicity',
        'language',
        'identification',
        'school_id',
        'guardian1_first',
        'guardian1_last',
        'guardian1_common',
        'guardian1_format',
        'guardian1_display',
        'guardian1_phone',
        'guardian1_email',
        'guardian2_first',
        'guardian2_last',
        'guardian2_common',
        'guardian2_format',
        'guardian2_display',
        'guardian2_phone',
        'guardian2_email',
        'address1',
        'address2',
        'address3',
        'address4',
        'city',
        'state',
        'country',
        'postal_code',
        'area_code',
        'phone',
        'email',
        'avatar',
        'enrollment_date',
        'source',
        'grade_id',
        'status',
        'centre_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'dob' => 'date',
        'school_id' => 'integer',
        'enrollment_date' => 'date',
        'grade_id' => 'integer',
        'centre_id' => 'integer',
    ];


    public function school()
    {
        return $this->belongsTo(\App\Models\School::class);
    }

    public function grade()
    {
        return $this->belongsTo(\App\Models\Grade::class);
    }

    public function centre()
    {
        return $this->belongsTo(\App\Models\Centre::class);
    }

    public function getAllNamesAttribute()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->common_name;
    }

    public function guardian()
    {
        return $this->hasOne(\App\Models\Guardian::class);
    }

    public function scheduleClassers()
    {
        return $this->hasMany(\App\Models\ScheduleClasser::class);
    }

    public function scheduleClassersForDetailsRow()
    {
        return $this->hasMany(\App\Models\ScheduleClasser::class)->whereNull('withdrawl_date')->orWhereDate('withdrawl_date', '>', Carbon::now()->toDateString())->orderBy('enrollment_date');
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }

    public function getDateAttendanceLesson($date, $classer_id)
    {
        $attendance = $this->attendances->where('lesson_date', '=', $date)->where('classer_id', $classer_id)->first();

        if ($attendance) {
            return $attendance->lesson_id;
        }

        return "";
    }

    public function getDisplayStudentName()
    {
        if (strtoupper($this->name_format) == 'WESTERN') {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->last_name . ' ' . $this->first_name;
        }
    }

/*    public function getDisplayNames()
    {
        if (strtoupper($this->name_format) == 'WESTERN') {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->last_name . ' ' . $this->first_name;
        }

         if (strtoupper($this->crud->getRequest()->input('name_format')) == "WESTERN") {
                $displayName = $this->crud->getRequest()->input('first_name') . ' ' . $this->crud->getRequest()->input('last_name');
            } else {
                $displayName = $this->crud->getRequest()->input('last_name') . ' ' . $this->crud->getRequest()->input('first_name');
            }

            if (strtoupper($this->crud->getRequest()->input('name_format')) == "WESTERN") 
            {
                if ($this->crud->getRequest()->input('common_name') == '') 
                {
                    $displayName = $this->crud->getRequest()->input('first_name') . ' ' . $this->crud->getRequest()->input('last_name');
                } 
                else 
                {
                $displayName = $this->crud->getRequest()->input('common_name') . ' ' . $this->crud->getRequest()->input('last_name');
                }
            }
            else
            {
                $displayName = $this->crud->getRequest()->input('last_name') . ' ' . $this->crud->getRequest()->input('first_name');
            }

            return $displayName;

    }
*/
    public function getDisplayAddress()
    {
        return ($this->address1 ? $this->address1 . ', ' : '') . ($this->address2 ? $this->address2 . ', ' : '') . ($this->city ? $this->city . ', ' : '') . ($this->state ? $this->state . ' - ' : '') . $this->postal_code;
    }

    public function getClass()
    {
        if ($this->scheduleClassers->count() > 0) {
            return "<span>" . $this->scheduleClassers->sortBy('enrollment_date')->first()->classer->short_name . "</span>";
        }

        return '';
    }
}
