<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCall extends Model
{
    protected $fillable = ['user_id', 'token_number', 'room_number', 'patient_status'];

    
}
