Social App
A full-stack social networking web application built with PHP and MySQL, following an MVC-inspired architecture.

The application provides core social-networking features such as user authentication, profiles, friendships, friend requests, suggestions, notifications, and media uploads.

📸 Screenshots
Add your screenshots here once they are available.

screenshots/
├── login.png
├── register.png
├── profile.png
├── friends.png
└── notifications.png
Example:

![Login](screenshots/login.png)
📋 Table of Contents
About the Project

Features

Tech Stack

Architecture

Project Structure

Getting Started

Prerequisites

Installation

Database Setup

Usage

Roadmap

Contributing

License

Contact

🚀 About the Project
Social App is a lightweight social networking platform developed as a full-stack web application.

The project was created to practice and demonstrate:

Backend development with PHP

Relational database design with MySQL

User authentication and session management

MVC-inspired application organization

CRUD operations

Relationships between users

Friend request management

Notification handling

File and image uploads

Frontend development with HTML, CSS and JavaScript

The application is designed to be simple to understand, maintain, and extend with additional social-networking features.

✨ Features
🔐 Authentication
User registration

User login

User logout

Session-based authentication

Access control for authenticated users

👤 User Management
User profiles

Profile information

Profile editing

Profile picture upload

🤝 Friend Management
Send friend requests

Accept friend requests

Decline friend requests

View friends

Manage existing friendships

💡 Friend Suggestions
Discover potential connections

Display suggested users

🔔 Notifications
Notifications for user activity

Notifications related to friend requests

Notification management

🖼️ Media Uploads
Profile picture uploads

Media file handling

Server-side upload management

📱 Responsive Interface
Desktop-friendly interface

Mobile-friendly layout

Responsive HTML/CSS components

🗄️ Database Integration
MySQL relational database

Structured database schema

PHP/MySQL application communication

🛠️ Tech Stack
Layer	Technology
Backend	PHP
Database	MySQL
Frontend	HTML5, CSS3, JavaScript
Local Server	XAMPP
Architecture	MVC-inspired
Version Control	Git & GitHub
🏗️ Architecture
The application follows an MVC-inspired architecture to separate the main responsibilities of the application.

Model
Responsible for:

Database interactions

Data retrieval

Data creation and modification

User and friendship-related operations

Controller
Responsible for:

Processing requests

Application logic

Authentication

Friend requests

Notifications

User management

View
Responsible for:

HTML pages

User interface

Forms

Displaying application data

This organization helps keep the codebase structured and easier to maintain.

📂 Project Structure
social-app/
│
├── config/
│   └── config.php
│       # Application and database configuration
│
├── controllers/
│   ├── AuthController.php
│   │   # Login, registration and logout
│   │
│   ├── FriendController.php
│   │   # Friend management
│   │
│   ├── FriendRequestController.php
│   │   # Send, accept and decline friend requests
│   │
│   ├── NotificationController.php
│   │   # Notification handling
│   │
│   └── UserController.php
│       # User profile management
│
├── core/
│   ├── Database.php
│   │   # Database connection layer
│   │
│   └── helpers.php
│       # Shared helper functions
│
├── models/
│   ├── User.php
│   ├── Friend.php
│   ├── FriendRequest.php
│   └── Notification.php
│
├── public/
│   ├── css/
│   │   # Stylesheets
│   │
│   └── uploads/
│       # Uploaded profile pictures and media
│
├── views/
│   ├── auth/
│   │   # Login and registration pages
│   │
│   └── ...
│       # Other application views
│
├── index.php
│   # Application entry point
│
├── social_app.sql
│   # Database schema
│
└── README.md
🚀 Getting Started
Follow the instructions below to run the project locally.

Prerequisites
Before installing the application, make sure you have:

XAMPP or another Apache + PHP + MySQL environment

PHP 7.4 or higher

MySQL 5.7 or higher

Git

Installation
1. Clone the repository
git clone https://github.com/<your-username>/social-app.git
cd social-app
2. Move the project to XAMPP
On Windows, place the project inside:

C:\xampp\htdocs\
The final project path should be:

C:\xampp\htdocs\social-app
3. Configure the database connection
Open:

config/config.php
Configure your database connection according to your local MySQL setup.

Example:

define('DB_HOST', 'localhost');
define('DB_NAME', 'social_app');
define('DB_USER', 'root');
define('DB_PASS', '');
Security note: Do not commit passwords, API keys, or other sensitive credentials to a public GitHub repository.

🗄️ Database Setup
1. Start XAMPP
Open the XAMPP Control Panel and start:

Apache

MySQL

2. Open phpMyAdmin
Go to:

http://localhost/phpmyadmin
3. Create the database
Create a database named:

social_app
4. Import the database schema
Import the file:

social_app.sql
into the social_app database.

Alternatively, using the MySQL command line:

mysql -u root -p social_app < social_app.sql
▶️ Usage
Once Apache and MySQL are running and the database has been configured, open:

http://localhost/social-app
You can then:

Create a new account

Log in

Complete and edit your profile

Upload a profile picture

Search for users

Send friend requests

Accept or decline friend requests

Manage your friends

Receive notifications

🗺️ Roadmap
The following features could be added in future versions:

 Real-time notifications using WebSockets

 Private messaging between users

 Post creation

 Likes and comments

 News feed

 Improved search functionality

 Unit and integration tests

 Dockerized development environment

 Production deployment

 Improved security and validation

 API layer for external integrations

🤝 Contributing
Contributions and suggestions are welcome.

1. Fork the repository
Create your own fork of the project.

2. Create a feature branch
git checkout -b feature/your-feature
3. Commit your changes
git add .
git commit -m "Add your feature"
4. Push your branch
git push origin feature/your-feature
5. Open a Pull Request
Create a Pull Request describing your changes.

📄 License
This project is licensed under the MIT License.

See the LICENSE file for more information.

👩‍💻 Contact
Developed by Asma Elimem

GitHub:
https://github.com/

Feel free to explore the project, open an issue, or suggest improvements.

⭐ Project Status
This project is currently under development and may receive additional features and improvements over time.

