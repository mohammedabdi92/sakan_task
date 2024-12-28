
```markdown
# Project Setup Instructions

## Prerequisites

Make sure you have the following installed on your system:

- Docker
- Docker Compose

## Setup

To get started with the project, follow these steps:

### 1. Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/mohammedabdi92/sakan_task.git
cd sakan_task
```

### 2. Build and Run the Containers

Run the following command to build and start the Docker containers:

```bash
docker compose up --build
```

This will start the containers, including the application and database.

### 3. Access the Application

Once the containers are up and running, you can access the dashboard at the following link:

**Dashboard:**  
[http://localhost:8080/dashboard/index](http://localhost:8080/dashboard/index)

### 4. Access the API

To interact with the API, you can use the following `curl` command to perform a login:

```bash
curl --location 'http://localhost:8080/index.php/user/login' \
--form 'username="mohammed"' \
--form 'password="password123"'
```

This will send a `POST` request to the login API and return a response with the login status.

### 5. Access the Database

To access the MySQL database running in Docker, use the following command:

```bash
mysql -h 127.0.0.1 -P 3307 -u root -p
```

Enter the password when prompted:

**Password:**  
`root`

You will be connected to the MySQL database, where you can perform queries on the database as needed.

---

## Docker Compose Commands

- To build and start the containers:
  ```bash
  docker compose up --build
  ```

- To stop the containers:
  ```bash
  docker compose down
  ```

- To view logs for the containers:
  ```bash
  docker compose logs -f
  ```

---

## Notes

- Ensure Docker and Docker Compose are running before starting the containers.
- The application will be available on `localhost:8080` by default.
- The MySQL database is accessible on port `3307` on your local machine.

---

Thank you for checking out the project!
