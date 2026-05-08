<?php
function project_data_directory_path() {
    $directory = __DIR__ . '/../data';

    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    return $directory;
}

function project_data_file_path($fileName) {
    $dataPath = project_data_directory_path() . '/' . $fileName;
    $legacyPath = __DIR__ . '/../' . $fileName;

    $dataExists = file_exists($dataPath);
    $dataHasContent = $dataExists && filesize($dataPath) > 0;
    $legacyHasContent = file_exists($legacyPath) && filesize($legacyPath) > 0;

    if (!$dataHasContent && $legacyHasContent) {
        if (!@rename($legacyPath, $dataPath)) {
            $legacyContent = file_get_contents($legacyPath);

            if ($legacyContent !== false) {
                file_put_contents($dataPath, $legacyContent, LOCK_EX);
                @unlink($legacyPath);
            }
        }

        return $dataPath;
    }

    if (!$dataExists) {
        file_put_contents($dataPath, '', LOCK_EX);
    }

    if ($dataHasContent && file_exists($legacyPath) && filesize($legacyPath) === 0) {
        @unlink($legacyPath);
    }

    return $dataPath;
}

function project_user_data_path() {
    return project_data_file_path('user_data.txt');
}

function project_seller_products_path() {
    return project_data_file_path('seller_products.json');
}

function project_seller_transactions_path() {
    return project_data_file_path('seller_transactions.json');
}

function project_seller_phone_data_path() {
    return project_data_file_path('sellerPhone_data.txt');
}
?>