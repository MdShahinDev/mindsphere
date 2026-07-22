<div align="center">

# MindSphere

### *Think Clear. Stay Focused. Achieve More.*

A modern, AI-powered self-help platform for personal growth, habit tracking, productivity management, and continuous learning — all in one place.

[![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Python](https://img.shields.io/badge/Python-3.8+-3776AB?style=for-the-badge&logo=python&logoColor=white)](https://python.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Scikit-learn](https://img.shields.io/badge/Scikit--learn-F7931E?style=for-the-badge&logo=scikit-learn&logoColor=white)](https://scikit-learn.org)
[![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white)](https://www.chartjs.org)

</div>

---

## Overview

MindSphere is a full-stack web application designed to help individuals take control of their daily lives. It combines **task management**, **habit tracking**, **AI-powered chat assistance**, and **machine learning-based efficiency scoring** into a single, intuitive platform.

Whether you're a student, professional, or lifelong learner, MindSphere gives you the tools to build better habits, stay productive, and monitor your personal growth — backed by data.

---

## Features

### Productivity & Task Management
- Create, update, and track tasks with priority levels (High / Medium / Low)
- Built-in **Pomodoro Timer** with customizable work/break intervals and alarm sound
- Weekly activity reports with worked hours, task completion rate, and progress bars

### Habit Tracker with ML-Powered Insights
- Track daily habits across **4 dimensions**: Health, Wellness, Productivity, and Learning
- **20+ trackable habits** including water intake, exercise, sleep, meditation, work hours, and more
- Automated **Efficiency Score** calculation using a **RandomForestRegressor** machine learning model
- Score progression charts to visualize improvement over time

### AI Chat Assistant
- Real-time conversational AI powered by **OpenRouter API** (Gemini 2.5 Flash Lite)
- Persistent chat history stored in the database
- Contextual system prompts for consistent, helpful responses

### Resource Library
- Curated collection of **books**, **courses**, **podcasts**, and **research papers**
- Category-based browsing with downloadable PDF resources

### Profile & Settings
- User profile management with avatar uploads, location, and profession
- Personal & professional skill tracking with grade assessments
- Motivational quotes based on time of day (morning, noon, afternoon, evening, night)

### Authentication & Security
- Secure signup/login with **bcrypt password hashing**
- Session-based authentication
- Password visibility toggle on login/signup forms

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, Vanilla JavaScript, Font Awesome 6, Chart.js |
| **Backend** | PHP 7.4+ (MySQLi with prepared statements) |
| **Database** | MySQL 8.0 / MariaDB 10.4 |
| **ML/AI** | Python 3.8+, scikit-learn (RandomForestRegressor), OpenRouter API (Gemini 2.5 Flash Lite) |
| **Server** | Apache (XAMPP / WAMP / MAMP compatible) |

---

## Project Structure

```
mindsphere/
├── assets/
│   ├── books/              # Downloadable PDF resources
│   ├── components/         # Reusable PHP components (navBar, footer)
│   ├── css/                # Stylesheets (12+ modules)
│   ├── img/                # Images, icons, and hero illustrations
│   └── js/                 # Client-side JavaScript
│
├── config/
│   ├── db.php              # Database connection configuration
│   └── storeHabitData.php  # Habit data API endpoint
│
├── dashboard/              # Authenticated user dashboard
│   ├── Dashboard.php           # Main dashboard view
│   ├── DashboardTask.php       # Task management
│   ├── DashboardTaskCompleted.php
│   ├── DashboardAllTask.php
│   ├── dashboardHabitML.php    # Habit tracker (Health)
│   ├── dashboardHabitMLWellness.php
│   ├── dashboardHabitMLProductivity.php
│   ├── dashboardHabitMLLearning.php
│   ├── DashboardChat.php       # AI chat interface
│   ├── DashboardProfile.php    # User profile
│   ├── DashboardResourceLibrary.php
│   ├── DashboardSetting.php
│   ├── chat_api.php            # AI chat backend (OpenRouter)
│   ├── get_task.php
│   ├── update_task.php
│   └── delete_task.php
│
├── python/
│   ├── train_model.py      # ML model training script
│   └── score_user.py       # Real-time efficiency prediction
│
├── index.php               # Landing page
├── login.php               # Authentication
├── signup.php              # Registration
├── logout.php              # Session termination
├── forgotpass.html         # Password recovery
├── score.php               # Efficiency score endpoint
├── resourceLibrary.php     # Resource hub
├── mindspheredb.sql        # Database schema & seed data
└── alarm.mp3               # Pomodoro timer sound
```

---

## Getting Started

### Prerequisites

- **XAMPP**, **WAMP**, or **MAMP** (Apache + MySQL + PHP)
- **Python 3.8+** with pip
- **Composer** (optional, for PHP dependency management)

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/your-username/mindsphere.git
cd mindsphere
```

**2. Set up the database**

- Start Apache and MySQL from your XAMPP/WAMP control panel
- Open **phpMyAdmin** (`http://localhost/phpmyadmin`)
- Create a new database named `mindspheredb`
- Import `mindspheredb.sql` into the database

**3. Configure database connection**

Edit `config/db.php` with your database credentials:

```php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";       // Your MySQL password
$db_name = "mindspheredb";
```

**4. Install Python dependencies**

```bash
pip install pandas scikit-learn mysql-connector-python joblib
```

**5. Train the ML model**

```bash
python python/train_model.py
```

This generates `python/efficiency_model.pkl` used for real-time scoring.

**6. Launch the application**

Navigate to `http://localhost/mindsphere/` in your browser.

---

## Database Schema

The application uses **10 relational tables** with foreign key constraints:

| Table | Purpose |
|-------|---------|
| `users` | User accounts with authentication data |
| `tasks` | Task management with priorities and progress |
| `habit_log` | Daily habit entries across 4 categories |
| `habit_score` | Aggregated daily efficiency scores |
| `ai_chat_history` | AI conversation history per user |
| `pomodoro_sessions` | Pomodoro timer session logs |
| `personal_skill` | User's personal skill assessments |
| `professional_skill` | User's professional skill assessments |
| `notification` | In-app notification system |
| `motivational_quotes` | Time-based inspirational quotes |

---

## AI & Machine Learning

### Efficiency Prediction Model

MindSphere uses a **RandomForestRegressor** from scikit-learn to predict user efficiency based on daily habit data.

**Features used for prediction (20 habits across 4 categories):**

| Category | Habits |
|----------|--------|
| **Health** | Drink water, Exercise, Sleep quality, Blood pressure, Meals |
| **Wellness** | Meditation, Journaling, Gratitude, Mood check-in, Breathing exercises |
| **Productivity** | Work hours, Social media usage, Tasks completed, Pomodoro sessions, Break time |
| **Learning** | Reading, Courses, Smart recall (Anki), New skills, Learning logs |

**Training pipeline:**
1. Pivot habit logs into feature vectors
2. Compute rule-based efficiency scores
3. Train RandomForestRegressor on historical data
4. Save model as `.pkl` for real-time prediction

### AI Chat Integration

- **API Provider:** OpenRouter
- **Model:** Gemini 2.5 Flash Lite Preview
- **Features:** Contextual system prompts, chat history persistence, session-based authentication

---

## Key Highlights

- **Real-time Efficiency Scoring** — ML model predicts your daily efficiency from habit patterns
- **4-Dimensional Habit Tracking** — Health, Wellness, Productivity, and Learning
- **Pomodoro Technique** — Built-in focus timer with configurable intervals and alarm
- **AI Assistant** — Get instant answers powered by Gemini 2.5 Flash Lite
- **Data-Driven Insights** — Chart.js visualizations for score progression and activity
- **Resource Library** — Books, courses, podcasts, and research papers in one place
- **Motivational System** — Time-of-day quotes to keep you inspired

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m 'Add your feature'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request

---

## License

This project is for educational and personal use. Contact the repository owner for licensing details.

---

<div align="center">

**Built with passion for personal growth and productivity**

</div>
