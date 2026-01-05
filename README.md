# PummelPlay - Digital Distribution Platform

PummelPlay is a full-featured eCommerce web application designed for the digital distribution of video games. While the frontend offers a seamless shopping experience, the core strength of the project lies in its **backend architecture** and **relational database design**.

## 🚀 Key Technical Features

### Database & Architecture (The Core)
* **Normalized Database Schema:** Designed a complex relational structure (SQL) to efficiently handle Users, Products, Orders, and Reviews with proper foreign key constraints.
* **Complex Querying:** Optimized SQL queries for the Admin Dashboard to generate real-time reports on sales trends, inventory levels, and revenue.
* **MVC Pattern:** Built on Laravel's Model-View-Controller architecture to ensure clean separation of business logic from the user interface.

### Functionality
* **Automated Invoicing:** Engineered a backend workflow that triggers PDF generation upon purchase completion, populating the document with dynamic transactional data.
* **Role-Based Access Control (RBAC):** Implemented middleware security to strictly separate Administrator capabilities (CRUD operations, analytics) from Customer features.
* **Data Integrity:** Developed specific logic for the Review System to prevent duplicate ratings and ensure verified purchases.

## 🛠️ Tech Stack
* **Backend:** PHP (Laravel Framework)
* **Database:** MySQL / SQLite
* **Frontend:** Tailwind CSS, Blade Templates
* **Tools:** Git, Composer
