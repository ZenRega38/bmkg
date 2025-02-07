<?php
// Read data from JSON file
$jsonData = file_get_contents('assets/json/data-berita.json');

// Decode the JSON data into a PHP array
$newsItems = json_decode($jsonData, true);

// Check for errors during JSON decoding
if ($newsItems === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON: ' . json_last_error_msg()); // Handle the error appropriately
}

// Get the news item ID from the query parameter
$newsId = $_GET['id'] ?? null;

// Find the selected news item
$selectedNewsItem = null;
foreach ($newsItems as $item) {
    if ($item['id'] == $newsId) {
        $selectedNewsItem = $item;
        break;
    }
}

// If the news item is not found, display an error message
if (!$selectedNewsItem) {
    echo "News item not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selectedNewsItem['title']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 800px;  /* Reduced max-width for better readability */
            margin: 20px auto;
        }

        .news-detail {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 30px;  /* Increased padding for better spacing */
        }

        .news-detail img {
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 30px; /* Increased margin */
            border-radius: 8px;  /* Add border-radius to the image */
        }

        .news-detail h1 {
            margin-bottom: 15px;  /* Increased margin */
            font-size: 2em;     /* Larger font size for the title */
            color: #222;
        }

        .news-detail p.date {
            color: #777;
            font-size: 0.9em;
            margin-bottom: 15px;  /* Increased margin */
        }

        .news-detail p.summary { /* Style for the summary paragraph */
            font-style: italic;
            color: #555;
            margin-bottom: 20px;
            font-size: 1.1em;
        }

        .news-detail p {
            margin-bottom: 20px;  /* Increased margin */
            font-size: 1.1em;    /* Slightly larger font size for readability */
        }

        /* Responsive Design */
        @media (max-width: 600px) {  /* Adjust breakpoint as needed */
            .container {
                width: 95%; /* Wider container on mobile */
            }

            .news-detail {
                padding: 20px; /* Reduce padding on mobile */
            }

            .news-detail h1 {
                font-size: 1.75em;  /* Smaller title font on mobile */
            }

            .news-detail p {
                font-size: 1em;    /* Slightly smaller paragraph font on mobile */
                margin-bottom: 15px; /* Reduce bottom margin */
            }
        }
    </style>
</head>
<body>
<main class="container">
    <div class="news-detail">
        <img src="<?= htmlspecialchars($selectedNewsItem['image']) ?>" alt="<?= htmlspecialchars($selectedNewsItem['title']) ?>">
        <h1><?= htmlspecialchars($selectedNewsItem['title']) ?></h1>
        <p class="date"><?= htmlspecialchars($selectedNewsItem['date']) ?></p>
        <p class="summary"><?= htmlspecialchars($selectedNewsItem['summary']) ?></p> <!-- Display the summary -->
        <p><?= htmlspecialchars($selectedNewsItem['details']) ?></p>
    </div>
</main>
</body>
</html>