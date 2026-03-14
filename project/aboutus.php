📌 ShopMatrix Website – Project Overview & Progress Report
✅ Project Title

ShopMatrix – Multi Store Inventory & Employee Management System

🎯 Project Objective

ShopMatrix is a web-based multi-store business management system designed to help store owners manage multiple stores from one platform.

The main objective of this project is to provide a complete solution for:

Store management

Employee management

Inventory tracking

Purchase and sales tracking

Stock transfers between stores

Notifications system

Profit calculation and reports

This system reduces manual work and improves store monitoring and business performance.

🧾 Current Project Status (Work Completed)
1️⃣ Login & Authentication System (Completed)

A complete authentication system is implemented for both Owner and Employee.

Features Implemented:

Owner Login

Employee Login

Secure session handling

Role-based access system (OWNER / EMPLOYEE)

Session expired error handling

2️⃣ Owner Dashboard (Completed)

A professional Owner dashboard is created with a sidebar and modern UI.

Features Included:

Dashboard overview with cards

Total Stores count

Pending employee request count

Unread notifications count

Store-wise access management (planned structure)

3️⃣ Employee Dashboard (Completed)

Employee dashboard is created with store-restricted access.

Features Included:

Employee details display (name, email, mobile)

Store details display (store name, store code, city)

Store access validation (Employee can access only assigned store)

Unread notifications count shown on dashboard

Latest notifications preview shown in dashboard

4️⃣ Employee Request System (Completed)

Employees can request to join a store and Owner can approve or reject them.

Features Implemented:

Employee request submission

Owner can approve request

Owner can reject request

Employee status updated automatically (pending → active / rejected)

5️⃣ Notification System (Completed)

A notification system is fully implemented to manage all system alerts.

Notification Features:

Owner Notification Page

Employee Notification Page

Unread notifications badge count

Mark as read functionality

Target-based notifications system (OWNER / EMPLOYEE)

This ensures Owner notifications are only visible to Owner and Employee notifications are only visible to Employee.

🗄️ Database Structure Used
Main Tables Created:
1) Users Table

Stores employee details and employee status.

status: pending / active / rejected

2) Stores Table

Stores all store details under a specific owner.

3) Notifications Table

Stores all notifications for Owner and Employee.

Fields:

owner_id

user_id

title

message

type

reference_id

target (OWNER / EMPLOYEE)

is_read

created_at

🔐 Security and Access Control (Implemented)
Security Features:

Role-based access restriction

Store-based access restriction

Session validation on each page

Proper error handling for invalid sessions

Employee cannot view other store data

This ensures system privacy and secure access.

🚀 Future Modules (Planned Development)
📦 Inventory Management (Future Work)

Add / Edit / Delete Products

Stock quantity management store-wise

Low stock alert system

Inventory reports

🛒 Purchase Management (Future Work)

Purchase entry module store-wise

Supplier management

Purchase history and reports

Purchase analytics

💰 Sales Management (Future Work)

Sales entry module

Sales invoice generation

Daily / weekly / monthly sales report

Store-wise sales tracking

🔁 Stock Transfer Between Stores (Future Work)

Transfer products from one store to another

Transfer request and approval system

Transfer status tracking:

Pending

In Transit

Delivered

Transfer history record

📊 Profit Calculation System (Future Work)

Purchase vs Sales calculation

Profit per store

Profit per product

Monthly profit analysis report

👥 Customer Management (CRM System) (Future Work)

Customer data management

Customer purchase history tracking

Customer relationship management system

Follow-up tracking system

⭐ Store Review System (Google Reviews Integration) (Future Work)

Fetch store reviews using Google API

Display store rating on dashboard

Review monitoring and performance tracking

📑 Reports and Analytics System (Future Work)

Inventory report

Sales report

Purchase report

Stock transfer report

Employee performance report

Store progress report

🔄 Current System Workflow
Owner Workflow:

Owner can:

Login

Access Owner Dashboard

Manage stores

Approve / reject employee requests

View notifications

Monitor store progress

Employee Workflow:

Employee can:

Login

Access Employee Dashboard

View only assigned store data

Receive notifications

Perform store-related operations (inventory, purchase, sales - future modules)

📌 Conclusion

ShopMatrix project has successfully completed its core base development.

Completed Modules:

✅ Owner login & dashboard
✅ Employee login & dashboard
✅ Employee request approval system
✅ Notification system with read/unread feature
✅ Store restriction system (employee can access only assigned store)
✅ Proper session handling and security

Upcoming Development:

The next phase will include:

Inventory management

Purchase & sales module

Stock transfer system

Profit calculation

Reports & analytics

Customer management system

This system will become a complete solution for store owners to manage their business digitally and efficiently.