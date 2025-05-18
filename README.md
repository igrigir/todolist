Symfony ToDo Application

This is a simple and extendable ToDo list web application built with Symfony and Bootstrap.

---

## ✅ Features

- Add, edit, delete tasks
- Task status: Created, In Progress, Completed, Postponed
- Modal filter by status, price range, and task duration
- Search by title or date
- Responsive UI with Windows-style layout
- Uses Bootstrap 5 and custom CSS (`app-ui.css`)
- Works with SQLite (MySQL support planned)

---

## 🚀 Getting Started

### 1. Clone the repository:
```bash
git clone https://github.com/yourname/todo-symfony.git
cd todo-symfony
2. Install dependencies:
bash
Always show details

Copy
composer install
3. Create the database (using SQLite for now):
bash
Always show details

Copy
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
4. Start the development server:
bash
Always show details

Copy
symfony server:start
5. Open in browser:
bash
Always show details

Copy
http://localhost:8000/tasks
📦 Tech Stack
Symfony 5.4+

Twig Template Engine

Doctrine ORM

Bootstrap 5.3

SQLite (by default)

MySQL-ready

Custom CSS layout (Windows-style)

🧩 Project Structure
public/css/app-ui.css – UI styles

templates/task/index.html.twig – main view

TaskController.php – controller logic

Task.php – entity with: title, description, status, price, createdAt, finishedAt

🔮 Upcoming Features
We plan to implement the following:

🔐 User authentication (login & registration)

📄 Export to PDF

📊 Export to Excel

📂 Pagination of task list

🛢 Full support for MySQL database

📅 Calendar/date-range task views

📈 Dashboard with task summaries

👤 Author
Igor Josić
📞 065 323 591
📧 igor-josic@hotmail.com
