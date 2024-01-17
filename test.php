<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Text Size</title>
    <style>
        h1 {
            font-size: 24px; /* Default font size for all screen sizes */
        }

        /* Media query for small screens (sm) */
        @media (max-width: 767px) {
            .myheading {
                font-size: 18px; /* Adjust the font size for small screens as needed */
                margin-top: 30px;
            }
        }

        /* Media query for large screens (lg) */
        @media (min-width: 1200px) {
            .myheading {
                font-size: 50px; /* Adjust the font size for large screens as needed */
            }
        }
    </style>
</head>
<body>

    <h1 class="myheading">This is a Heading</h1>

</body>
</html>