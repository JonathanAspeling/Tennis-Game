# Tennis App Assesment Work

## Prerequisite

- Docker
  - If Windows WSL2: [How to Install on Windows](https://docs.docker.com/desktop/windows/install/)

## Installation Instructions
- Clone Repo to Local Host
- Copy env.example to .env in your Local Repo
- Populate all .env values, not yet completed, with names and passwords as you see fit except
  - APP_KEY : leave blank
- Next run the following command from the CLI in your App Folder
  - composer install
- Run the following CLI command from within your Local App Folder
  - ./vendor/bin/sail up -d
- Once the Docker Boot finishes set up and deploy open the app CLI by using the following CLI command from within your app folder
  - ./vendor/bin/sail bash
- Next run the following commands in order from the bash terminal
  - composer install
  - php artisan key:generate
  - php artisan migrate
  - npm install
  - npm run dev
- Navigate to http://localhost/ on your machine to see the Placeholder Laravel Landing Page

## Usage / Critical Path
1. Start by registering a new account - see top left of Placeholder Laravel Landing Page - Register Link
   1. Ease of access link should be [Local Host Register Page](http://localhost/register)
2. Complete Form - You will be redirected to the App Dashboard
3. Note App integrated into Dashboard. Two Form Fields representing each player's score.
4. You can proceed to enter any whole numbers.
5. Clicking submit will evaluate the current state of the tennis match and return/display the appropriate match state wording.

## Running the Test Suite
The app utilises built-in PHP Unit to drive feature and unit testing.

Feel free to run at any stage via the following artisan command:
- php artisan test