<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Cookie;

class AgeVerification extends Component
{
    public function shouldShowModal()
    {
        $visitorData = Cookie::get('visitor_data');

        if ($visitorData) {
            $visitor = json_decode($visitorData, true);

            return !(isset($visitor['age_verified']) && $visitor['age_verified'] === true);
        }

        return true;
    }

    public function render()
    {
        return view('components.age-verification');
    }
}
