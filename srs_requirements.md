# Software Requirements Specification (SRS): Spendly

## 1. Project Overview
**Project Name:** Spendly
**Goal:** Help users easily record, manage, and analyze daily expenses and view remaining budgets through a modern, responsive web application.

## 2. Functional Requirements

### 2.1 Authentication Module
* **Register:** Users must be able to create a new account using Name, Email, and Password.
* **Login:** Users can log in securely using their credentials.
* **Logout:** Users can securely end their session.

### 2.2 Dashboard Module
* **Financial Summary:** Display Total Budget, Total Spent, Remaining Balance, and Total Activity count.
* **Quick Actions:** Buttons to quickly "Add Expense", "Add Income", and "View Reports".
* **Recent Transactions:** Display a list of the 4-5 most recent transactions with type, date, amount, and category.
* **Expense Breakdown:** A pie chart showing the percentage of expenses by category (e.g., Food, Transport, Office).
* **Monthly Trend:** A bar or line chart showing spending trends over recent months.

### 2.3 Transaction Management Module
* **Add Entry:** A form (modal or page) to log an Expense or Income, specifying Amount, Category, Date, Description, Payment Method (Cash, Online, Card), and Notes.
* **Transaction History:** A dedicated page to view a paginated list of all financial transactions.
* **Search & Filter:** Search transactions by description/recipient; filter by date range, category, and type; sort by newest/oldest.

### 2.4 Reports & Budgeting Module
* **Monthly Budgeting:** Set an overall monthly budget limit and edit it.
* **Category Allocation:** Define budget limits for specific categories (Housing, Groceries, Entertainment, etc.) and track "Spent vs. Limit" using progress bars.
* **Alerts:** Show system warnings when users are nearing or exceeding their budget limits.

### 2.5 Profile Settings Module
* **View/Edit Profile:** Update display name, email.
* **Security:** Change account password.
* **Preferences:** Set Currency preference (e.g., NPR, USD) and toggle Dark/Light mode.

## 3. Non-Functional Requirements
* **UI/UX:** Must exactly match the provided Spendly Figma designs (modern aesthetic, rounded cards, specific green/red/dark color palette).
* **Responsiveness:** Must work seamlessly on both desktop (laptops) and mobile browsers.
* **Performance:** Operations like adding a transaction should reflect in the UI in under 2 seconds.
* **Tech Stack:** HTML CSS JS (Frontend), PHP (Backend), MySQL (Database).
