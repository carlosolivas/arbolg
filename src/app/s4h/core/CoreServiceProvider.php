<?php
namespace s4h\core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {
	public function register() {
		$this->app->bind(
			's4h\core\FileRepositoryInterface',
			's4h\core\DbS3FileRepository'
		);

		$this->app->bind(
			's4h\core\PersonRepositoryInterface',
			's4h\core\DbPersonRepository'
		);

		$this->app->bind(
			's4h\core\UserRepositoryInterface',
			's4h\core\DbUserRepository'
        );

        $this->app->bind(
            's4h\core\RoleRepositoryInterface',
            's4h\core\DbRoleRepository'
		);

        $this->app->bind(
            's4h\core\CountryRepositoryInterface',
            's4h\core\DbCountryRepository'
        );

        $this->app->bind(
            's4h\core\StateRepositoryInterface',
            's4h\core\DbStateRepository'
        );

        $this->app->bind(
            's4h\core\CountyRepositoryInterface',
            's4h\core\DbCountyRepository'
        );

        $this->app->bind(
            's4h\core\CityRepositoryInterface',
            's4h\core\DbCityRepository'
        );

        $this->app->bind(
            's4h\core\SuburbRepositoryInterface',
            's4h\core\DbSuburbRepository'
        );

        $this->app->bind(
            's4h\core\ZipcodeRepositoryInterface',
            's4h\core\DbZipcodeRepository'
        );
	}
}
