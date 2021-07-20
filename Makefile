build-and-run:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	php composer.phar install
	cp .env.example .env
	[[ -f /tmp/cbkhlp.sqlite ]] || touch /tmp/cbkhlp.sqlite
	php artisan migrate
	php artisan db:seed
	npm install
	npm run dev
	php artisan serve
