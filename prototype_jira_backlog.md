# Jira Backlog: Week 1 Prototype (Spendly)

The primary goal of the Week 1 Prototype is to successfully present a working user interface that reflects the core Figma designs, deployed locally on XAMPP, with functional navigation routing.

## Epic: Prototype Foundation & Setup
**Description:** Initialize the project architectures and database to ensure all team members can run the project locally.

* **Task-1:** Setup XAMPP environment and initialize `spendly_db` in phpMyAdmin using the SQL schema.
  * *Assignee suggested: Prajwan*
* **Task-2:** Initialize the MVC directory structure (`app/models`, `app/views`, `app/controllers`, `public/`).
  * *Assignee suggested: Kuldeep*
* **Task-3:** Create the core `index.php` router so navigation passes through the MVC controllers dynamically.
  * *Assignee suggested: Kuldeep*

## Epic: Core UI Implementation (Figma Matching)
**Description:** Translate the Figma screens into functional HTML/CSS templates using our global stylesheet.

* **Story-1:** As a user, I want to see the main Dashboard view with my "Total Budget" and "Remaining" balance metric cards.
  * *Assignee suggested: Krishna*
* **Story-2:** As a user, I want to see the interactive global Navbar to navigate between Dashboard, Transactions, and Reports.
  * *Assignee suggested: Krishna*
* **Story-3:** As a user, I want to visually see a mock list of "Recent Transactions" in my dashboard.
  * *Assignee suggested: Krishna*
* **Task-4:** Implement the Phosphor icons CDN so all SVG icons match the initial Figma UI precisely.
  * *Assignee suggested: Krishna*

## Epic: Minimum Viable Logic
**Description:** Allow the teacher/client to physically click through the app to demonstrate that the framework actually functions.

* **Story-4:** As an admin, I want to click on "Transactions" in the Navbar and be routed instantly to the transactions page using `index.php?page=transactions` without the page breaking.
  * *Assignee suggested: Kuldeep / Krishna*
* **Task-5:** Hardcode initial presentation data (like 50,000 Budget) into the `DashboardController.php` so the Views have clean data variables to echo out during the presentation.
  * *Assignee suggested: Kuldeep*

## Definition of Done (For Friday's Presentation)
1. Project opens immediately at `http://localhost/finance-tracker`.
2. The Dashboard strictly mirrors the provided Figma screenshot.
3. Clicking links perfectly routes between the MVC views.
4. XAMPP produces zero PHP errors or warnings.
