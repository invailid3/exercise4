<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Form</title>
</head>


<body>
    <?php
        if (!empty($messages)) {
            print('<div id="messages">');
            foreach ($messages as $message) {
                print($message);
            }
            print('</div>');
        }
    ?>
    <div class="form">
        <form action="/ex4/index.php" method="POST">
            <div>
                <h1 id="form-header">Form</h1>
            </div>
            <div class="form-element">
                <label for="name">Name:</label>
                <input type="text" name="name" <?php if ($errors['name']) {print 'class="error"';} ?>
                 value="<?php print $values['name']; ?>" />
            </div>
            <div class="form-element">
                <label for="text">Telephone:</label>
                <input type="tel" name="tel" <?php if ($errors['tel']) {print 'class="error"';} ?>
                 value="<?php print $values['tel']; ?>" />
            </div>

            <div class="form-element">
                <label>E-male:</label>
                <input type="email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?>
                 value="<?php print $values['email']; ?>" />
            </div>

            <div class="form-element">
                <label>B-day:</label>
                <input type="date" name="bday" <?php if ($errors['bday']) {print 'class="error"';} ?>
                 value="<?php print $values['bday']; ?>" />
            </div>

            <div class="form-element">
                <label>Sex:</label>
                <input type="radio" name="sex" value="on" <?php echo empty($values['sex'])? '' : ($values['sex'] == "on"? "checked" : "");?>> Female
                <input type="radio" name="sex" value="off" <?php echo empty($values['sex'])? '' : ($values['sex'] == "off"? "checked" : "");?>> Male
            </div>

            <div class="form-element">
                <label>Favorite PL:</label>
                <select name="pl[]" multiple="multiple">
                    <option value="pascal" <?php echo in_array("pascal", $values['pl'])? "selected" : ""; ?>>Pascal</option>
                    <option value="c" <?php echo in_array("c", $values['pl'])? "selected" : ""; ?>>C</option>
                    <option value="cpp" <?php echo in_array("cpp", $values['pl'])? "selected" : ""; ?>>C++</option>
                    <option value="js" <?php echo in_array("js", $values['pl'])? "selected" : ""; ?>>JavaScript</option>
                    <option value="php" <?php echo in_array("php", $values['pl'])? "selected" : ""; ?>>PHP</option>
                    <option value="python" <?php echo in_array("python", $values['pl'])? "selected" : ""; ?>>Python</option>
                    <option value="java" <?php echo in_array("java", $values['pl'])? "selected" : ""; ?>>Java</option>
                    <option value="haskel" <?php echo in_array("haskel", $values['pl'])? "selected" : ""; ?>>Haskel</option>
                    <option value="clojure" <?php echo in_array("clojure", $values['pl'])? "selected" : ""; ?>>Clojure</option>
                    <option value="prolog" <?php echo in_array("prolog", $values['pl'])? "selected" : ""; ?>>Prolog</option>
                    <option value="scala" <?php echo in_array("scala", $values['pl'])? "selected" : ""; ?>>Scala</option>
                </select>
            </div>

            <div class="form-element">
                <label>Bio:</label>
                <textarea name="bio"></textarea>
            </div>

            
            <div class="form-acception">
                <input type="checkbox" name="acception"<?php if ($errors['acception']) {print 'class="error"';} ?>
                 value="<?php print $values['acception']; ?>" />Acception
            </div>
            <div class="form-acception">
                <input type="submit" name="submition">
            </div>
            
        </form>
    </div>
</body>

</html>