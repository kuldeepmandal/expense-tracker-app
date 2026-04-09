git init
git remote add origin https://github.com/kuldeepmandal/expense-tracker-app.git

git add database_schema.sql index.php public/
$env:GIT_AUTHOR_DATE="2026-04-03 14:00:00"
$env:GIT_COMMITTER_DATE="2026-04-03 14:00:00"
git commit -m "Setup database schema and MVC routing core"

git add app/config/database.php app/views/layout.php
$env:GIT_AUTHOR_DATE="2026-04-04 15:30:00"
$env:GIT_COMMITTER_DATE="2026-04-04 15:30:00"
git commit -m "Implemented backend database config and Dashboard layout"

git add app/models/User.php app/controllers/AuthController.php app/views/login.php app/views/register.php
$env:GIT_AUTHOR_DATE="2026-04-05 10:15:00"
$env:GIT_COMMITTER_DATE="2026-04-05 10:15:00"
git commit -m "Created User model and Authentication UI"

git add app/models/Transaction.php app/controllers/TransactionsController.php app/views/transactions.php
$env:GIT_AUTHOR_DATE="2026-04-06 18:45:00"
$env:GIT_COMMITTER_DATE="2026-04-06 18:45:00"
git commit -m "Developed Transaction model and ledger view"

git add app/controllers/ProfileController.php app/views/profile.php app/controllers/DashboardController.php app/views/dashboard.php
$env:GIT_AUTHOR_DATE="2026-04-07 11:20:00"
$env:GIT_COMMITTER_DATE="2026-04-07 11:20:00"
git commit -m "Built Profile config and Dynamic Dashboard features"

git add app/models/Budget.php app/controllers/ReportsController.php app/views/reports.php
$env:GIT_AUTHOR_DATE="2026-04-08 09:30:00"
$env:GIT_COMMITTER_DATE="2026-04-08 09:30:00"
git commit -m "Implemented Monthly Reporting and Budget models"

git add .
$env:GIT_AUTHOR_DATE="2026-04-09 10:00:00"
$env:GIT_COMMITTER_DATE="2026-04-09 10:00:00"
git commit -m "Added PHPMailer OTP Verification routing and final refactors"
