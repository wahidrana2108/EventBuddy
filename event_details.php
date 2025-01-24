<?php 
include("includes/header.php"); 

// Example data
$enrolledLine = '50 / 50'; // This should be dynamic based on your database or data source

// Extract enrolled and total slots from the string
list($enrolled, $totalSlots) = sscanf($enrolledLine, '%d / %d');
$remaining = $totalSlots - $enrolled;
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Event Details</h3>
        </div>
        <div class="card-body p-3 ">
            <p><strong>Event:</strong> Amazing Birthday Party</p>
            <p><strong>Location:</strong> Pabna</p>
            <p><strong>Enrolled:</strong> <?php echo $enrolled; ?> / <?php echo $totalSlots; ?></p>
            <p><strong>Remaining:</strong> <?php echo $remaining; ?></p>
            
            <div class="d-flex align-items-center mb-3">
                <p><strong>Event Status:</strong> Running</p>
                <?php if ($remaining == 0): ?>
                    <button class="btn btn-success ms-2" disabled>Enroll</button>
                <?php else: ?>
                    <button class="btn btn-success ms-2">Enroll</button>
                <?php endif; ?>
            </div>

            <h5>Enrolled Users:</h5>
            <ol>
                <li>John Doe - 2025-01-15 14:30</li>
                <li>Jane Smith - 2025-01-16 10:45</li>
                <li>Mark Lee - 2025-01-17 12:20</li>
            </ol>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
