# Train Exercise

This code will display a table of rows listing a train line, route, route number, and operator ID, based on data uploaded by a user in the form
of a .CSV file.

By default, the table is sorted by run number. The user can sort by train line, route, route number, or operator ID by clicking the corresponding 
header. If there are more than five rows, the table will be paginated in groups of five, allowing the user to click directlyto a specific page, 
or to advance to the next or previous page, assuming there's one available.

All rows will be unique; should the user upload a file that contains identical rows, the duplicates will be filtered out.

This code can be seen in action at [https://trains.logthedog.com](https://trains.logthedog.com).
