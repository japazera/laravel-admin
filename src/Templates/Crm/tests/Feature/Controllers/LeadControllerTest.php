<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AdminUserTesting;
use App\Lead;

class LeadControllerTest extends TestCase
{
	use DatabaseTransactions;
	use AdminUserTesting;
	use WithFaker;

	/** @test */
    public function index()
    {
		$this->actingAs($this->createAdminUser());

		$this->get(route('lead.index'))->assertOk();
    }

	/** @test */
    public function create()
    {
		$this->actingAs($this->createAdminUser());

		$this->get(route('lead.create'))->assertOk();
    }

	/** @test */
    public function store()
    {
		$this->actingAs($this->createAdminUser());

		$response = $this->post(route('lead.store'), [
			'name' => 'name',
			'email' => 'email@test.com',
		]);

		if($response->exception) {
			dd($response->exception->getMessage());
		}

		$this->assertNull($response->exception, 'Exception found.');
        $this->assertNull(session('errors'), 'Errors message found.');
        $this->assertNull(session('danger'), 'Danger message found.');
    }

	/** @test */
    public function edit()
    {
		$this->actingAs($this->createAdminUser());

		$lead = new Lead([
			'name' => 'name',
			'email' => 'email',
        ]);
		$lead->save();

		$this->get(route('lead.edit', $lead->id))->assertOk();
    }

	/** @test */
    public function update()
    {
		$this->actingAs($this->createAdminUser());

		$lead = new Lead([
			'name' => 'name',
			'email' => 'email',
        ]);
		$lead->save();

		$response = $this->put(route('lead.update', $lead->id), [
			'name' => 'name1',
			'email' => 'email@test.com',
		]);

		if($response->exception) {
			dd($response->exception->getMessage());
		}

		$this->assertNull($response->exception, 'Exception found.');
        $this->assertNull(session('errors'), 'Errors message found.');
        $this->assertNull(session('danger'), 'Danger message found.');

		$this->assertEquals('name1', Lead::find($lead->id)->name);
    }

	/** @test */
    public function destroy()
    {
		$this->actingAs($this->createAdminUser());

		$lead = new Lead([
			'name' => 'name',
			'email' => 'email',
        ]);
		$lead->save();

		$this->delete(route('lead.destroy', $lead->id))->assertRedirect(route('lead.index'));

		$this->assertNull(Lead::find($lead->id));
    }
}
