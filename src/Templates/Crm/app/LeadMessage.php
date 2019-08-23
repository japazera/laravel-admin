<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lead;

class LeadMessage extends Model
{
	/**
	* The message that belong to the lead.
	*/
   public function lead()
   {
	   return $this->belongsToOne(Lead::class);
   }
}
