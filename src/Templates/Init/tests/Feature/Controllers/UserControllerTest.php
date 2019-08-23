<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AdminUserTesting;
use App\User;

class UserControllerTest extends TestCase
{
	use DatabaseTransactions;
	use AdminUserTesting;
	use WithFaker;

	/** @test */
    public function index()
    {
		$this->actingAs($this->createAdminUser());

		$this->get(route('user.index'))->assertOk();
    }

	/** @test */
    public function create()
    {
		$this->actingAs($this->createAdminUser());

		$this->get(route('user.create'))->assertOk();
    }

	/** @test */
    public function store()
    {
		$this->actingAs($this->createAdminUser());

		$response = $this->post(route('user.store'), [
			'name' => 'name',
			'email' => 'email',
			'password' => 'password',
		]);

		$last_user = User::orderBy('created_at', 'desc')->first();

		$response->assertRedirect(route('user.index'));
    }

	/** @test */
    public function edit()
    {
		$this->actingAs($this->createAdminUser());

		$user = new User([
			'name' => 'name',
			'email' => 'email',
			'password' => 'password',
        ]);
		$user->save();

		$this->get(route('user.edit', $user->id))->assertOk();
    }

	/** @test */
    public function update()
    {
		$this->actingAs($this->createAdminUser());

		$user = new User([
			'name' => 'name',
			'email' => 'email',
			'password' => 'password',
        ]);
		$user->save();

		$response = $this->put(route('user.update', $user->id), [
			'name' => 'name1',
			'email' => 'email1',
			'password' => 'password1',
		]);

		$response->assertRedirect(route('user.index'));

		$this->assertEquals('name1', User::find($user->id)->name);
    }

	/** @test */
    public function update_without_password()
    {
		$this->actingAs($this->createAdminUser());

		$user = new User([
			'name' => 'name',
			'email' => 'email',
			'password' => 'password',
        ]);
		$user->save();

		$old_password = $user->password;

		$response = $this->put(route('user.update', $user->id), [
			'name' => 'name1',
			'email' => 'email1',
			'password' => '',
		]);

		$response->assertRedirect(route('user.index'));

		$this->assertEquals($old_password, User::find($user->id)->password);
    }

	/** @test */
    public function destroy()
    {
		$this->actingAs($this->createAdminUser());

		$user = new User([
			'name' => 'name',
			'email' => 'email',
			'password' => 'password',
        ]);
		$user->save();

		$this->delete(route('user.destroy', $user->id))->assertRedirect(route('user.index'));

		$this->assertNull(User::find($user->id));
    }
}
