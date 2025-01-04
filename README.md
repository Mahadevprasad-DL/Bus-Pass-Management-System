# Bus Pass Management System

## Introduction
The **Bus Pass Management System** is a web-based application that simplifies the process of applying for and managing bus passes. It allows users to register, log in, and apply for bus passes online, while administrators can efficiently manage bus routes, fares, and pass approvals. The system aims to reduce manual effort and enhance the user experience.

## Features
### User Features:
- User registration and login system.
- Apply for a bus pass by selecting routes.
- View the status of the bus pass (Pending, Approved, or Rejected).

### Admin Features:
- Manage bus routes (add, update, or delete routes).
- View and approve/reject bus pass requests.
- View user details and pass application history.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Development Environment**: XAMPP


## Installation Guide
1. **Prerequisites**:
   - Install [XAMPP].
   - Basic knowledge of PHP and MySQL.

2. **Setup Instructions**:
   1. Clone the repository or download the project files.
   2. Copy the project folder to the `htdocs` directory of XAMPP.
   3. Import the database:
      - Open `phpMyAdmin` in your browser (`http://localhost/phpmyadmin`).
      - Create a database named `bus_pass_management`.
      - Import the `buspass.sql` file from the `sql/` directory.
   4. Update `config.php` with your database credentials.
   5. Start the Apache and MySQL servers using the XAMPP control panel.
   6. Open the application in your browser at `http://localhost/bus-pass-management`.

3. **Default Admin Credentials**:
   - Username: `admin`
   - Password: `123456`

## Screenshots
### 1. User Dashboard
![User Dashboard](https://via.placeholder.com/600x300.png?text=User+Dashboard)

### 2. Apply for a Bus Pass
![Apply Pass](https://via.placeholder.com/600x300.png?text=Apply+Pass)

### 3. Admin Dashboard
![Admin Dashboard](https://via.placeholder.com/600x300.png?text=Admin+Dashboard)

## Future Enhancements
- Integration with online payment gateways for pass fees.
- Real-time notifications for pass approval/rejection.
- Mobile-friendly responsive design.

## Contributing
Contributions are welcome! If you'd like to contribute, please follow these steps:
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-name`).
5. Open a pull request.

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.


---

**Enjoy using the Bus Pass Management System!**

