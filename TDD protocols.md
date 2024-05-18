`      $$$$$$$\   $$$$$$\ $$$$$$$$\         $$$$$$\  `
`     $$  __$$\ $$ ___$$\\__$$  __|       $$$ __$$\ `
`    $$ |  $$ |\_/   $$ |  $$ | $$$$$$\  $$$$\ $$ |`
`   $$$$$$$  |  $$$$$ /   $$ |$$  __$$\ $$\$$\$$ | `
`  $$  __$$<   \___$$\   $$ |$$ |  \__|$$ \$$$$ |`
` $$ |  $$ |$$\   $$ |  $$ |$$ |      $$ |\$$$ |`
`$$ |  $$ |\$$$$$$  |  $$ |$$ |      \$$$$$$  /`
`\__|  \__| \______/   \__|\__|       \______/ `

# Architecture and TDD in Laravel-Vue Application

## Introduction
This report outlines the architecture of our Laravel-Vue application and details the implementation of Test-Driven Development (TDD) throughout its development. It discusses the key challenges faced, decisions made during design and development, and the processes and tools utilized to ensure code quality and application robustness.

## Application Architecture
Our application adheres to a client-server architecture, with Laravel as the backend and Vue.js as the frontend. Below is an overview of the main components of each part:

### Backend (Laravel)
- **Controllers**: Handle HTTP requests and coordinate business logic.
- **Models**: Represent data structures and define their relationships.
- **Routes**: Define URLs and their handlers to process incoming requests.
- **Middleware**: Filter and modify HTTP requests before they reach the controllers.

### Frontend (Vue.js)
- **Components**: Independent UI units reusable throughout the application.
- **Routes**: Managed with Vue Router to navigate between different application views.
- **Application State**: Managed via Vuex for a centralized and shared state among components.
- **Vuetify Configuration**: Configured using createVuetify, allowing custom options such as additional components and directives.
- **Creating Vue App**: The main Vue app instance is created with createApp, and Vuex, Vue Router, CKEditor, and Vuetify are added using the use method.
- **Mounting the Application**: The app is mounted on the DOM element with the id #app, initiating and displaying the application.

### Axios
Handles all HTTP requests from the application, ensuring the inclusion of the authentication token in the authorization header. It also manages unauthorized responses by removing the token and redirecting the user to the login page.

### TDD Implementation
We adopted a TDD approach to maintain code quality and system stability. The key steps followed are:

- **Writing Tests**: Automated tests are written before coding to describe the expected behavior of new features.
- **Executing Tests**: Tests are run to ensure they fail initially, confirming the correct behavior.
- **Code Implementation**: Minimum code is written to pass the tests.
- **Refactoring**: Code is refactored for improved quality and readability while using tests as a safety net to prevent regressions.

### Key Decisions and Challenges
During development, several challenges were faced, leading to key decisions impacting the architecture and implementation:

- **JWT Usage**: Adaptation to JWT, as the previous experience was with laravel/sanctum.
- **Vuetify Learning Curve**: While Vuetify was installed and globally mounted, Tailwind CSS was predominantly used due to greater familiarity.
- **Email Testing in .env**: An old email was used to test authentication and circumvent CORS issues in Laravel.
- **TDD Adoption**: As TDD is a new approach, the learning curve was significant, but there is a strong desire to continue learning and mastering this methodology.

### Conclusions
The combination of a well-defined architecture and TDD practices has been crucial for this project. It has facilitated the development of a robust, scalable application with high reliability and maintainability.
