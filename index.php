<?php

header('Content-Type: text/html; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $messages = array();
    if(!empty($_COOKIE['save'])){
        setcookie('save', '', 100000);
        $messages[] = 'Thanks, results are saved.';
    }

    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['tel'] = !empty($_COOKIE['tel_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['bday'] = !empty($_COOKIE['bday_error']);
    $errors['sex'] = !empty($_COOKIE['sex_error']);
    $errors['pl'] = !empty($_COOKIE['prog_lang_error']);
    $errors['acception'] = !empty($_COOKIE['acception_error']);

    if($errors['name']){
        setcookie('name_error', '', 100000);
        $messages[] = '<div class="error">Fill the name.</div>';
    }
    if($errors['tel']){
        setcookie('tel_error', '', 100000);
        $messages[] = '<div class="error">Fill the phone.</div>';
    }
    if($errors['email']){
        setcookie('email_error', '', 100000);
        $messages[] = '<div class="error">Fill the email.</div>';
    }
    if($errors['bday']){
        setcookie('bday_error', '', 100000);
        $messages[] = '<div class="error">Fill the bday.</div>';
    }
    if($errors['sex']){
        setcookie('sex_error', '', 100000);
        $messages[] = '<div class="error">Fill the sex.</div>';
    }
    if($errors['pl']){
        setcookie('prog_lang_error', '', 100000);
        $messages[] = '<div class="error">Choose the programming lang.</div>';
    }
    if($errors['acception']){
        setcookie('acception_error', '', 100000);
        $messages[] = '<div class="error">Fill the acception.</div>';
    }

    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['bday'] = empty($_COOKIE['bday_value']) ? '' : $_COOKIE['bday_value'];
    $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
    $values['pl'] = empty($_COOKIE['prog_lang_value']) ? [] : explode(';', $_COOKIE['prog_lang_value']);
    $values['acception'] = empty($_COOKIE['acception_value']) ? '' : $_COOKIE['acception_value'];

    include('./form.php');
    exit();
}

else{
    $errors = FALSE;
    if(empty($_POST['name']) || strlen($_POST['name'])>150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST['name'] )){
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
    }

    if(empty($_POST['tel']) || !preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $_POST['tel'])){
        setcookie('tel_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('tel_value', $_POST['tel'], time() + 30 * 24 * 60 * 60);
    }

    if(empty($_POST['email']) || !preg_match('/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/', $_POST['email'])){
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }

    if(empty($_POST['bday'])){
        setcookie('bday_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('bday_value', $_POST['bday'], time() + 30 * 24 * 60 * 60);
    }

    if(empty($_POST['sex'])){
        setcookie('sex_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
    }

    if(empty($_POST['pl'])){
        setcookie('prog_lang_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('prog_lang_value', implode(';', $_POST['pl']), time() + 30 * 24 * 60 * 60);
    }

    if(empty($_POST['acception'])){
        setcookie('acception_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else{
        setcookie('acception_value', $_POST['acception'], time() + 30 * 24 * 60 * 60);
    }

    if($errors){
        header('Location: ./index.php');
        exit();
    }
    else{
        setcookie('name_error', '', 100000);
        setcookie('tel_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('bday_error', '', 100000);
        setcookie('sex_error', '', 100000);
        setcookie('prog_lang_error', '', 100000);
        setcookie('acception_error', '', 100000);
    }
    
    $user = 'u67353';
    $pass = '8375108';
    $db = new PDO('mysql:host=localhost;dbname=u67353', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $db->prepare("INSERT INTO application (name, tel, email, bday, sex, bio) VALUES (:name, :tel, :email, :bday, :sex, :bio)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':bday', $bday);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':bio', $bio);
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $bday = $_POST['bday'];
    $sex = $_POST['sex'] == "on" ? "1" : "0";
    $bio = $_POST['bio'];
    $stmt->execute();

    $parent_id = $db->lastInsertId();
    $stmt = $db->prepare("INSERT INTO favoritelang (parent_id, pl) VALUES(:parent_id, :pl)");
    $stmt->bindParam(':parent_id',$parent_id);
    foreach ($_POST['pl'] as $pl){
        $stmt->bindParam(':pl', $pl);
        $stmt->execute();
    }

    setcookie('save', '1');

    header('Lacation: index.php');

}
