<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\LeadAd;
use App\LeadMessage;
use App\LeadField;
use App\User;
use App\Mail\NewLead;
use Mail;
use Auth;

class LeadController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return view('admin.lead.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.lead.create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' 	=> 'required|max:255',
			'email' => 'required|email|unique:leads|max:255'
		]);

		$lead = Lead::create($request->all());

		return redirect()->route('lead.edit', $lead->id)->with('success', 'Lead cadastrado.');
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\Lead  $lead
	* @return \Illuminate\Http\Response
	*/
	public function edit(Lead $lead)
	{
		$lead->clearNewMessages();

		return view('admin.lead.edit', compact('lead'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\Lead  $lead
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, Lead $lead)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:leads,email,' . $lead->id
		]);

		$lead->update($request->all());

		return redirect()->route('lead.index')->with('success', 'Lead atualizado.');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Lead  $lead
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Lead $lead)
	{
		$lead->delete();
		return redirect()->route('lead.index')->with('success', 'Lead descartado.');
	}

	public function send(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
			'email' => 'required|max:255',
			'message' => 'max:255',
		]);

		// find lead
		$lead = Lead::where('email', $request->email)->first();

		// create lead if not found
		if($lead == null) {
			$lead = new Lead();
		}

		// set fields
		$lead->name 		= $request->name;
		$lead->email 		= $request->email;
		if($request->utm_source) {
			$lead->utm_source 	= $request->utm_source;
		}
		if($request->utm_medium) {
			$lead->utm_medium 	= $request->utm_medium;
		}
		if($request->utm_campaign) {
			$lead->utm_campaign = $request->utm_campaign;
		}
		if($request->utm_term) {
			$lead->utm_term 	= $request->utm_term;
		}

		// increment new messages
		$lead->new_messages += 1;

		try {
			// save to db
			$lead->save();

			// save message
			$message = null;
			if($request->message) {
				$message          = new LeadMessage();
				$message->lead_id = $lead->id;
				$message->body    = $request->message;
				$message->subject = $request->subject;
				$message->save();

				$lead->assignMessage($message);
			}

			// get aditional fields from request
			$array_diff = array_diff_key($request->all(), [
				"nome"         => null,
				"email"        => null,
				"utm_source"   => null,
				"utm_medium"   => null,
				"utm_campaign" => null,
				"utm_term"     => null,
				"message"      => null,
				"_token"       => null,
			]);

			// saving aditional fields
			if(count($array_diff) > 0) {
				foreach ($array_diff as $field => $value) {
					if(LeadField::where(['name' => $field, 'lead_id' => $lead->id])->count() == 0) {
						$lead_field = new LeadField();
					} else {
						$lead_field = LeadField::where(['name' => $field, 'lead_id' => $lead->id])->first();
					}
					$lead_field->lead_id = $lead->id;
					$lead_field->name    = $field;
					$lead_field->value   = $value;
					$lead_field->save();
				}
			}

			// emails
			$emails = User::where('email_notification', true)->get(['email'])->pluck('email')->toArray();
			foreach ($emails as $email) {
				Mail::to($email)
				->queue(new NewLead($lead, $message));
			}

			return redirect('/#contact')->with([
				'success' => 'Mensagem enviada! Entraremos em contato em breve.',
			]);

		} catch(Exception $e) {
			return redirect('/#contact')->with([
				'error' => 'Desculpe, a mensagem não foi enviada.',
			]);
		}
	}

}
