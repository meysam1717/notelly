# Notelly - A Note-Taking Application

Notelly is a note-taking application built using Laravel and Livewire. It allows users to organize their notes into folders, with each folder containing multiple notes. Each note can have a title, description, and a checklist of items.

## Installation

Follow these steps to set up and run Notelly on your local development environment.

### Prerequisites

Before you begin, ensure you have the following software installed on your system:

- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/)
- [Node.js](https://nodejs.org/)

### Step 1: Clone the Repository

```
git clone https://github.com/meysam1717/notelly
cd notelly
```


### Step 2: Install Composer Dependencies
Run the following command to install the PHP dependencies using Composer:

```
composer install
```

### Step 3: Initialize the .env File
Create a copy of the .env.example file and name it .env:

```
cp .env.example .env
```

### Step 4: Start the Docker Containers
Start the development environment using Docker Sail:

```
./vendor/bin/sail up -d
```

### Step 5: Generate an Application Key
Generate a unique application key:

```
./vendor/bin/sail artisan key:generate
```

### Step 6: Run Migrations
Migrate the database tables:

```
./vendor/bin/sail artisan migrate
```

### Step 7: Build JavaScript Assets
Compile the JavaScript assets:

```
./vendor/bin/sail npm run build
```



### Contributing
If you'd like to contribute to this project, send your merge requests.

### License
This project is open-source and available under the MIT License.
