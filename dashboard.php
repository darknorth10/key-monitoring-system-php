<div class="main-dashboard h-100 w-100 bg-light mt-4 p-2">
    <?php
        $ar = "SELECT * FROM room_tbl WHERE room_status = 'Available'";
        $uk = "SELECT * FROM transaction_tbl WHERE transaction_status = 'borrowed'";
        $tt = "SELECT * FROM transaction_tbl";
        $arRes = mysqli_num_rows(mysqli_query($conn, $ar));
        $ukRes = mysqli_num_rows(mysqli_query($conn, $uk));
        $ttRes = mysqli_num_rows(mysqli_query($conn, $tt));
    ?>
    <div class="cards w-100 d-flex justify-content-evenly">
        <div class="card border-4 border-primary w-25 px-3 py-4 bg-white">Available Rooms | <?php echo $arRes; ?></div>
        <div class="card border-4 border-danger w-25 px-3 py-4 bg-white">Unreturned Keys | <?php echo $ukRes; ?></div>
        <div class="card border-4 border-success w-25 px-3 py-4 bg-white">Total Transactions | <?php echo $ttRes; ?></div>
    </div>
</div>