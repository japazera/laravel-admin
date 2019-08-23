<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeadMessage;
use App\LeadField;
use DB;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
    ];

	public function messages()
	{
		return $this->belongsToMany(LeadMessage::class, 'leadmessage_lead', 'lead_id', 'leadmessage_id');
	}

	public function fields()
	{
		return $this->hasMany(LeadField::class, 'lead_id', 'id');
	}

	public function assignMessage(LeadMessage $message)
	{
		DB::table('leadmessage_lead')->insert([
			'lead_id' => $this->id,
			'leadmessage_id' => $message->id
		]);
	}

	public function clearNewMessages()
	{
		$this->new_messages = 0;
		$this->save();
	}
}
