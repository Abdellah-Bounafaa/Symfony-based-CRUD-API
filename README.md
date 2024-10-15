# API Project

This project is a Symfony-based API that manages clients, devis, and voitures. Below are the instructions for setting up and using the API.

## Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/your-repo/api.git
    cd api
    ```

2. **Install dependencies:**

    ```sh
    composer install
    ```

3. **Set up the environment variables:**

    Copy the `.env` file and adjust the database URL and other settings as needed.

    ```sh
    cp .env .env.local
    ```

4. **Create the database:**

    ```sh
    php bin/console doctrine:database:create
    ```

5. **Run migrations:**

    ```sh
    php bin/console doctrine:migrations:migrate
    ```

6. **Load fixtures (if any):**

    ```sh
    php bin/console doctrine:fixtures:load
    ```

7. **Start the server:**

    ```sh
    symfony server:start
    ```

## API Endpoints

### Clients

- **Get all clients:**

    ```http
    GET /api/clients
    ```

- **Get a single client:**

    ```http
    GET /api/clients/{id}
    ```

- **Create a new client:**

    ```http
    POST /api/clients
    ```

    **Request Body:**

    ```json
    {
        "nom": "Doe",
        "prenom": "John",
        "date_naissance": "1980-01-01",
        "est_personne": true
    }
    ```

- **Update a client:**

    ```http
    PUT /api/clients/{id}
    ```

    **Request Body:**

    ```json
    {
        "nom": "Doe",
        "prenom": "John",
        "date_naissance": "1980-01-01",
        "est_personne": true
    }
    ```

- **Delete a client:**

    ```http
    DELETE /api/clients/{id}
    ```

### Devis

- **Get all devis:**

    ```http
    GET /api/devis
    ```

- **Get a single devis:**

    ```http
    GET /api/devis/{id}
    ```

- **Create a new devis:**

    ```http
    POST /api/devis
    ```

    Request** Body:**

    ```json
    {
        "numero": "12345",
        "date_effet": "2024-01-01",
        "client_id": 1,
        "voitures": [1, 2]
    }
    ```

- **Update a devis:**

    ```http
    PUT /api/devis/{id}
    ```

    **Request Body:**

    ```json
    {
        "numero": "12345",
        "date_effet": "2024-01-01",
        "client_id": 1,
        "voitures": [1, 2]
    }
    ```

- **Delete a devis:**

    ```http
    DELETE /api/devis/{id}
    ```

### Voitures

- **Get all voitures:**

    ```http
    GET /api/voitures
    ```

- **Get a single voiture:**

    ```http
    GET /api/voitures/{id}
    ```

- **Create a new voiture:**

    ```http
    POST /api/voitures
    ```

    **Request Body:**

    ```json
    {
        "make": "Toyota",
        "model": "Corolla",
        "year": 2020
    }
    ```

- **Update a voiture:**

    ```http
    PUT /api/voitures/{id}
    ```

    **Request Body:**

    ```json
    {
        "make": "Toyota",
        "model": "Corolla",
        "year": 2020
    }
    ```

- **Delete a voiture:**

    ```http
    DELETE /api/voitures/{id}
    ```
