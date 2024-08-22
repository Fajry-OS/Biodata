<?php
include "rute.php";
include "../config/connection.php";
session_start();

$queryPricing = mysqli_query($koneksi, "SELECT * FROM pricing WHERE deleted_at IS NULL");
$rowPricings = mysqli_fetch_all($queryPricing, MYSQLI_ASSOC);

$queryIntro = mysqli_query($koneksi, "SELECT * FROM intro WHERE delete_at IS NULL");
$rowIntros = mysqli_fetch_all($queryIntro, MYSQLI_ASSOC);
//var_dump(rowPricing);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <?php include "inc/css.php"; ?>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "inc/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "inc/topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php if (isset($_GET['page']) && $_GET['page'] == "dashboard") {
                        include "inc/dashboard.php";

                        //Page Pricing
                    } elseif (isset($_GET['page']) && $_GET['page'] == "pricing") { ?>
                        <div class="d-sm-flex align-item-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Control Pricing!</h1>
                        </div>
                        <div class="row">
                            <div class="col-xl-11 col-md-11">
                                <a href="index.php?control=pricingadd" type="button" class="btn btn-primary"><i class="bi bi-plus"></i>ADD Data</a>
                                <button class="btn btn-danger"><i class="bi bi-printer"></i> Print PDF</button>
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered text-center table-striped" id="datatables">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Aksi</th>
                                                <th>Pilih Edisi</th>
                                                <th>Harga</th>
                                                <th>Header</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($rowPricings as $row) {
                                            ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><a href="index.php?control=pricingedit&idedt=<?= base64_encode($row['id']) ?>" class="btn btn-success btn-sm m-1"><i class="bi bi-pen"></i>Edit</a><a href="controls/control_pricing.php?ctrl=pricingdelete&id=<?= base64_encode($row['id']) ?>" class="btn btn-danger btn-sm m-1" onclick="return confirm('Apakah anda ingin menghapus Data ini?')"><i class="bi bi-trash-fill"></i>Delete</a></td>
                                                    <td><?= $row['pilihedisi'] ?></td>
                                                    <td>Rp. <?= number_format($row['harga'], 2, ',', '.') ?></td>
                                                    <td><?= $row['header'] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--END Page Pricing  -->

                        <!--Page Intro  -->
                    <?php } elseif (isset($_GET['page']) && $_GET['page'] == 'intro') { ?>
                        <div class="d-sm-flex align-item-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Control Intro!</h1>
                        </div>
                        <div class="row">
                            <div class="col-xl-11 col-md-11">
                                <a href="index.php?control=introadd" type="button" class="btn btn-primary"><i class="bi bi-plus"></i>ADD Data</a>
                                <button class="btn btn-danger"><i class="bi bi-printer"></i> Print PDF</button>
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered text-center table-striped" id="datatables">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Aksi</th>
                                                <th>Judul Website</th>
                                                <th>Judul</th>
                                                <th>Sub Judul</th>
                                                <th>Gambar</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($rowIntros as $row) {
                                            ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><a href="index.php?control=introedit&idedt=<?= base64_encode($row['id']) ?>" class="btn btn-success btn-sm p-1 m-1"><i class="bi bi-pen"></i>Edit</a><a href="controls/control_pricing.php?ctrl=pricingdelete&id=<?= base64_encode($row['id']) ?>" class="btn btn-danger btn-sm p-1 m-1" onclick="return confirm('Apakah anda ingin menghapus Data ini?')"><i class="bi bi-trash-fill"></i>Delete</a></td>
                                                    <td><?= $row['judulwebsite'] ?></td>
                                                    <td><?= $row['judul'] ?></td>
                                                    <td><?= $row['subjudul'] ?></td>
                                                    <td><img src="../assets/<?= $row['gambar'] ?>" alt="" width="100"></td>
                                                    <td><input type="radio" name="status" onclick="updateStatus(<?= $row['id'] ?>)" <?= isset($row['status']) && $row['status'] == 1 ? 'checked' : null ?>></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            function updateStatus(id) {
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", "controls/update_status.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        // console.log(xhr.responseText);
                                    }
                                };
                                xhr.send("id=" + encodeURIComponent(id));
                            }
                        </script>
                    <?php } ?>
                    <!--END Page Intro  -->

                    <!-- edit pricing -->
                    <?php if (isset($_GET['control']) && $_GET['control'] == "pricingedit") {
                        $id = base64_decode($_GET['idedt']);
                        $queryIntro = mysqli_query($koneksi, "SELECT * FROM intro WHERE delete_at IS NULL");
                        //Table Pricing
                        $queryPricing = mysqli_query($koneksi, "SELECT * FROM pricing WHERE id = $id AND deleted_at IS NULL");
                        $rowPricing = mysqli_fetch_assoc($queryPricing);
                        //Table card_class
                        $queryCard = mysqli_query($koneksi, "SELECT * FROM card_class");
                        //Table btn_class
                        $queryBtn = mysqli_query($koneksi, "SELECT * FROM btn_class");
                    ?>
                        <div class="d-sm-flex align-item-center justify-content-between mb-4">
                            <h1 class="mb-0 text-gray-800 ">Edit Pricing!</h1>
                        </div>
                        <form action="controls/control_pricing.php?ctrl=edt&idctrl=<?= $id ?>" method="post">
                            <div class="mb-3">
                                <label for="id_intro">Pilih Judul</label>
                                <select class="form-control" name="id_intro" id="id_intro">
                                    <option value="" disabled selected>Pilih Judul</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($queryIntro)) {
                                        $selected = isset($rowPricing['id_intro']) && $rows['id'] == $rowPricing['id_intro'] ? 'selected' : null;
                                    ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['judulwebsite'] ?></option>

                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pilihedisi">Edisi</label>
                                <input type="text" name="pilihedisi" class="form-control" value="<?= $rowPricing['pilihedisi'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control" value="<?= $rowPricing['harga'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id=""><?= $rowPricing['deskripsi'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="card_class">Card Class</label>
                                <select class="form-control" name="card_class" id="card_class">
                                    <option value="" disabled selected>Pilih Class</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($queryCard)) { ?>
                                        <option value="<?= $row['card_name'] ?>"><?= $row['card_name'] ?></option>

                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="header">Header</label>
                                <input type="text" name="header" class="form-control" id="header" value="<?= $rowPricing['header'] ?>"></input>
                            </div>
                            <div class="mb-3">
                                <label for="subtitle">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" id="subtitle" value="<?= $rowPricing['subtitle'] ?>"></input>
                            </div>
                            <div class="mb-3">
                                <label for="btn_class">Button Class</label>
                                <select class="form-control" name="btn_class" id="btn_class">
                                    <option value="" disabled selected>Pilih Class</option>
                                    <?php
                                    while ($rowBtn = mysqli_fetch_assoc($queryBtn)) {
                                    ?>
                                        <option value="<?= $rowBtn['btn_name'] ?>"><?= $rowBtn['btn_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <a href="index.php?page=pricing" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                            </div>
                        </form>

                        <!-- Add Pricing -->
                    <?php } elseif (isset($_GET['control']) && $_GET['control'] == "pricingadd") {
                        if (empty($_SESSION['click_count'])) {
                            $_SESSION['click_count'] = 0;
                        }
                        $queryIntro = mysqli_query($koneksi, "SELECT * FROM intro WHERE delete_at IS NULL");
                    ?>
                        <div class="card">
                            <div class="card-header">Tambah Harga</div>
                            <div class="card-body">
                                <form action="controls/control_pricing.php?ctrl=addpricing" method="post">
                                    <div class="mb-3 row">
                                        <div class="col-sm-2">
                                            <label for="id_intro">Pilih Judul</label>
                                            <select require class="form-control" name="id_intro" id="id_intro">
                                                <option value="" disabled selected>Pilih Judul</option>
                                                <?php
                                                while ($a = mysqli_fetch_assoc($queryIntro)) { ?>
                                                    <option value="<?= $a['id'] ?>"><?= $a['judul'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-transaction">
                                        <div class="mb-3" align="right">
                                            <button type="button" class="btn btn-primary btn-sm btn-add mb-3" id="counterBtn">Tambah</button>
                                            <input type="number" name="countDisplay" id="countDisplay" value="<?= $_SESSION['click_count']; ?>" readonly>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Edisi</th>
                                                        <th>Harga</th>
                                                        <th>Deskripsi</th>
                                                        <th>Card Class</th>
                                                        <th>Header</th>
                                                        <th>Subtitle</th>
                                                        <th>Btn Class</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                    <!-- Baris baru akan ditambah disini -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                                        <a href="index.php?page=pricing" class="btn btn-danger" id="back">Kembali</a>
                                    </div>
                                </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const button = document.getElementById('counterBtn');
                                        const countDisplay = document.getElementById('countDisplay');
                                        const tbody = document.getElementById('tbody');

                                        button.addEventListener('click', function() {
                                            let currentCount = parseInt(countDisplay.value);
                                            currentCount++;
                                            countDisplay.value = currentCount;

                                            const selectedIntroId = document.getElementById('id_intro').value;
                                            const selectedIntroText = document.getElementById('id_intro').options[document.getElementById('id_intro').selectedIndex].text;

                                            let newRow = "<tr>";
                                            newRow += "</tr>";
                                            newRow += `<td> <input type='hidden' name='idIntr[]' value='${selectedIntroId}' class='form-control' readonly> ${selectedIntroText} </td>`;
                                            newRow += "<td><input type='text' name='edisi[]' class='form-control' required></td>";
                                            newRow += "<td><input type='number' name='harga[]' class='form-control' required></td>";
                                            newRow += "<td><input type='text' name='deskripsi[]' class='form-control'></td>";
                                            newRow += "<td><input type='text' name='card_class[]' class='form-control'></td>";
                                            newRow += "<td><input type='text' name='header[]' class='form-control'></td>";
                                            newRow += "<td><input type='text' name='subtitle[]' class='form-control' required></td>";
                                            newRow += "<td><input type='text' name='btn_class[]' class='form-control'></td>";
                                            newRow += "</tr>";
                                            tbody.insertAdjacentHTML('beforeend', newRow);
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- edit Intro -->
                    <?php if (isset($_GET['control']) && $_GET['control'] == "introedit") {
                        $id = base64_decode($_GET['idedt']);
                        $queryIntro = mysqli_query($koneksi, "SELECT * FROM intro WHERE id = $id AND delete_at IS NULL");
                        $rowIntro = mysqli_fetch_assoc($queryIntro);
                    ?>
                        <div class="d-sm-flex align-item-center justify-content-between mb-4">
                            <h1 class="mb-0 text-gray-800 ">Edit Intro</h1>
                        </div>
                        <form action="controls/control_intro.php?ctrl=edt&idctrl=<?= $id ?>" method="post">
                            <div class="mb-3">
                                <label for="judulwebsite">Judul Website</label>
                                <input type="text" name="judulwebsite" class="form-control" value="<?= $rowIntro['judulwebsite'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" class="form-control" value="<?= $rowIntro['judul'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="subjudul">Sub Judul</label>
                                <input type="text" name="subjudul" class="form-control" value="<?= $rowIntro['subjudul'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isikonten">Isi Konten</label>
                                <textarea name="isikonten" class="form-control" id=""><?= $rowIntro['isikonten'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar">Gambar Ke-1</label>
                                <input type="file" name="gambar" class="form-control" value="<?= $rowIntro['gambar'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gambar2">Gambar Ke-2</label>
                                <input type="file" name="gambar2" class="form-control" value="<?= $rowIntro['gambar2'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gambar3">Gambar Ke-3</label>
                                <input type="file" name="gambar3" class="form-control" value="<?= $rowIntro['gambar3'] ?>">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="status" class="form-control" value="<?= $rowIntro['status'] ?>">
                            </div>
                            <div class="mb-3">
                                <a href="index.php?page=intro" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                            </div>
                        </form>

                    <?php } elseif (isset($_GET['control']) && $_GET['control'] == "introadd") {
                    ?>
                        <div class="d-sm-flex align-item-center justify-content-between mb-4">
                            <h1 class="mb-0 text-gray-800 ">Add Intro</h1>
                        </div>
                        <form action="controls/control_intro.php?ctrl=edt&idctrl=<?= $id ?>" method="post">
                            <div class="mb-3">
                                <label for="judulwebsite">Judul Website</label>
                                <input type="text" name="judulwebsite" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" class="form-control" value="<?= $rowIntro['judul'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="subjudul">Sub Judul</label>
                                <input type="text" name="subjudul" class="form-control" value="<?= $rowIntro['subjudul'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="isikonten">Isi Konten</label>
                                <textarea name="isikonten" class="form-control" id=""><?= $rowIntro['isikonten'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar">Gambar Ke-1</label>
                                <input type="file" name="gambar" class="form-control" value="<?= $rowIntro['gambar'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gambar2">Gambar Ke-2</label>
                                <input type="file" name="gambar2" class="form-control" value="<?= $rowIntro['gambar2'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gambar3">Gambar Ke-3</label>
                                <input type="file" name="gambar3" class="form-control" value="<?= $rowIntro['gambar3'] ?>">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="status" class="form-control" value="<?= $rowIntro['status'] ?>">
                            </div>
                            <div class="mb-3">
                                <a href="index.php?page=intro" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                            </div>
                        </form>


                    <?php } ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "inc/footer.php" ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class=" scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include "inc/modal.php" ?>


    <!-- Bootstrap core JavaScript-->
    <?php include "inc/js.php"; ?>

</body>

</html>