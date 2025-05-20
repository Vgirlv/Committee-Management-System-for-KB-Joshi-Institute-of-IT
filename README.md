KBJCommit-Con - College Committee Management System

KBJCommit-Con is a centralized web-based Content Management System (CMS) built to efficiently manage multiple college clubs and committees such as the Entrepreneurship Development Cell (EDC), Cultural Committee, and Green Club. It provides a clean interface for admins and members to handle events, members, achievements, and reports.

Features:

Fixed Navbar with navigation links (Events, Members, Partners, Gallery, Achievements)

Offcanvas Sidebar with:

Profile Picture Upload

Club Name and Head Details

Club Objectives

Social Media Links

Annual Reports with financials and comparison with previous year

Admin Dashboard for content management across all clubs

Aesthetic UI using Bootstrap 5

Separate event tables for each committee:

events → EDC

eventss → Cultural Committee

eventsss → Green Club

Tech Stack:

Frontend: HTML, CSS, JavaScript, Bootstrap 5

Backend: PHP

Database: MySQL (via phpMyAdmin)

Server Environment: XAMPP

Project Structure:

kbcommit-con/
├── admin/
│ └── dashboard.php
├── edc/
│ └── edc_dashboard.php
├── cultural/
│ └── cultural_dashboard.php
├── green/
│ └── green_dashboard.php
├── includes/
│ └── config.php
├── assets/
│ ├── css/
│ ├── js/
│ └── images/
└── index.php

^Each club's annual report displays:

List of all conducted events

Event-wise financial details

Total club expenditure

Grand total of all clubs combined

Year-over-year performance comparison for growth analysis

Setup Instructions:

Install and run XAMPP.

Copy the project folder (kbcommit-con) into the htdocs folder inside the XAMPP installation directory.

Start Apache and MySQL from the XAMPP Control Panel.

Open phpMyAdmin in your browser by visiting http://localhost/phpmyadmin

Create a new database (e.g., kbcms)

Import the database file into the new database.

Update config.php with your MySQL username (default: root) and password (default: empty).

Visit http://localhost/kbcommit-con/index.php in your browser to start using the system.


Future Improvements:

Add login and role-based authentication

Make the layout responsive for mobile devices

Add filtering and search options for events and members

Add feature to upload documents or event posters

AI assistant to autofill or suggest event data

Convert dashboard into a Single Page Application using React or Vue.js

Contributors:

Vaishnavi Choudhari – Frontend, Backend, Database, UI Design
Mamta Tervankar – Testing, Documentation

License:

This project was created for academic and demonstration purposes. 

Read-Only Notice:

This is a public repository meant only for viewing purposes. No contributions or modifications are accepted unless approved by the maintainer.
