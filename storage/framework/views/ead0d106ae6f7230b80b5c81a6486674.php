<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'RuangKelas Admin'); ?></title>

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo.png')); ?>">

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

    <?php
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
        $adminCss = $manifest['resources/css/app.css']['file'] ?? null;
        $adminJs = $manifest['resources/js/app.js']['file'] ?? null;
    ?>

    <?php if($adminCss): ?>
        <link rel="stylesheet" href="<?php echo e(asset('build/'.$adminCss)); ?>">
    <?php endif; ?>

    <?php if($adminJs): ?>
        <script type="module" src="<?php echo e(asset('build/'.$adminJs)); ?>"></script>
    <?php endif; ?>

    <style>
        :root {
            --admin-bg: #f6f7fb;
            --panel: rgba(255, 255, 255, 0.78);
            --glass-border: rgba(148, 163, 184, 0.18);
            --text-strong: #111827;
            --text-muted: #6b7280;
            --accent: #f97316;
            --accent-2: #fb923c;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            background: var(--admin-bg);
            color: var(--text-strong);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .glass {
            background: var(--panel);
            border: 1px solid var(--glass-border);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.04);
            backdrop-filter: blur(18px);
        }

        .ui-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: transform 0.16s ease, box-shadow 0.16s ease, opacity 0.16s ease;
            box-shadow: 0 10px 22px rgba(249, 115, 22, 0.22);
        }

        .ui-btn:hover {
            opacity: 0.96;
            transform: translateY(-1px);
        }

        .ui-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\coursify\resources\views/layouts/admin.blade.php ENDPATH**/ ?>