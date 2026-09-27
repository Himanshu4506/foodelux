<?php
include 'db_connect.php';

$query = isset($_POST['query']) ? trim($_POST['query']) : "";

if ($query == "") {
    // Agar kuch type na ho to sari categories wapas bhej do
    $categories = [];
    $cat_query = $conn->query("SELECT DISTINCT category FROM food_items");
    while ($row = $cat_query->fetch_assoc()) {
        $categories[] = $row['category'];
    }

    foreach ($categories as $cat) {
        echo "<h2 style='margin: 30px 0 10px; font-size: 22px; color: #253A4A; border-bottom: 2px solid #E0A840; padding-bottom: 6px;'>"
            . htmlspecialchars($cat) . "</h2><div class='grid'>";
        $items = $conn->query("SELECT * FROM food_items WHERE category='$cat' ORDER BY id DESC");
        while ($row = $items->fetch_assoc()) {
            echo "<div class='card' data-category='".htmlspecialchars($row['category'])."'>
                    <img src='admin/".htmlspecialchars($row['image'])."' alt='".htmlspecialchars($row['name'])."'>
                    <h4>".htmlspecialchars($row['name'])."</h4>
                    <p>₹".number_format($row['price'], 2)."</p>
                    <button onclick='addToCart(".intval($row['id']).")'>Buy Now</button>
                  </div>";
        }
        echo "</div>";
    }
} else {
    // Search filter
    $stmt = $conn->prepare("SELECT * FROM food_items WHERE name LIKE ? OR category LIKE ? ORDER BY id DESC");
    $like = "%".$query."%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2 style='margin: 30px 0 10px; font-size: 22px; color: #253A4A; border-bottom: 2px solid #E0A840; padding-bottom: 6px;'>Search Results</h2><div class='grid'>";
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card' data-category='".htmlspecialchars($row['category'])."'>
                    <img src='admin/".htmlspecialchars($row['image'])."' alt='".htmlspecialchars($row['name'])."'>
                    <h4>".htmlspecialchars($row['name'])."</h4>
                    <p>₹".number_format($row['price'], 2)."</p>
                    <button onclick='addToCart(".intval($row['id']).")'>Buy Now</button>
                  </div>";
        }
    } else {
        echo "<p style='color:#dc3545; font-size:18px; font-weight:bold; grid-column: 1/-1; text-align:center;'>
                ❌ No items found for '<span style='color:#253A4A;'>".htmlspecialchars($query)."</span>'
              </p>";
    }
    echo "</div>";
}
?>
