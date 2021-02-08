This solution gets book data from xml files and loads them into the postgreSQL database.
Gives the opportunity to the user to see a list of books by an author of his choice.

The program contains two classes:
1. Database class - makes connection to the books db
2. Book class - processes files and returns search result
- At first, by recursion, it gets all filenames
- then checks if they are xml
- if they are xml files check if they already exist in the db
- if they exist update their add date
- if they dont't exist insert them in db

User part allows the users to search for books by author in a search field
and shows them search results in a table under the search field
