[AutoCare – Vehicle Service Management System.md](https://github.com/user-attachments/files/31122535/AutoCare.Vehicle.Service.Management.System.md)
# AutoCare – Vehicle Service Management System

AutoCare is a web-based vehicle service management system designed to simplify vehicle management and service booking. Users can manage their vehicles, book service appointments, select available time slots, and track their service bookings through a user-friendly web interface.

The application is built using PHP, MySQL, JavaScript, AJAX, HTML, and CSS and can be run locally using XAMPP.

## Features

### User Management

- User registration and login
- Secure user authentication
- User session management
- Logout functionality

### Vehicle Management

- Add and manage vehicles
- View vehicle details
- Store vehicle information
- Manage multiple vehicles for a user

### Service Booking

- Book vehicle service appointments
- Select service dates
- View available time slots
- Prevent invalid or conflicting bookings
- View booking confirmation

### Booking Management

- View existing bookings
- Track scheduled vehicle services
- Manage service appointments

### Dynamic Functionality

- AJAX-based dynamic interactions
- Dynamic service date selection
- Available time slot handling
- Interactive user interface

## Technologies Used

- **PHP** – Backend development
- **MySQL** – Database management
- **HTML5** – Page structure
- **CSS3** – Styling and layout
- **JavaScript** – Client-side functionality
- **AJAX** – Dynamic data loading and interactions
- **XAMPP** – Local development environment

## Project Structure

```text
autocare/
│
├── ajax/
│   └── AJAX-related PHP functionality
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── databases/
│   └── Database SQL files
│
├── includes/
│   ├── Database connection
│   ├── Shared components
│   └── Other reusable PHP files
│
├── index.php
├── home.php
├── signup.php
├── logout.php
├── add_vehicle.php
├── vehicle_details.php
├── vehicles.php
├── book_service.php
├── bookings.php
├── confirmation.php
│
└── README.md
```

## Requirements

Before running the project, make sure you have:

- XAMPP
- Apache
- MySQL
- PHP
- A modern web browser

## Installation and Setup

### 1. Clone the Repository

Clone this repository:

```bash
git clone https://github.com/Mr-Boombastic9116/autocare.git
```

Or download the repository as a ZIP file.

### 2. Move the Project to XAMPP

Place the project inside the XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\autocare
```

### 3. Start Apache and MySQL

Open the XAMPP Control Panel and start:

- Apache
- MySQL

### 4. Create the Database

1. Open phpMyAdmin.
2. Create or import the required database.
3. Import the SQL file available in the `databases` folder.

### 5. Configure the Database Connection

Open the database configuration file inside:

```text
includes/
```

Update the database credentials if required.

Example:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "your_database_name";
```

> Do not upload real passwords or sensitive credentials to a public repository.

### 6. Run the Application

Open your browser and visit:

```text
http://localhost/autocare/
```

## Main Pages

| Page | Description |
|---|---|
| `index.php` | Main entry page |
| `home.php` | User dashboard/home page |
| `signup.php` | User registration |
| `add_vehicle.php` | Add a vehicle |
| `vehicles.php` | View user vehicles |
| `vehicle_details.php` | Display vehicle information |
| `book_service.php` | Book a vehicle service |
| `bookings.php` | View service bookings |
| `confirmation.php` | Booking confirmation |
| `logout.php` | End user session |

## Database

The project uses MySQL to store application data such as:

- User information
- Vehicle details
- Service bookings
- Available service schedules

The database structure and SQL files are available in the `databases` folder.

## How to Use

1. Open the AutoCare website.
2. Create an account or log in.
3. Add your vehicle details.
4. Select a vehicle.
5. Choose a service date.
6. Select an available time slot.
7. Confirm your booking.
8. View your booking details.

## Future Improvements

Possible future improvements include:

- Service status tracking
- Online payment integration
- Email or SMS notifications
- Admin dashboard
- Service history
- Vehicle reminders
- Improved booking conflict handling
- Mobile-responsive UI improvements
- User profile management

## Authors

Developed as a web development project.

GitHub: https://github.com/Mr-Boombastic9116

## License

This project is currently intended for educational and learning purposes.
