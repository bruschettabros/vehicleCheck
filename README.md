# Vehicle check
### Description
Simple web app that checks for a vehicle via make, model and registration

Instructions are written with [Laravel Sail](https://laravel.com/docs/10.x/sail) in mind
### Installation
1. Clone the repository and `cd` into it
2. Install the dependencies with
```
composer install
```
and
```
npm install
```
3. Create a .env file, you can create a copy of the example
```
cp .env.example .env
```
4. Generate the application key
```
php artisan key:generate
```
5. Run sail
```
make up
```

### Testing
You can run FE tests with:
```
test-frontend
```
And BE tests with:
```
test-backend
```

### Good to know
- The app uses [Laravel Sail](https://laravel.com/docs/10.x/sail) for local development
- Run `npm run dev` to compile the assets
- Run `make down` to stop the containers
- You can seed the database with `make seed` (This will generate 10 vehicles)
