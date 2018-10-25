<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/25/2018
 * Time: 1:18 PM
 */

include 'connection.php';            //connects to the database

try {
    $stmt = $conn->prepare("SELECT event_id,event_name,event_description,event_presenter, MONTH(event_date) AS current_month, YEAR (event_date) AS current_year,DATE_FORMAT(event_date,\"%m/%d/%Y\") AS display_date FROM wdv341_event ORDER BY event_date DESC ");

    $stmt->execute();
} catch (PDOException $e) {
    echo "<h1> There has been an Error. Please Try Again </h1>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formatting SELECT</title>


    <style>

        #container {
            width: 960px;
            background-color: lightblue;
            margin-left: auto;
            margin-right: auto;
        }

        nav {
            background-color: sandybrown;

        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 3fr;

        }

        article {
            background-color: lightgrey;
            width: 70%;
            box-sizing: border-box;
            margin-left: auto;
            margin-right: auto;
        }

        #currentMonth {
            color: red;
            font-weight: bold;
        }

        header {
            background-color: #0066cc;
        }

    </style>

    <?php


    ?>
</head>

<body>
<?php


//format date in SQL YYYY-MM-DD needs to be mm/dd/yyyy SELECT * , DATE_FORMAT(event_date,"%m-%d%y") AS formattedEventDate FROM table
//sort by date descending
?>
<div id="container">

    <header>
        <h1>Conferences R US</h1>
    </header>
    <div class="grid-container">
        <nav>
            <h3>Locations:</h3>
        </nav>
        <main>

            <h2>Events in your city:</h2>
            <?php
            $curMonth = date("m");
            $curDate = date("m/d/Y");
            $curYear = date("Y");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo(" <article>");

                if ($row['current_month'] == $curMonth && $row['current_year'] == $curYear) { //if it is the current month make text bold red

                    echo(" <h1 id='currentMonth'><strong>Event Name: " . $row['event_name'] . "</strong></h1>");

                } else if (strtotime($row['display_date']) > strtotime($curDate)) {//if future month,make text italicised

                    echo(" <h1><em>Event Name: " . $row['event_name'] . "</em></h1>");

                } else {//print normally

                    echo(" <h1>Event Name: " . $row['event_name'] . "</h1>");
                }

                echo("  <h3>Event Description:</h3>");
                echo("   <p>" . $row['event_description'] . "</p>");
                echo("   <h3>Presented By:" . $row['event_presenter'] . "</h3>");
                echo("   <h3>Date Presented :" . $row['display_date'] . "</h3>");
                echo("</article>");
            }
            ?>
            <!--            <article>-->
            <!--                <h1>Event Name:</h1>-->
            <!--                <h2>Event Description:</h2>-->
            <!--                <p>Lorem Ipsum MEOW MEOW MEOW</p>-->
            <!--                <h3>Presented By:</h3>-->
            <!--            </article>-->
        </main>
    </div>
    <footer>Copyright:</footer>


</div>
</body>
</html>
