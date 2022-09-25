# Train Exercise

This code will display a table of rows listing a train line, route, route number, and operator ID, based on data uploaded by a user in the form
of a .CSV file. While it is assumed that the user will upload a CSV file that is fully compliant to this format, it does not assume that the 
file has a header row: it checks for a header row based on the first cell containing the text "TRAIN_LINE."

By default, the table is sorted by run number. The user can sort by train line, route, route number, or operator ID by clicking the corresponding 
header. If there are more than five rows, the table will be paginated in groups of five, allowing the user to click directlyto a specific page, 
or to advance to the next or previous page, assuming there's one available.

All rows will be unique; should the user upload a file that contains identical rows, the duplicates will be filtered out.

Unit tests are included in the "tests" folder, and the appropriate vendor files should be present in the "vendor" folder as well. The testing 
assumes using PHPUnit 9.5 and PHP version 8.1. To run the unit tests, use the command line to navigate to the root of the project folder and 
enter "phpunit tests".

This code can be seen in action at [https://trains.logthedog.com](https://trains.logthedog.com).
