<html>
<body>

<?php

// Seeding
mt_srand((double)microtime() * 1000000);

// generate numbers for the bingo card
function generateCard()
{

    $card = array();

    $arrWithNumbers = [];
    for ($number = 1; $number < 22; ++$number) {
        $arrWithNumbers[$number] = $number;
    }

    for ($row = 1; $row < 6; ++$row) {

        $card[$row] = array();

        $deck = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);


        // add 6 numbers to the row
        for ($rownumber = 0; $rownumber < 6; ++$rownumber) {
            // Random index
            $index = mt_rand(0, count($deck) - 1);

            // Random number from $deck
            $number = $deck[$index];

            // add row to random number (e.g. row 1 and number 8 = 18)
            $card[$row][] = $row . $number;

            // take out current random number so it wont be drawn again
            unset($deck[$index]);

            // Reset the index of $deck, so no unset is chosen
            $deck = array_values($deck);

        }

        // Last column
        $card[$row][] = 0;
    }

    // Last row
    for ($col = 0; $col < 6; ++$col) {
        $card[7][$col] = 0;
    }


    return $card;
}


$card = generateCard();

// Print card
function printCard($card)
{ ?>
    <table border="1" cellspacing="0" cellpadding="5">
        <?php
        $row = 0;
        foreach ($card as $index => $rij) {
            $row++;
            if ($row < 7) {
                ?>
                <tr>
                <?php
                $column = 0;
                foreach ($rij as $columnIndex => $number) {
                    $column++;
                    if ($column < 7) { ?>
                        <td<?php if (($rij[6] == 6) || ($card[7][$column - 1] == 6)) {
                            echo ' style="background-color:green"';
                        } ?>><?php echo $number ?></td>
                    <?php }
                }
            } ?>
            </tr>
            <?php
        } ?>
    </table>
<?php }


$getrokkenGetallen = array();

$deck = range(10, 69);

$bingo = false;

// Keep drawing numbers till bingo is true
// Keep drawing numbers till bingo is true
while (!$bingo) {
    $index = mt_rand(0, count($deck) - 1);

    $number = $deck[$index];

    if (!in_array($number, $getrokkenGetallen)) {

        unset($deck[$index]);

        $deck = array_values($deck);

        $getrokkenGetallen[] = $number;

        // Check if number is on the card
        for ($row = 0; $row < 7; $row++) {
            for ($rownumber = 0; $rownumber < 7; $rownumber++) {
                if (isset($card[$row][$rownumber])) {
                    if ($card[$row][$rownumber] == $number) {

                        // set color?

                        $card[$row][6] += 1; // Increment col
                        $card[7][$rownumber] += 1; // Increment row
                        // check if the 7th column or row contains 6 positive draws (5 for testing)
                        if (($card[$row][6] == 6) || ($card[7][$rownumber] == 6)) {
                            $bingo = true;
                        }
                        break;
                    }
                }
            }
        }

    }
}


if ($bingo) {

    printCard($card);


    echo '<p>Drawn numbers are:<br>';
    foreach ($getrokkenGetallen as $value) {
        echo $value . ' ';
    }
    echo '</p>';


    echo '<p>Times drawn: ';
    echo count($getrokkenGetallen);
    echo '</p>';
}
?>
</body>
</html>
