<?php
$persons = json_decode(file_get_contents("people.json"), true);

if (isset($_POST["question"]) && $_POST["person"]) {
    $question = $_POST["question"];
    $en_name = $_POST["person"];
    $fa_name = $persons[$en_name];
    $handle = fopen("messages.txt", "r");
    $i = 0;
    while (($line = fgets($handle)) !== false) {
        $ans[$i] = $line;
        $i++;
    }
    fclose($handle);
    $arr_length = count($ans);
    $n_hash = $en_name . $question;
    $hash_num = intval(hash("crc32b", $n_hash), 30);
    $show_ans = $hash_num % $arr_length;
    $msg = $ans[$show_ans];
} else {
    $question = NULL;
    $en_name = array_rand($persons);
    $fa_name = $persons[$en_name];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>

<body>
    <p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
    <div id="wrapper">
        <?php
        if (isset($question)) {
            echo "<div id=\"title\">\n<span id=\"label\">پرسش:</span>\n<span id=\"question\">$question</span>\n</div>";
        }
        ?>
        <div id="container">
            <div id="message">
                <p><?php
                    if (isset($msg)) {
                        echo $msg;
                    } else {
                        echo "سوال خود را بپرس!";
                    }
                    ?></p>
            </div>
            <div id="person">
                <div id="person">
                    <img src="images/people/<?php echo "$en_name.jpg" ?>" />
                    <p id="person-name"><?php echo $fa_name ?></p>
                </div>
            </div>
        </div>
        <div id="new-q">
            <form method="post" accept-charset="UTF-8">
                سوال
                <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..." />
                را از
                <select name="person">

                    <?php
                    foreach ($persons as $key => $value) {
                        if ($key == $en_name) {
                            echo "<option value=\"$key\" selected>$value</option>";
                        } else {
                            echo "<option value=\"$key\" >$value</option>";
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="بپرس" />
            </form>
        </div>
    </div>
</body>

</html>