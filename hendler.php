<?php

header('Content-type: application/json; charset=utf-8');
require 'DB.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Lets validate
    if (isset($_POST['name'])) {

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        if (!checkLength($name, 3, 32)) {
            $response['error']['name'][] = 'Field name must be from 3 to 32 characters';
        }
    } else {
        $response['error']['name'][] = 'Field name is required';
    }

    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $response['error']['mail'][] = "It's not email!";
        } else {
            $sth = DB::get()->prepare('SELECT * FROM users WHERE email = :email');
            $sth->bindValue(':email', $mail, PDO::PARAM_STR);
            $sth->execute();
            $user = $sth->fetch();
            if ($user) {
                $response['error']['mail'][] = "email exist!";
            }
        }
    } else {
        $response['error']['mail'][] = 'Field email is required';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];

        if (!checkLength($password, 8, 32)) {
            $response['error']['password'][] = "Field  password must be from 8 to 32 characters!";
        }
        if (!preg_match("#[0-9]+#", $password)) {
            $response['error']['password'][] = "Your Password Must Contain At Least 1 Number!";
        }
        if (!preg_match("#[A-Z]+#", $password)) {
            $response['error']['password'][] = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        if (!preg_match("#[a-z]+#", $password)) {
            $response['error']['password'][] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    } else {
        $response['error']['password'][] = 'Field password is required';
    }

    if (isset($_POST['rePassword'])) {
        $rePassword = $_POST['rePassword'];

        if (!checkLength($password, 8, 32)) {
            $response['error']['rePassword'][] = "Field repeat password must be from 8 to 32 characters!";
        }

        if ($rePassword != $password) {
            $response['error']['rePassword'][] = "Fields password and repeat password must be the same!";
        }
    } else {
        $response['error']['rePassword'][] = 'Field repeat password is required';
    }


    //if no validation errors then write to database
    if (count($response['error']) == 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $sth = DB::get()->prepare('INSERT INTO users (name, email, hash) VALUES (:name, :email, :hash)');
            $sth->bindValue(':name', $name, PDO::PARAM_STR);
            $sth->bindValue(':email', $mail, PDO::PARAM_STR);
            $sth->bindValue(':hash', $hash, PDO::PARAM_STR);
            $sth->execute();
            $response['success'] = "User $name is added!";
        } catch (PDOException $Exception) {
            $response['database'] = $Exception->getMessage();
        }
    }
    echo json_encode($response);
}

function checkLength(string $toCheck, $min, $max) {
    if (strlen($toCheck) >= $min && strlen($toCheck) <= $max) {
        return true;
    } else {
        return false;
    }
}
