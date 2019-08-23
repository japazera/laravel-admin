<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AdminUserTesting;

class HomeControllerTest extends TestCase
{
	use DatabaseTransactions;
	use AdminUserTesting;

	/** @test */
	public function site_home()
	{
		$this->get(route('site.home'))->assertOk();
	}

	/** @test */
	public function admin_home()
	{
		$this->actingAs($this->createAdminUser());

		$this->get(route('home'))->assertOk();
	}
}
