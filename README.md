# Yamu (යමු) - Smart Bus Reservation System

Yamu is a comprehensive web-based platform designed to digitize bus travel management in Sri Lanka. It provides a seamless interface for customers to book seats, operators to manage passenger lists, and admins to oversee the entire fleet and route network.

## 🌟 Key Features

* **Real-time Seat Booking:** Visual seat selection with instant availability updates.
* **Role-Based Access:** Dedicated portals for Admins, Operators, and Customers.
* **Dynamic Route Management:** Easily configure routes, stops, and pricing.
* **Automated Ticketing:** Email notifications and digital ticket generation via PHPMailer.
* **Feedback System:** Integrated customer reviews to maintain service quality.
* **Chat Bot:** Integrated customized chat bot to communicate common questions with passengers.
* **Admin Panel:** Fully featured admin panel for bus owners and bus assistants to manage every master data and function.

## 🛠 Technology Stack

* **Frontend:** HTML5, CSS3 (Custom Grid/Flexbox), JavaScript (Vanilla), Tailwind CSS.
* **Backend:** PHP 8.x.
* **Database:** MySQL / MariaDB (Relational Schema).
* **Library:** PHPMailer for transactional emails.
* **Mapping:** Leaflet.js with OpenStreetMap tiles for live GPS route visualization.

## 🚧 In Progress

The following module is actively under development:

* **In-Bus Live Display Panel:** A fourth, kiosk-style user type — a screen mounted inside the bus showing passengers the previous stop, next stop, live distance to the next stop, and a real-time position on a Sri Lanka map.
  * Database schema is in place: `stop` table extended with `latitude`/`longitude`, plus new `iot_device` and `bus_live_location` tables.
  * A GPS ingestion endpoint accepts location pings identified by a per-device API key.
  * The physical GPS IoT module for live bus tracking has not been installed yet — a CLI simulator script feeds realistic test coordinates along a route in the meantime, so the panel can be fully built and tested ahead of hardware installation.

## 📥 Installation Steps

1. **Environment:** Install XAMPP/WAMP with PHP 8.0 or higher.
2. **Clone:**
   ```bash
   git clone https://github.com/vimukthiwellawalage/booking-web.git
   ```
3. **Database:**
   * Open `phpMyAdmin`.
   * Create a database named `ezbuslk_db`.
   * Import `ezbuslk_db.sql`.
   * If working on the bus tracking feature, also import the additive schema file (adds GPS columns/tables — does not touch existing data).
4. **Configuration:** Update `connect.php` and `db_conn.php` with your local database `username` and `password`.
5. **Launch:** Move the folder to `htdocs` and visit `http://localhost/busbooking`.

## 👥 Contributor

* **Vimukthi Wellawalage** - Lead Developer
