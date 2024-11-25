<?php
header("Content-type: text/css; charset: UTF-8");
?>
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #f7f8fa;
    color: #333;
    line-height: 0.6;
}

/* Header */
header {
    background-color: #4caf50;
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    text-transform: uppercase;
}

/* Navigation */
nav {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px 0;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    padding: 0;
    margin: 0;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    color: #4caf50;
    font-size: 16px;
    font-weight: bold;
    padding: 8px 15px;
    border-radius: 4px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

nav ul li a:hover {
    background-color: #4caf50;
    color: white;
}

/* Main Section */
main {
    padding: 20px;
}

/* Add Product Button */
a.btn {
    display: inline-block;
    background-color: #4caf50;
    color: white;
    font-size: 18px;
    padding: 12px 20px;
    border-radius: 5px;
    text-transform: uppercase;
    font-weight: bold;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    margin-bottom: 20px;
}

a.btn:hover {
    background-color: #45a049;
    box-shadow: 0 4px 7px rgba(0, 0, 0, 0.15);
}

/* Table Styling */
main table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
}

main table th, main table td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #f0f0f0;
}

main table th {
    background-color: #f9f9f9;
    color: #4caf50;
    font-size: 16px;
    font-weight: bold;
}

main table tr:nth-child(even) {
    background-color: #f7f8fa;
}

main table tr:hover {
    background-color: #eafaf1;
    transition: background-color 0.3s ease;
}

main table img {
    border-radius: 8px;
    width: 70px;
    height: auto;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Action Buttons */
.btn.edit {
    background-color: #ffc107;
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

.btn.edit:hover {
    background-color: #e0a800;
}

.btn.delete {
    background-color: #f44336;
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

.btn.delete:hover {
    background-color: #d32f2f;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    nav ul {
        flex-direction: column;
        text-align: center;
    }

    nav ul li {
        margin: 10px 0;
    }

    a.btn {
        font-size: 16px;
        padding: 10px 15px;
    }

    main table th, main table td {
        font-size: 14px;
    }

    main table img {
        width: 50px;
    }
}

