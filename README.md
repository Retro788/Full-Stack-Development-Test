`      $$$$$$$\   $$$$$$\ $$$$$$$$\         $$$$$$\  `
`     $$  __$$\ $$ ___$$\\__$$  __|       $$$ __$$\ `
`    $$ |  $$ |\_/   $$ |  $$ | $$$$$$\  $$$$\ $$ |`
`   $$$$$$$  |  $$$$$ /   $$ |$$  __$$\ $$\$$\$$ | `
`  $$  __$$<   \___$$\   $$ |$$ |  \__|$$ \$$$$ |`
` $$ |  $$ |$$\   $$ |  $$ |$$ |      $$ |\$$$ |`
`$$ |  $$ |\$$$$$$  |  $$ |$$ |      \$$$$$$  /`
`\__|  \__| \______/   \__|\__|       \______/ `

# User-Management-System
## Create a straightforward yet resilient web app for user account management. This encompasses features like user registration, logging in, browsing, modifying, and removing user profiles.


## Requirements
Ensure PHP version 8.1 or newer is installed. Node.js version 12.0 or higher is also required.


## Installation

#### Backend

1. Duplicate the project repository.
2. Navigate to the project's root directory.
     *Move the .env.example file to `.env` using the command `mv .env.example .env`*
3. Execute `composer install.`
4. Generate the encryption key with `php artisan key:generate --ansi`
5. Create a database `named: usersystem`
        *To create the database, go to your cmd, access mysql and enter your login, enter the command and a sqlite database will be created.*
6. Migrate the database with `php artisan migrate --seed`
7. Duplicate .env.example and rename it to .env, then adjust the parameters.
8. Start the project with `v` and access it at http://localhost:8000
9. Open a new terminal window and navigate to the project's root directory.
10. Execute `npm install.`
11. Launch the Vite server for Laravel frontend with `npm run dev.`


#### Frontend
1. Navigate to `frontend` folder using terminal
2. Run `npm install` to install vue.js project dependencies
3. Copy `frontend/.env.example` into `frontend/.env` using `cp .env.example .env` and specify API URL
4. Start frontend by running `npm run dev`
5. Open http://localhost:3000

### Running PhpUnit Tests
To execute tests using PhpUnit, follow these steps:

    Open a terminal.
    Navigate to the Laravel project's root directory.
    Run php artisan test to execute all tests.
    Tests located in the tests\Feature\Api folder are relevant to the frontend.

### Navigate in the Frontend

1. use `php artisan db:seed --class=UsersTableSeeder` in the root project.
2. Open http://localhost:3000 in your browser.
3. In the login use:  
    email:     *admin@example.com*
    password:  *admin123*
4. Click the "Login" button.
5. You will be redirected to the Dashbopard administration panel.
6. In the sidebar you can go to users.
7. Here you can view, create, update and delete users based on your administrator permissions. Explore the different functionalities available in the panel to manage users.

### Note

If the email provided in the .env or in the requests is restricted by CORS, please notify me, and I'll update the project accordingly.



## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

