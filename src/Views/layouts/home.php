<!DOCTYPE html>
<html lang="<?= App\Services\Language::getCurrentLang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jules Vialas</title>
    <meta name="description" content="<?= App\Services\Language::get('meta.description') ?>">
    <link rel="icon" type="image/x-icon" href="/assets/images/logo.ico">
    
    <!-- Bootstrap CSS uniquement -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    
    <!-- Bootstrap JS uniquement -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script></script>
    
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>
</html>