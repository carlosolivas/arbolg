<?php
namespace s4h\social;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider {
	public function register() {
		$this->app->bind(
			's4h\social\GroupRepositoryInterface',
			's4h\social\DbGroupRepository'
		);
	}
}
