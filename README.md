# PummelPlay - Digital Distribution Platform

## Project Overview
PummelPlay is an eCommerce web application designed for the digital distribution of video games. The project prioritizes robust backend architecture, relational database design, and data consistency over frontend aesthetics.

## Technical Implementation
The system is built on the Laravel (PHP) framework, utilizing the Model-View-Controller architecture to strictly separate business logic from the user interface.

**Database & Architecture**
The core relies on a normalized relational SQL structure designed to efficiently handle Users, Products, Orders, and Reviews. Data integrity is enforced through foreign key constraints and specific validation logic in the Review System to prevent duplicate ratings. Additionally, optimized SQL queries power the Admin Dashboard, generating real-time reports on sales trends and inventory.

**Core Functionality**
Key backend features include an automated invoicing workflow that triggers PDF generation with dynamic transactional data upon purchase. Security is managed via Role-Based Access Control (RBAC) middleware, ensuring a strict separation between Administrator capabilities (CRUD operations, analytics) and standard Customer features.

## Tech Stack
**Backend:** PHP (Laravel Framework), MySQL / SQLite
**Frontend:** Tailwind CSS, Blade Templates
**Tools:** Git, Composer
