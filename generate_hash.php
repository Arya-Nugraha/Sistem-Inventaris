<?php
// PENTING: Jangan taruh file ini di server production / folder publik yang bisa
// diakses orang lain. Ini cuma untuk kebutuhan development di localhost (XAMPP).

$hash_result = null;
$verify_result = null;
$plain_password = '';
$verify_password = '';
$verify_hash = '';

// Proses form generate hash
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'generate') {
    $plain_password = $_POST['password'] ?? '';
    if ($plain_password !== '') {
        $hash_result = password_hash($plain_password, PASSWORD_DEFAULT);
    }
}

// Proses form verifikasi password vs hash
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verify') {
    $verify_password = $_POST['verify_password'] ?? '';
    $verify_hash = $_POST['verify_hash'] ?? '';
    if ($verify_password !== '' && $verify_hash !== '') {
        $verify_result = password_verify($verify_password, $verify_hash);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Password Hash Generator</title>
<style>
    * { box-sizing: border-box; }
    body {
        font-family: Segoe UI, Arial, sans-serif;
        background: #f2f4f7;
        margin: 0;
        padding: 40px 20px;
        color: #222;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
    }
    h1 {
        font-size: 22px;
        margin-bottom: 4px;
    }
    p.subtitle {
        color: #666;
        margin-top: 0;
        margin-bottom: 24px;
        font-size: 14px;
    }
    .card {
        background: #fff;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }
    .card h2 {
        font-size: 16px;
        margin-top: 0;
        margin-bottom: 16px;
    }
    label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #444;
    }
    input[type=text] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d5d9e0;
        border-radius: 6px;
        font-size: 14px;
        margin-bottom: 16px;
    }
    button {
        background: #2563eb;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
    }
    button:hover {
        background: #1d4ed8;
    }
    .result {
        margin-top: 16px;
        background: #f6f8fa;
        border: 1px solid #e2e5ea;
        border-radius: 6px;
        padding: 12px;
        font-family: Consolas, monospace;
        font-size: 13px;
        word-break: break-all;
        position: relative;
    }
    .result-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 6px;
        font-family: Segoe UI, Arial, sans-serif;
    }
    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 8px;
    }
    .badge.ok {
        background: #dcfce7;
        color: #15803d;
    }
    .badge.fail {
        background: #fee2e2;
        color: #b91c1c;
    }
    .copy-btn {
        background: #eee;
        color: #333;
        border: 1px solid #ccc;
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 5px;
        margin-top: 8px;
        cursor: pointer;
    }
    .copy-btn:hover {
        background: #ddd;
    }
    .warn {
        font-size: 12px;
        color: #92400e;
        background: #fef3c7;
        border: 1px solid #fde68a;
        padding: 10px 12px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
<div class="container">

    <marquee><center><b>Password Hash Generator</b></center></marquee>
    <p class="subtitle"><center>Tools untuk generate & verifikasi bcrypt hash</center></p>

    <div class="warn">
        <b>⚠️ Hanya untuk development di localhost. Jangan upload file ini ke server publik!.</b>
    </div>

    <!-- CARD 1: GENERATE HASH -->
    <div class="card">
        <h2>1. Generate Hash dari Password</h2>
        <form method="POST">
            <input type="hidden" name="action" value="generate">
            <label for="password">Password (plain text)</label>
            <input type="text" id="password" name="password" placeholder="Contoh: password123" value="<?= htmlspecialchars($plain_password) ?>" required>
            <button type="submit">Generate Hash</button>
        </form>

        <?php if ($hash_result !== null): ?>
            <div class="result">
                <div class="result-label">Hasil Hash = (algoritma: <?= password_get_info($hash_result)['algoName'] ?>)</div>
                <div id="hashOutput"><?= htmlspecialchars($hash_result) ?></div>
                <button type="button" class="copy-btn" onclick="copyHash()">Copy Hash</button>
            </div>
        <?php endif; ?>
    </div>

    <!-- CARD 2: VERIFY HASH -->
    <div class="card">
        <h2>2. Verifikasi Password vs Hash</h2>
        <form method="POST">
            <input type="hidden" name="action" value="verify">
            <label for="verify_password">Password (plain text)</label>
            <input type="text" id="verify_password" name="verify_password" placeholder="Contoh: password123" value="<?= htmlspecialchars($verify_password) ?>" required>

            <label for="verify_hash">Hash dari database</label>
            <input type="text" id="verify_hash" name="verify_hash" placeholder="Tempel hash di sini ($2y$10$...)" value="<?= htmlspecialchars($verify_hash) ?>" required>

            <button type="submit">Cek Kecocokan</button>
        </form>

        <?php if ($verify_result !== null): ?>
            <?php if ($verify_result): ?>
                <div class="badge ok">✔ Cocok — password ini valid untuk hash tersebut</div>
            <?php else: ?>
                <div class="badge fail">✘ Tidak cocok</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</div>

<script>
function copyHash() {
    const text = document.getElementById('hashOutput').innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Hash berhasil dicopy!');
    });
}
</script>
</body>
</html>
