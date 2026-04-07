# ezbusLK - Smart Bus Reservation System

ezbusLK is a comprehensive web-based platform designed to digitize bus travel management in Sri Lanka. It provides a seamless interface for customers to book seats, operators to manage passenger lists, and admins to oversee the entire fleet and route network.

## 🌟 Key Features
* **Real-time Seat Booking:** Visual seat selection with instant availability updates.
* **Role-Based Access:** Dedicated portals for Admins, Operators, and Customers.
* **Dynamic Route Management:** Easily configure routes, stops, and pricing.
* **Automated Ticketing:** Email notifications and digital ticket generation via PHPMailer.
* **Feedback System:** Integrated customer reviews to maintain service quality.
* **Chat Bot:** Integrated customized chat bot to communicate common questions with passengers.
* **Admin Panel:** Fully featured admin panel to bus owners, bus assistants to manage every master data and functions.

## 🛠 Technology Stack
* **Frontend:** HTML5, CSS3 (Custom Grid/Flexbox), JavaScript (Vanilla).
* **Backend:** PHP 8.x.
* **Database:** MySQL / MariaDB (Relational Schema).
* **Library:** PHPMailer for transaction emails.


## 🚀 Rest to Develop (Roadmap)
The following modules are currently in the development pipeline to enhance the platform's capabilities:

* **Bus Tracking Module:** Implementation of GPS-based real-time tracking to allow passengers to view the live location of their bus via an interactive map.
* **Interactive Bus Dashboard:** A centralized data visualization hub for passengers to view real-time trip route, next stop, distance to next stop.

## 📥 Installation Steps
1.  **Environment:** Install XAMPP/WAMP with PHP 8.0 or higher.
2.  **Clone:** ```bash
    git clone [https://github.com/vimukthiwellawalage/booking-web.git](https://github.com/vimukthiwellawalage/booking-web.git)
    ```
3.  **Database:**
    * Open `phpMyAdmin`.
    * Create a database named `ezbuslk_db`.
    * Import `ezbuslk_db.sql`.
4.  **Configuration:** Update `connect.php` and `db_conn.php` with your local database `username` and `password`.
5.  **Launch:** Move the folder to `htdocs` and visit `http://localhost/busbooking`.

## 👥 Contributor
* **Vimukthi Wellawalage** - Lead Developer
