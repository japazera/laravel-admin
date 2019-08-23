<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithFaker;
use App\User;

trait AdminUserTesting
{
	protected $admin;
	protected $name = 'Admin User';
	protected $email = 'admin@email.com';
	protected $password = 'secret';

	protected function createAdminUser($override = [])
	{
		$newAdmin = [
			'name' => $this->name,
			'email' => rand() .  $this->email,
			'password' => bcrypt($this->password),
			'passwordClean' => $this->password
		];

		$newAdmin = array_replace($newAdmin, $override);

		$this->admin = new User();
		$this->admin->name 			= $newAdmin['name'];
		$this->admin->email 		= $newAdmin['email'];
		$this->admin->password 		= $newAdmin['password'];
		$this->admin->save();

		$this->admin->passwordClean = $newAdmin['passwordClean'];

		return $this->admin;
	}
}
