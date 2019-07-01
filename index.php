<html>
<head>
    <title>loto</title>
    <style>
        body {
            background: rgb(204, 204, 204);
        }

        page[size="A4"] {
            background: white;
            width: 21cm;
            height: 29.7cm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        @media print {
            body, page[size="A4"] {
                margin: 0;
                box-shadow: 0;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
<page size="A4">
    <?php

    // Seeding
    mt_srand((double)microtime() * 1000000);

    // generate numbers for the bingo card
    function generateCard()
    {

        $card = array();
        $arrWithNumbers = [];
        for ($number = 0; $number <= 21; ++$number) {
            $arrWithNumbers[$number] = $number;
        }

        for ($row = 1; $row <= 8; ++$row) {

            $card[$row] = array();
            while (array_count_values($card[$row])[0] != 2) {
                $card[$row][mt_rand(0, 4)] = 0;
            }

            // add 5 numbers to the row
            for ($column = 0; $column <= 4; ++$column) {

                if (isset($card[$row][$column]) and $card[$row][$column] == 0) {
                    continue;
                }
                // add row to random number (e.g. row 1 and number 8 = 18)
                $card[$row][$column] = mt_rand(1, 21);
            }
            ksort($card[$row]);
        }

        return $card;
    }


    // Print card
    function printCard($card)
    {
        echo '<table border="1" cellspacing="0" cellpadding="5">';
        $row = 0;
        foreach ($card as $index => $rij) {
            $row++;
            if ($row < 5) {
                echo '<tr style="text-align:center;vertical-align:top">';
                $column = 0;
                foreach ($rij as $columnIndex => $number) {
                    $column++;
                    if ($column < 7) {
                        echo '<td ';
                        if ($number == 0) {
                            echo ' style="background-color:black;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:20px 19px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;"';
                        } else {
                            echo ' style="font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:20px 19px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;"';
                        }
                        echo '>';
                        echo $number;
                        echo '</td>';
                    }
                }
            }
            echo '</tr>';
        }
        echo '</table>';
    }


    for ($quantityOgCards = 0; $quantityOgCards <= 4; ++$quantityOgCards) {
        $card = generateCard();
        printCard($card);
    }
    ?>
    <button onclick="window.print();return false;" class="print-button">Печать</button>
</page>
</body>
</html>
