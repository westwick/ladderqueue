<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonRegistration extends Model
{
    public function getStatusString()
    {
        if(! $this->paid) {
            return 'Received, Pending Payment';
        } else {
            if(! $this->accepted) {
                return 'Pending Admin Approval';
            } else {
                return 'Approved - your team has been accepted into season 3!';
            }
        }
    }
}
