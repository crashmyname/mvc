<section class="section">
    <div class="section-header">
        <h1>Instalasi</h1>
    </div>

    <div class="section-body">
        <b>Pengguna tinggal Clone project ini</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'git clone https://github.com/crashmyname/mvc.git';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
    Ubah nama project menjadi projek masing-masing, dan rubah $_ENV['ROUTE_PREFIX'] menjadi nama project masing masing;
    <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
    echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
    echo htmlentities('.env');
    echo '<br>';
    echo '<br>';
    echo 'DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdatabase
DB_USERNAME=yourusername
DB_PASSWORD=yourpassword
ROUTE_PREFIX=/mvc <b style="color:red"><-- disini</b>';
    echo '</code>';
    echo '</pre>';
    ?>
    lalu anda sudah bisa memulai membuat project yang kamu inginkan
    <br><br>
    <h4>Struktur Folder</h4>
    <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
    echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
    echo 'YourProject';
    echo '<br>';
    echo '|___bin';
    echo '<br>';
    echo '     |___support';
    echo '<br>';
    echo '|___config';
    echo '<br>';
    echo '|___Controller';
    echo '<br>';
    echo '|___Model';
    echo '<br>';
    echo '|___node_modules';
    echo '<br>';
    echo '|___public';
    echo '<br>';
    echo '|___View';
    echo '<br>';
    echo '     |___errors <-- untuk menangani custom error';
    echo '<br>';
    echo '.env';
    echo '<br>';
    echo '.env.example';
    echo '<br>';
    echo '.htaccess';
    echo '<br>';
    echo 'autoload.php';
    echo '<br>';
    echo 'index.php';
    echo '<br>';
    echo 'route.php';
    echo '<br>';
    echo '</code>';
    echo '</pre>';
    ?>
</section>
