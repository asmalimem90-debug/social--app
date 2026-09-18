# 🌐 Social App

A full-stack social networking web application developed with **PHP** and **MySQL**, following an **MVC-inspired architecture**.

The application provides core social-networking features such as user authentication, profiles, friendships, friend requests, suggestions, notifications, and media uploads.

---

## 📸 Screenshots

Screenshots of the application will be added here.

### Login

![Login](C:\xampp\htdocs\social-app\screenshots\login.png)

### Register

![Register](screenshots/register.png)

### Profile

![Profile](screenshots/profile.png)

### Friends

![Friends](screenshots/friends.png)


---

## 🚀 About the Project

**Social App** is a social networking web application developed as a full-stack web project.

The main goal of this project was to practice and demonstrate web development skills, including:

- Backend development with PHP
- Relational database management with MySQL
- User authentication and session management
- MVC-inspired application organization
- CRUD operations
- Relationships between users
- Friend request management
- Notification handling
- File and image uploads
- Frontend development with HTML, CSS and JavaScript

The application is organized into separate components to make the code easier to understand, maintain, and extend.

---

## ✨ Features

### 🔐 Authentication

- User registration
- User login
- User logout
- Session-based authentication
- Access control for authenticated users

### 👤 User Management

- User profiles
- Profile information
- Profile editing
- Profile picture upload

### 🤝 Friend Management

- Send friend requests
- Accept friend requests
- Decline friend requests
- View friends
- Manage existing friendships

### 💡 Friend Suggestions

- Discover potential connections
- Display suggested users

### 🔔 Notifications

- Notifications for user activity
- Notifications related to friend requests
- Notification management

### 🖼️ Media Uploads

- Profile picture uploads
- Media file handling
- Server-side upload management

### 📱 Responsive Interface

- Desktop-friendly interface
- Mobile-friendly layout
- Responsive HTML/CSS components

### 🗄️ Database Integration

- MySQL relational database
- Structured database schema
- PHP/MySQL application communication

---

## 🛠️ Technologies Used

| Category | Technology |
|----------|------------|
| Backend | PHP |
| Database | MySQL |
| Frontend | HTML5, CSS3, JavaScript |
| Local Server | XAMPP |
| Architecture | MVC-inspired |
| Version Control | Git & GitHub |

---

## 🏗️ Architecture

The application follows an **MVC-inspired architecture** to separate the main responsibilities of the application.

### Model

The models are responsible for:

- Database interactions
- Data retrieval
- Data creation and modification
- User-related operations
- Friendship-related operations
- Notification-related operations

### Controller

The controllers are responsible for:

- Processing requests
- Application logic
- Authentication
- Friend requests
- Notifications
- User management
- Friend management

### View

The views are responsible for:

- HTML pages
- User interface
- Forms
- Displaying application data

This organization helps keep the codebase structured and easier to maintain.

---

## 📂 Project Structure

```text
social-app/
│
├── config/
│   └── config.php
│
├── controllers/
│   ├── AuthController.php
│   ├── FriendController.php
│   ├── FriendRequestController.php
│   ├── NotificationController.php
│   └── UserController.php
│
├── core/
│   ├── Database.php
│   └── helpers.php
│
├── models/
│   ├── User.php
│   ├── Friend.php
│   ├── FriendRequest.php
│   └── Notification.php
│
├── public/
│   ├── css/
│   └── uploads/
│
├── views/
│   ├── auth/
│   └── ...
│
├── index.php
│
├── social_app.sql
│
└── README.md
