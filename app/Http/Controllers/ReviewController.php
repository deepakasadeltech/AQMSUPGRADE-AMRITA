<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReviewRepository;
use App\Models\Setting;
use App\Models\Department;
use App\Models\User;
use App\Models\Counter;
use App\Models\QueueSetting;
use App\Models\ParentDepartment;
use App\Models\UhidMaster;
use App\Models\Queue;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class ReviewController extends Controller
{
    protected $review;

    public function __construct(ReviewRepository $review)
    {
        $this->review = $review;
    }

   

}
