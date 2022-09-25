<!DOCTYPE html>
<?php
define('ROWS_PER_PAGE', 5);
require_once "src/TrainRuns.php";
session_start();
?>

<html lang="en">

<head>
    <link href="trains.css" rel="stylesheet" type="text/css" />
    <title>Train Exercise</title>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <?php
        $x = 0;
        $trainRunsObj = new Trains\TrainRuns();

        // If the user is uploading a file, we're starting fresh.
        if (!empty($_FILES)) {
            $file_path = $_FILES['file_name']['tmp_name'];
            $trainRunsObj->uploadRuns($file_path);
            // Start with a list sorted by run number
            $_SESSION['runs'] = $trainRunsObj->sortRuns($_SESSION['runs'], 2);

        } else if (isset($_POST['sort_by'])) {
            $_SESSION['runs'] = $trainRunsObj->sortRuns($_SESSION['runs'], $_POST['sort_by']);
        }

        // Display the table only if there's something to display; otherwise, skip to the upload form.
        if (isset($_SESSION['runs'])) {
            $runCount = is_countable($_SESSION['runs']) ? count($_SESSION['runs']) : 0;

            // Calculate the number of pages
            $pageCount = (int)ceil($runCount / ROWS_PER_PAGE);

    ?>

    <p>
    <table id="train_runs" data-numpages="<?php echo $pageCount;?>" data-currentpage="1">
        <tr class="keep">
            <!--
                We'll use PHP to sort the table by column. So, we're using buttons disguised
                as links so we can send POST data to the backend.
            -->
            <th>
                <form method="post" action="index.php" class="inline">
                    <input type="hidden" name="sort_by" value="0" />
                    <button type="submit" class="fakeLink">Train Line</button>
                </form>
            </th>
            <th>
                <form method="post" action="index.php" class="inline">
                    <input type="hidden" name="sort_by" value="1" />
                    <button type="submit" class="fakeLink">Route</button>
                </form>
            </th>
            <th>
                <form method="post" action="index.php" class="inline">
                    <input type="hidden" name="sort_by" value="2" />
                    <button type="submit" class="fakeLink">Run Number</button>
                </form>
            </th>
            <th>
                <form method="post" action="index.php" class="inline">
                    <input type="hidden" name="sort_by" value="3" />
                    <button type="submit" class="fakeLink">Operator ID</button>
                </form>
            </th>
        </tr>
        <?php
            $x = 1;
            foreach ($_SESSION['runs'] as $sortK => $sortV) {
                echo '<tr class="' . (int)ceil($x / ROWS_PER_PAGE) . '">';
                foreach ($sortV as $data) {
                    echo '<td>' . $data . '</td>';
                }
                echo '</tr>';
                $x++;
            }

            if ($pageCount > 1) {
                // We'll put the navigation in the table caption.
                echo '<caption>';
                echo '<span class="previous"><< </span>';
                for ($x = 1; $x <= $pageCount; $x++) {
                    echo '<span class="page';
                    if ($x === 1) {
                        echo ' noLink';
                    }
                    echo '" onClick="goToPage(' . $x . ');">' . $x . '</span>&nbsp;';
                }
                echo '<span class="next showNext"> >></span>';
                echo '</caption>';
            }

        ?>
    </table>
    </p>
    <?php } ?>
    <p>

        <!--
        We'll always have the upload form available so the user can change the data
        at any time. 
    -->
    <h3 class="center">
        Here you may upload a CSV file that contains a list of train runs:
    </h3>
    <div class="center">
        <form action="index.php" enctype="multipart/form-data" method="post">
            <input name="file_name" id="file_name" accept=".csv" type="file" />
            <button type="submit" name="submit" id="submit">Upload File</button>
        </form>
    </div>
    </p>
    <script>
    $(document).ready(function() {
        $('tr').each(function() {
            if ($(this).attr('class') != '1' && $(this).attr('class') != 'keep') {
                $(this).hide();
            }
        });

        // For the "next" and "previous" navigation, we're coloring the arrows
        // the same color as the background to hide them when they should not appear.
        // (Using the "hide()" function would change the indentaion.) To make sure we
        // don't navigate to a nonexistent page, we also check and make sure the 
        // corresponding "show" class is present. If it's not there, do nothing.
        $('.next').on('click', function() {
            if ($('.showNext').hasClass('showNext')) {
                goToPage(($('#train_runs').data('currentpage') + 1));
            }
        });

        $('.previous').on('click', function() {
            if ($('.previous').hasClass('showPrev')) {
                goToPage(($('#train_runs').data('currentpage') - 1));
            }
        });

    });

    function goToPage(pageNum) {
        var numPages = $('#train_runs').attr('data-numpages');
        $('#train_runs').data('currentpage', pageNum);
        if (pageNum == numPages) {
            $('.next').removeClass('showNext');
        } else {
            $('.next').addClass('showNext');
        }
        if (pageNum != '1') {
            $('.previous').addClass('showPrev');
        } else {
            $('.previous').removeClass('showPrev');
        }

        $('tr').each(function() {
            if ($(this).attr('class') != pageNum && $(this).attr('class') != 'keep') {
                $(this).hide();
            } else {
                $(this).show();
            }
        });

        $('.page').each(function() {
            if ($(this).html() != pageNum) {
                $(this).removeClass('noLink');
            } else {
                $(this).addClass('noLink');
            }
        });
        return;
    }
    </script>
</body>

</html>