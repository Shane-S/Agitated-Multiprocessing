All portions of this lab are done:
*   The schema is complete and valid

*   The XML is constrained to certain values
    []  The genre element may only have words (upper or lower case characters)
        optionally separated by a hyphen, which uses a pattern
    []  The year must start at 1947 (the year the first "video game" was released)
    []  Only decimal values are allowed for the percentages

*   There are a number of simple types
    []  genre elements consist of constrained strings
    []  percentages are decimal values
    []  all attributes are simple types

*   There are also some complex types
    []  Every element with attributes (platform, sales)
    []  Elements with child elements (sale, game_sales)

*   The schema is fully commented with small examples to clarify the explanations 
