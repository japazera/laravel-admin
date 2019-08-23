<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AdminUserTesting;
use App\[MODEL];

class [MODEL]Test extends TestCase
{
	use DatabaseTransactions;
	use AdminUserTesting;
	use WithFaker;

    /** @test */
    public function index()
    {
		$this->actingAs($this->createAdminUser());

		$this->get('/admin/[MODEL_LOWER]')->assertOk();
    }

	/** @test */
    public function create()
    {
		$this->actingAs($this->createAdminUser());

		$this->get('/admin/[MODEL_LOWER]/create')->assertOk();
    }

	/** @test */
    public function store()
    {
		$this->actingAs($this->createAdminUser());

		$response = $this->post('/admin/[MODEL_LOWER]', [
[FIELD_NAME_STORE]
		]);

		$last_[MODEL_LOWER] = [MODEL]::orderBy('created_at', 'desc')->first();

		$response->assertRedirect('/admin/[MODEL_LOWER]');
    }

	/** @test */
    public function edit()
    {
		$this->actingAs($this->createAdminUser());

		$[MODEL_LOWER] = new [MODEL]([
[FIELD_NAME_STORE]
        ]);
		$[MODEL_LOWER]->save();

		$this->get("/admin/[MODEL_LOWER]/$[MODEL_LOWER]->id/edit/")->assertOk();
    }

	/** @test */
    public function update()
    {
		$this->actingAs($this->createAdminUser());

		$[MODEL_LOWER] = new [MODEL]([
[FIELD_NAME_STORE]
        ]);
		$[MODEL_LOWER]->save();

		$this->put('/admin/[MODEL_LOWER]/' . $[MODEL_LOWER]->id, [
[FIELD_NAME_UPDATE]
		])->assertRedirect('/admin/[MODEL_LOWER]/');

		$this->assertEquals('[FIELD_NAME_FIRST]1', [MODEL]::find($[MODEL_LOWER]->id)->[FIELD_NAME_FIRST]);
    }

	/** @test */
    public function destroy()
    {
		$this->actingAs($this->createAdminUser());

		$[MODEL_LOWER] = new [MODEL]([
[FIELD_NAME_STORE]
        ]);
		$[MODEL_LOWER]->save();

		$this->delete('/admin/[MODEL_LOWER]/' . $[MODEL_LOWER]->id)->assertRedirect('/admin/[MODEL_LOWER]/');

		$this->assertNull([MODEL]::find($[MODEL_LOWER]->id));
    }
}
