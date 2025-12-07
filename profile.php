<?php
$pageTitle = 'profile';
include "./components/header.php";
require_once('./config/db.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ./");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT first_name, last_name, email, phone, date_of_birth, gender, marital_status, state, lga, residential_address FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $user = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'date_of_birth' => '',
        'gender' => '',
        'marital_status' => '',
        'state' => '',
        'lga' => '',
        'residential_address' => '',
    ];
}
?>
    <div class="d-flex flex-column flex-lg-row h-lg-100 gap-1">
        <?php include "./components/side-nav.php"; ?>

        <div class="flex-lg-fill overflow-x-auto ps-lg-1 vstack vh-lg-100 position-relative">
            <?php include "./components/top-nav.php"; ?>
            <div class="flex-fill overflow-y-lg-auto scrollbar bg-body rounded-top-4 rounded-top-start-lg-4 rounded-top-end-lg-0 border-top border-lg shadow-2">
                <main class="container-fluid px-3 py-5 p-lg-6 p-xxl-8">
                    <header class="border-bottom mb-10">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12">
                                <h1 class="ls-tight">Profile</h1>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-flush gap-6 overflow-x border-0 mt-4">
                            <li class="nav-item"><a href="profile" class="nav-link active">Profile</a></li>
                            <li class="nav-item"><a href="security" class="nav-link">Security</a></li>
                            <li class="nav-item"><a href="bank" class="nav-link">Bank</a></li>
                        </ul>
                    </header>
                    <form id="registerForm">
                        <div class="row g-5">
                            <div class="col-sm-4">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($user['date_of_birth']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Gender</label>
                                <input type="text" name="gender" class="form-control" value="<?= htmlspecialchars($user['gender']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Marital Status</label>
                                <input type="text" name="marital_status" class="form-control" value="<?= htmlspecialchars($user['marital_status']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">State of Residence</label>
                                <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($user['state']) ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">LGA</label>
                                <input type="text" name="lga" class="form-control" value="<?= htmlspecialchars($user['lga']) ?>" disabled>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label">Residential Address</label>
                                <textarea name="address" class="form-control" rows="3" disabled><?= htmlspecialchars($user['residential_address']) ?></textarea>
                            </div>
                            <div class="row align-items-center mt-5">
                                <div class="d-flex justify-content-end gap-2 mb-6">
                                    <a href="support" class="btn btn-primary">Contact admin to update profile</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/switcher.js"></script>
</body>

</html>