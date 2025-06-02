<?php
// index.php
// Removed require_once 'NepaliCalendar.php'; here. main.php will handle it.
?>
<?php require_once 'header.php'; ?>
<?php require_once 'main.php'; ?>

<?php
// Ensure jQuery and your custom script are loaded AFTER main.php.
// This is CRUCIAL for $(document).ready() and global functions to work.
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script> <?php /* Ensure this path is correct relative to index.php */ ?>

</body>
</html>
