<?php
header("Content-type: text/css; charset: UTF-8");
?>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f9fafc;
}

.dashboard header {
    background-color: #007bff;
    color: white;
    padding: 20px;
    text-align: center;
}

nav {
    background-color: #f4f6f9;
    padding: 15px;
    border-bottom: 1px solid #ddd;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 10px;
}

nav ul li a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

nav ul li a:hover {
    text-decoration: underline;
}

main {
    padding: 20px;
}

main table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

main table, main th, main td {
    border: 1px solid #ddd;
}

main th, main td {
    padding: 10px;
    text-align: left;
}

main th {
    background-color: #f4f6f9;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

img {
    max-width: 100px;
    height: auto;
}

a {
    color: blue;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
tbody tr td{
    text-align: center;
}
thead tr th{
    text-align: center;
}