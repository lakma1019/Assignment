# E-Wings Inventory Management System

Welcome to the E-Wings Inventory Management System, a lightweight ERP solution built with PHP and MySQL for managing customers, items, invoices, and reports. This project simulates the operations of an imaginary electronics shop called E-Wings, providing simple yet powerful inventory and billing functionalities for small businesses.

---

## Project Features

- Invoice Generation (auto-incrementing invoice numbers)
- Customer Registration & Management
- Item Registration & Editing
- Reports: Invoice summaries, item reports
- Real-time Timestamp and system feedback
- Organized codebase (backend & frontend separation)

---

## Local Setup Instructions

This project is developed using WampServer with a custom port 8080 to avoid system port conflicts.Before run this project , this project folder should paste in www folder of wampserver folder in local environment.
Database scheama has provide under database folder as ,MySql scheama called assignment.

### Prerequisites

- WampServer (Recommended Version: 3.3.0 or later)
- PHPMyAdmin (comes with Wamp)
- Web browser (Chrome, Firefox, etc.)

---

### Step-by-Step Setup

1. Start WampServer  
   Make sure the WampServer icon in your system tray is green (services running properly).

2. Create the Database  
   - Open your browser and go to:  
     http://localhost:8080/phpmyadmin  
   - Login using:  
     Username: root  
     Password: (leave blank)  
   - Click "New" and create a database named:  
     assignment  
   - Import the provided SQL file:  
     - Click the assignment database  
     - Go to the Import tab  
     - Upload and import your SQL file (assignment.sql or similar)

3. Add the Project Files  
   Place your project folder (example: inventory-management) inside:  
   C:\wamp64\www\

   Directory structure example:

   C:\wamp64\www\inventory-management\
       ├── backend\
       ├── frontend\
       ├── db_connect.php  
       ├── invoice.php  
       ├── get_unit_price.php  
       ├── ...

4. Update Port in the Browser  
   Since port 8080 is used, access your app via:  
   http://localhost:8080/inventory-management/invoice.php  
   You can also navigate to other pages like customer registration or item list using similar URLs.

---

### Database Configuration

The connection file db_connect.php uses the following settings:

servername: localhost  
username: root  
password:  
dbname: assignment  
port: 3306  

---

## About E-Wings (Imaginary Use Case)

E-Wings is a fictional electronics shop used to model this system. It includes a variety of items like printers, laptops, ink cartridges, and more to demonstrate how a real-world inventory system works. This assumption makes it easier to design and test realistic scenarios for customer orders, item tracking, and billing workflows.

---

## Tech Stack

- PHP (Procedural)
- MySQL
- HTML & CSS
- WampServer (Port: 8080)

---

## Future Enhancements (Ideas)

- Role-based login system (Admin vs Staff)
- PDF export for invoices
- Item stock quantity update on invoice
- Product images
- Enhanced UI with Bootstrap

---

## Support

If you face any issues setting up the project, you can:

- Check PHP error logs via WampServer
- Make sure your port 8080 is not blocked by another service
- Ensure all required tables are imported correctly

---

## License

This project is open for educational and demo purposes.

---

Made with PHP and MySQL |  Developed by Lakma Rajapaksha
